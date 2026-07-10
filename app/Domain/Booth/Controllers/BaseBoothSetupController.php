<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;

abstract class BaseBoothSetupController extends Controller
{
    protected function ownedBooking(BoothBooking $booking): BoothBooking
    {
        $sessionCompanyId = (int) session('company_id');

        if ($booking->company_id !== $sessionCompanyId && $this->sessionReferencesBooking($booking)) {
            session()->forget(['company_flow_context', 'company_event_flow_event_id']);
            session(['company_id' => (int) $booking->company_id]);
            session()->save();
            $sessionCompanyId = (int) $booking->company_id;
        }

        abort_unless($booking->company_id === $sessionCompanyId, 403);

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

    protected function sessionReferencesBooking(BoothBooking $booking): bool
    {
        $bookingRefs = [
            session('company_booking_id'),
            data_get(session('company_booth_booking', []), 'booth_booking_id'),
        ];

        $bookingLabels = [
            (string) $booking->id,
            'BOOK-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
        ];

        return collect($bookingRefs)
            ->filter(fn ($reference) => filled($reference))
            ->map(fn ($reference) => (string) $reference)
            ->intersect($bookingLabels)
            ->isNotEmpty();
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
