<?php

namespace App\Domain\Visitor\Repositories;

use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Domain\Visitor\Models\Bookmark;

class VisitorRepository
{
    public function findByBookingId(string $bookingId): ?Visitor
    {
        return Visitor::where('booking_id', $bookingId)->first();
    }

    public function getTicketsForUser(int $userId)
    {
        return VisitorTicket::where('user_id', $userId)
            ->with(['companyEvent', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findTicket(int $id): ?VisitorTicket
    {
        return VisitorTicket::find($id);
    }

    public function getBookmarks(string $bookingId)
    {
        return Bookmark::where('booking_id', $bookingId)->get();
    }
}
