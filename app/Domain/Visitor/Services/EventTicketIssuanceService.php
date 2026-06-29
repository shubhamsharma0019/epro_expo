<?php

namespace App\Domain\Visitor\Services;

use App\Domain\Visitor\Models\Booking;
use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Domain\Shared\Models\User;
use App\Support\EventTicketQr;
use App\Support\EventTicketSchema;
use Illuminate\Support\Str;

class EventTicketIssuanceService
{
    public function issueFromVisitorTicket(VisitorTicket $visitorTicket, User $user): ?Ticket
    {
        if (! EventTicketSchema::isReady()) {
            return null;
        }

        $booking = Booking::query()
            ->where('visitor_ticket_id', $visitorTicket->id)
            ->first();

        if ($booking) {
            $existing = $booking->tickets()->first();

            if ($existing) {
                return $existing;
            }
        } else {
            $booking = Booking::create([
                'user_id' => $user->id,
                'company_event_id' => $visitorTicket->company_event_id,
                'ticket_type_id' => $visitorTicket->ticket_type_id,
                'visitor_ticket_id' => $visitorTicket->id,
                'booking_number' => $visitorTicket->order_number,
                'ticket_type' => $visitorTicket->ticket_name,
                'quantity' => (int) $visitorTicket->quantity,
                'amount' => $visitorTicket->total_amount,
                'payment_status' => $visitorTicket->payment_status ?? 'paid',
                'razorpay_order_id' => $visitorTicket->razorpay_order_id,
                'razorpay_payment_id' => $visitorTicket->razorpay_payment_id,
                'status' => 'confirmed',
                'meta' => [
                    'event_slug' => $visitorTicket->event_slug,
                    'attendee_name' => $visitorTicket->attendee_name,
                    'attendee_email' => $visitorTicket->attendee_email,
                ],
            ]);
        }

        $qrToken = (string) Str::uuid();
        $qrUrl = EventTicketQr::scannableUrlForToken($qrToken);

        $ticket = Ticket::create([
            'ticket_no' => $this->generateTicketNumber(),
            'booking_id' => $booking->id,
            'visitor_id' => $user->id,
            'event_id' => $visitorTicket->company_event_id,
            'ticket_type' => $visitorTicket->ticket_name,
            'quantity' => (int) $visitorTicket->quantity,
            'qr_token' => $qrToken,
            'qr_url' => $qrUrl,
            'status' => 'confirmed',
            'checked_in' => false,
            'payment_status' => $visitorTicket->payment_status ?? 'paid',
            'amount' => $visitorTicket->total_amount,
            'meta' => [
                'attendee_name' => $visitorTicket->attendee_name,
                'attendee_email' => $visitorTicket->attendee_email,
                'attendee_phone' => $visitorTicket->attendee_phone,
            ],
        ]);

        $visitorTicket->update([
            'qr_code_path' => $qrUrl,
        ]);

        return $ticket;
    }

    private function generateTicketNumber(): string
    {
        $year = now()->format('Y');
        $prefix = 'TKT' . $year;

        $latest = Ticket::withTrashed()
            ->where('ticket_no', 'like', $prefix . '%')
            ->orderByDesc('ticket_no')
            ->value('ticket_no');

        $sequence = 1;

        if ($latest && preg_match('/^TKT\d{4}(\d+)$/', $latest, $matches)) {
            $sequence = ((int) $matches[1]) + 1;
        }

        return $prefix . str_pad((string) $sequence, 5, '0', STR_PAD_LEFT);
    }
}
