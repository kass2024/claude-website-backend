<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequestedAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $quote)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('New quote request #%d', $this->quote->id),
            replyTo: [
                new Address($this->quote->email, $this->quote->full_name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-requested-admin',
            with: [
                'q' => $this->quote,
            ],
        );
    }
}

