<?php

namespace App\Mail;

use App\Models\ConsultationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationSubmittedUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public ConsultationRequest $consultation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your consultation request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-user',
            with: [
                'c' => $this->consultation,
            ],
        );
    }
}

