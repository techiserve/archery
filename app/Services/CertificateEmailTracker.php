<?php

namespace App\Services;

use App\Models\Eventscore;

class CertificateEmailTracker
{
    public function queued(Eventscore $eventScore, ?string $recipient): void
    {
        $eventScore->forceFill([
            'certificate_email_status' => 'queued',
            'certificate_email_address' => $recipient ?: null,
            'certificate_email_error' => null,
        ])->save();
    }

    public function start(Eventscore $eventScore, ?string $recipient): void
    {
        $eventScore->forceFill([
            'certificate_email_status' => 'processing',
            'certificate_email_address' => $recipient ?: null,
            'certificate_email_attempts' => (int) $eventScore->certificate_email_attempts + 1,
            'certificate_email_last_attempted_at' => now(),
            'certificate_email_error' => null,
        ])->save();
    }

    public function sent(Eventscore $eventScore): void
    {
        $eventScore->forceFill([
            'certificate_email_status' => 'sent',
            'certificate_email_sent_at' => now(),
            'certificate_email_error' => null,
        ])->save();
    }

    public function failed(Eventscore $eventScore, string $message): void
    {
        $eventScore->forceFill([
            'certificate_email_status' => 'failed',
            'certificate_email_error' => $message,
        ])->save();
    }
}
