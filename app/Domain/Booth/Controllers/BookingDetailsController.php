<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Service;
use App\Domain\Shared\Services\BookingDetailsPageData;
use App\Support\BoothInvoiceData;
use Illuminate\View\View;

class BookingDetailsController extends BaseBoothSetupController
{
    public function show(BoothBooking $booking, BookingDetailsPageData $pageData): View
    {
        $booking = $this->ownedBooking($booking);
        $bookingDays = $booking->days()->orderBy('booking_date')->get();
        $bookingServices = $booking->services()->get();

        return view('company.bookings.booking-details', [
            'booking' => $booking,
            'bookingServices' => $bookingServices,
            'bookingDays' => $bookingDays,
            'page' => $pageData->build($booking, $bookingDays, $bookingServices),
        ]);
    }

    public function services(BoothBooking $booking): View
    {
        $booking = $this->ownedBooking($booking);

        Service::syncDefaultCatalog();

        $services = Service::where('status', 'active')->orderBy('id')->get();
        $bookingServices = $booking->services()
            ->get()
            ->keyBy('id');
        $selectedTotal = (float) $bookingServices->sum(fn ($service) => (float) ($service->pivot->total ?? 0));

        return view('company.bookings.booking-services', [
            'booking' => $booking,
            'services' => $services,
            'bookingServices' => $bookingServices,
            'selectedCount' => $bookingServices->count(),
            'selectedTotal' => $selectedTotal,
            'currencySymbol' => config('invoice.currency_symbol', '₹'),
            'readOnly' => $booking->payment_status === 'paid',
        ]);
    }

    public function invoice(BoothBooking $booking): View
    {
        $booking = $this->ownedBooking($booking);
        abort_unless($booking->payment_status === 'paid', 404);

        $booking->load([
            'company',
            'exhibition',
            'pavilion',
            'hall',
            'booth',
            'boothSize',
            'boothProfile',
        ]);

        $bookingDays = $booking->days()->orderBy('booking_date')->get();
        $bookingServices = $booking->services()->get();

        $invoice = BoothInvoiceData::fromBooking($booking, $bookingDays, $bookingServices);

        return view('company.bookings.invoice', compact('booking', 'bookingServices', 'bookingDays', 'invoice'));
    }
}
