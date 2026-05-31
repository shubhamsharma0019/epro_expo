<?php

namespace App\Http\Controllers\Company;

use App\Models\BoothBooking;
use Illuminate\View\View;

class BookingDetailsController extends BaseBoothSetupController
{
    public function show(BoothBooking $booking): View
    {
        $booking = $this->ownedBooking($booking);

        return view('company.bookings.show', [
            'booking' => $booking,
            'bookingServices' => $booking->services()->get(),
            'bookingDays' => $booking->days()->orderBy('booking_date')->get(),
        ]);
    }
}
