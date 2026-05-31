<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BoothBooking;
use App\Services\Company\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;

abstract class BaseBoothSetupController extends Controller
{
    protected function ownedBooking(BoothBooking $booking): BoothBooking
    {
        abort_unless($booking->company_id === (int) session('company_id'), 403);

        return $booking->loadMissing([
            'company',
            'exhibition',
            'pavilion',
            'hall',
            'booth',
            'boothSize',
            'boothProfile',
            'boothBranding',
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
            'boothTeamMembers',
            'boothMeetingAvailability',
            'boothMeetingSlots',
            'boothSessions',
            'boothPublishRequest',
        ]);
    }

    protected function setupBooking(BoothBooking $booking): BoothBooking
    {
        $booking = $this->ownedBooking($booking);
        $this->ensureSetupAllowed($booking);

        return $booking;
    }

    protected function latestOwnedPaidBooking(): BoothBooking|RedirectResponse
    {
        $booking = BoothBooking::where('company_id', (int) session('company_id'))
            ->where('payment_status', 'paid')
            ->where('booking_status', 'confirmed')
            ->latest()
            ->first();

        if (! $booking) {
            return redirect('/company/booth-booking/pavilions')
                ->with('status', 'Please book and pay for a booth before starting setup.');
        }

        return $this->ownedBooking($booking);
    }

    protected function ensureSetupAllowed(BoothBooking $booking): void
    {
        abort_unless($booking->payment_status === 'paid' && $booking->booking_status === 'confirmed', 403);
    }

    protected function commonData(BoothBooking $booking, BoothSetupStepService $steps): array
    {
        $steps->createDefaultSteps($booking);

        return [
            'booking' => $this->ownedBooking($booking),
            'steps' => $steps->getSteps($booking),
            'progress' => $steps->getProgress($booking),
        ];
    }
}
