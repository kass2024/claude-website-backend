<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use App\Services\QuotePdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteApprovedUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $quote)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('Your quote is ready (Request #%d)', $this->quote->id),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-approved-user',
            with: [
                'q' => $this->quote,
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $service = new QuotePdfService();
        $id = (int) $this->quote->id;

        return [
            Attachment::fromData(
                fn () => $service->render($this->quote),
                "quotation-{$id}.pdf"
            )->withMime('application/pdf'),
        ];
    }
}

