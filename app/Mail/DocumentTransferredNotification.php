<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class DocumentTransferredNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $attachmentPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Event $event, ?string $attachmentPath = null)
    {
        $this->event = $event;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dokumen Agenda: ' . $this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event-transferred',
            with: [
                'event' => $this->event,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            $mime = mime_content_type($this->attachmentPath) ?: null;
            return [
                Attachment::fromPath($this->attachmentPath)->as(basename($this->attachmentPath))->withMime($mime),
            ];
        }

        return [];
    }
}
