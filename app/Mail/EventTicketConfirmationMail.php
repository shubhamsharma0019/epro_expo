<?php

namespace App\Mail;

use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\EventTicketQr;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventTicketConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public VisitorTicket $ticket)
    {
        $this->ticket->loadMissing(['companyEvent', 'ticketType', 'user']);
    }

    public function envelope(): Envelope
    {
        $eventName = $this->ticket->companyEvent?->title ?? 'Event';

        return new Envelope(
            subject: 'Your Event Ticket — ' . $eventName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-ticket-confirmation',
            with: [
                'ticket' => $this->ticket,
                'qrImageUrl' => EventTicketQr::imageUrl($this->ticket, 180),
            ],
        );
    }
}
