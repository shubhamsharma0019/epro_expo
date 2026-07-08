<?php

namespace App\Mail;

use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\EventTicketQr;
use App\Support\EventTicketSchema;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Support\EventTicketMail;
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
        $fromAddress = EventTicketMail::fromAddress();

        return new Envelope(
            from: $fromAddress ? new Address($fromAddress, (string) config('mail.from.name', 'EproExpo')) : null,
            subject: 'Your Event Ticket - ' . $eventName,
        );
    }

    public function content(): Content
    {
        EventTicketMail::ensureIssuedTicket($this->ticket);

        $issuedTicket = $this->resolveIssuedTicket();
        $verificationUrl = $issuedTicket
            ? EventTicketQr::scannableUrlForTicket($issuedTicket)
            : EventTicketQr::payload($this->ticket);

        return new Content(
            view: 'emails.event-ticket-confirmation',
            with: [
                'ticket' => $this->ticket,
                'issuedTicket' => $issuedTicket,
                'qrEmailHtml' => EventTicketQr::generateEmailHtml($verificationUrl, 6),
                'verificationUrl' => $verificationUrl,
                'qrTicketUrl' => $issuedTicket
                    ? EventTicketQr::absoluteUrl('qr-ticket.show', ['ticket' => $issuedTicket])
                    : url(route('events.tickets.e-ticket', ['order' => $this->ticket->order_number], false)),
            ],
        );
    }

    private function resolveIssuedTicket(): ?Ticket
    {
        if (! EventTicketSchema::isReady()) {
            return null;
        }

        return Ticket::query()
            ->whereHas('booking', fn ($query) => $query->where('visitor_ticket_id', $this->ticket->id))
            ->first();
    }
}
