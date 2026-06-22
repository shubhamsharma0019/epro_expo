<?php

namespace App\Support;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Visitor\Models\Visitor;

class ExhibitionTicketFlow
{
    /**
     * Visitor dashboard sidebar should only appear after a completed pass exists.
     */
    public static function shouldShowVisitorSidebar(?string $slug): bool
    {
        if (! filled($slug)) {
            return false;
        }

        $exhibition = Exhibition::query()->where('slug', $slug)->first();
        if (! $exhibition) {
            return false;
        }

        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');

        if ($bookingId) {
            $hasCompletedBooking = Visitor::query()
                ->where('booking_id', $bookingId)
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->exists();

            if ($hasCompletedBooking) {
                session([
                    'visitor_pass_active' => true,
                    'selected_visitor_booking_id' => $bookingId,
                ]);

                return true;
            }
        }

        if (auth()->check()) {
            $visitor = Visitor::query()
                ->where('email', auth()->user()->email)
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->first();

            if ($visitor) {
                session([
                    'visitor_pass_active' => true,
                    'selected_visitor_booking_id' => $visitor->booking_id,
                ]);

                return true;
            }
        }

        if (session('visitor_pass_active', false) && session('activeExhibitionSlug') === $slug) {
            return Visitor::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->when(auth()->check(), fn ($query) => $query->where('email', auth()->user()->email))
                ->when(
                    session('selected_visitor_booking_id'),
                    fn ($query, $selectedBookingId) => $query->where('booking_id', $selectedBookingId)
                )
                ->exists();
        }

        return false;
    }
}
