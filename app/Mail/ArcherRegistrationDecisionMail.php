<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use InvalidArgumentException;

class ArcherRegistrationDecisionMail extends Mailable implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    public array $backoff = [30, 120];

    public function __construct(
        public string $archerName,
        public string $registrationStatus,
        public string $reference,
        public ?string $archerNumber = null,
        public ?string $rejectionReason = null,
    ) {
        if (! in_array($registrationStatus, ['approved', 'rejected'], true)) {
            throw new InvalidArgumentException('Only approved or rejected registrations can send decision emails.');
        }

        $this->afterCommit();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Archer registration '.$this->registrationStatus.' - Qurtuba Furusiyyah',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-decision',
            text: 'emails.registration-decision-text',
        );
    }
}
