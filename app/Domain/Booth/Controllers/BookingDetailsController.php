<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use Illuminate\View\View;

class BookingDetailsController extends BaseBoothSetupController
{
    public function show(BoothBooking $booking): View
    {
        $booking = $this->ownedBooking($booking);

        return view('company.bookings.booking-details', [
            'booking' => $booking,
            'bookingServices' => $booking->services()->get(),
            'bookingDays' => $booking->days()->orderBy('booking_date')->get(),
        ]);
    }

    public function invoice(BoothBooking $booking): View
    {
        $booking = $this->ownedBooking($booking);
        abort_unless($booking->payment_status === 'paid', 404);

        return view('company.bookings.invoice', [
            'booking' => $booking,
            'bookingServices' => $booking->services()->get(),
            'bookingDays' => $booking->days()->orderBy('booking_date')->get(),
        ]);
    }
}
