<?php

namespace App\Jobs;

use App\Http\Controllers\GradingController;
use App\Models\CertificateEmailBatch;
use App\Models\Eventscore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendCertificateEmailBatch implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 600;

    public function __construct(public int $batchId)
    {
    }

    public function handle(GradingController $certificates): void
    {
        $batch = CertificateEmailBatch::find($this->batchId);

        if (!$batch) {
            return;
        }

        $batch->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);

        foreach ($batch->event_score_ids ?? [] as $eventScoreId) {
            $this->sendOne($batch->fresh(), $certificates, (int) $eventScoreId);
        }

        $batch->fresh()->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    private function sendOne(CertificateEmailBatch $batch, GradingController $certificates, int $eventScoreId): void
    {
        try {
            $eventScore = Eventscore::findOrFail($eventScoreId);
            $certificate = $certificates->buildCertificate($eventScore);
            $archer = $certificate['archer'];
            $recipient = trim((string) ($archer?->email ?? ''));

            if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Missing or invalid email address.');
            }

            $data = $certificate['data'];
            $body = '<p>Good day,</p>'
                . '<p>Please find attached the grading certificate for <strong>' . e($data['name']) . '</strong>.</p>'
                . '<p>Grading: ' . e($data['grading']) . '<br>'
                . 'Score: ' . e($data['score']) . '<br>'
                . 'Date: ' . e($data['certificateDate']) . '</p>';

            Mail::html($body, function ($message) use ($recipient, $certificate, $data) {
                $message->to($recipient)
                    ->subject('Archery Grading Certificate - ' . $data['name'])
                    ->attachData($certificate['pdf'], $certificate['filename'], [
                        'mime' => 'application/pdf',
                    ]);
            });

            $batch->increment('sent');
        } catch (Throwable $exception) {
            $this->recordFailure($batch, $eventScoreId, $exception->getMessage());
        }
    }

    private function recordFailure(CertificateEmailBatch $batch, int $eventScoreId, string $message): void
    {
        $errors = $batch->errors ?? [];
        $errors[] = [
            'event_score_id' => $eventScoreId,
            'message' => $message,
        ];

        $batch->forceFill([
            'failed' => $batch->failed + 1,
            'errors' => array_slice($errors, -20),
        ])->save();
    }

    public function failed(Throwable $exception): void
    {
        CertificateEmailBatch::where('id', $this->batchId)->update([
            'status' => 'failed',
            'completed_at' => now(),
            'errors' => [[
                'event_score_id' => null,
                'message' => $exception->getMessage(),
            ]],
        ]);
    }
}
