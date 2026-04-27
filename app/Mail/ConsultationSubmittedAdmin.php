<?php

namespace App\Mail;

use App\Models\ConsultationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationSubmittedAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public ConsultationRequest $consultation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('New consultation request #%d', $this->consultation->id),
            replyTo: [
                new Address($this->consultation->email, $this->consultation->full_name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-admin',
            with: [
                'c' => $this->consultation,
            ],
        );
    }
}

