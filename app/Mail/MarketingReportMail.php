<?php

namespace App\Mail;

use App\Models\Marketing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public Marketing $marketing;

    /**
     * Create a new message instance.
     */
    public function __construct(Marketing $marketing) {
        $this->marketing = $marketing;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Weekly Marketing Report - Ref: '.$this->marketing->ref_no,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(
            markdown: 'emails.marketing-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array {
        return [];
    }
}
