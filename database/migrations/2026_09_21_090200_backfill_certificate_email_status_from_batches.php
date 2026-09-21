<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('certificate_email_batches')
            || !Schema::hasColumn('eventscores', 'certificate_email_status')) {
            return;
        }

        $batches = DB::table('certificate_email_batches')
            ->where('status', 'completed')
            ->orderBy('id')
            ->get();

        foreach ($batches as $batch) {
            $eventScoreIds = json_decode((string) $batch->event_score_ids, true) ?: [];
            $errors = collect(json_decode((string) $batch->errors, true) ?: [])
                ->filter(fn ($error) => isset($error['event_score_id']))
                ->keyBy(fn ($error) => (string) $error['event_score_id']);
            $attemptedAt = $batch->completed_at ?: $batch->created_at;

            foreach ($eventScoreIds as $eventScoreId) {
                $eventScore = DB::table('eventscores')
                    ->where('id', $eventScoreId)
                    ->first(['archer_id', 'certificate_email_attempts']);

                if (!$eventScore) {
                    continue;
                }

                $error = $errors->get((string) $eventScoreId);
                $recipient = DB::table('archers')
                    ->where('id', $eventScore->archer_id)
                    ->value('email');
                $values = [
                    'certificate_email_status' => $error ? 'failed' : 'sent',
                    'certificate_email_address' => $recipient,
                    'certificate_email_attempts' => (int) $eventScore->certificate_email_attempts + 1,
                    'certificate_email_last_attempted_at' => $attemptedAt,
                    'certificate_email_error' => $error['message'] ?? null,
                ];

                if (!$error) {
                    $values['certificate_email_sent_at'] = $attemptedAt;
                }

                DB::table('eventscores')
                    ->where('id', $eventScoreId)
                    ->update($values);
            }
        }
    }

    public function down(): void
    {
        // Retain reconstructed delivery history if this migration is rolled back.
    }
};
