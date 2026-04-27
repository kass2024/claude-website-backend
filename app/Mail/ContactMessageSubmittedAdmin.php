<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageSubmittedAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $message)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('New contact message #%d', $this->message->id),
            replyTo: [
                new Address($this->message->email, $this->message->full_name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-admin',
            with: [
                'm' => $this->message,
            ],
        );
    }
}

