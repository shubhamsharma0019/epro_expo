<?php

namespace App\Support;

use App\Domain\Visitor\Models\VisitorTicket;

class EventTicketQr
{
    public static function payload(VisitorTicket $ticket): string
    {
        return json_encode([
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->company_event_id,
            'visitor_id' => $ticket->user_id,
            'booking_code' => $ticket->order_number,
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function imageUrl(VisitorTicket $ticket, int $size = 220): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size
            . '&margin=12&data=' . urlencode(self::payload($ticket));
    }
}
