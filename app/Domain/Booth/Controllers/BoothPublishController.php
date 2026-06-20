<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothPublishController extends BaseBoothSetupController
{
    public function show(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $booking->loadMissing([
            'boothBranding',
            'boothProfile',
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
            'boothTeamMembers',
            'boothMeetingAvailability',
            'boothMeetingSlots',
            'boothSessions',
            'exhibition',
            'hall',
            'booth',
        ]);

        $availability = $booking->boothMeetingAvailability;
        $availableSlots = $booking->boothMeetingSlots->where('status', 'available');
        $startDate = $availability?->available_start_date;
        $endDate = $availability?->available_end_date;

        return view('backend.company.booth-setup.publish', $this->commonData($booking, $steps) + [
            'readiness' => $steps->checkPublishReadiness($booking),
            'publishRequest' => $booking->boothPublishRequest,
            'summaryCounts' => [
                'products' => $booking->boothProducts->count(),
                'documents' => $booking->boothDocuments->count(),
                'catalogues' => $booking->boothCatalogues->count(),
                'media' => $booking->boothMedia->count(),
                'team' => $booking->boothTeamMembers->count(),
                'sessions' => $booking->boothSessions->count(),
                'meeting_slots' => $availableSlots->count(),
            ],
            'availabilitySummary' => [
                'dates' => $startDate && $endDate ? $startDate->format('M d') . ' - ' . $endDate->format('M d, Y') : 'Not configured',
                'days' => $startDate && $endDate ? ((int) $startDate->diffInDays($endDate) + 1) . ' Days' : '-',
                'daily_slots' => $availableSlots->groupBy(fn ($slot) => optional($slot->date)->format('Y-m-d'))->map->count()->max() ?? 0,
                'slot_duration' => $availability?->slot_duration ? $availability->slot_duration . ' Minutes' : '-',
                'total_availability' => $availability?->daily_start_time && $availability?->daily_end_time
                    ? round(\Carbon\Carbon::parse($availability->daily_start_time)->diffInMinutes(\Carbon\Carbon::parse($availability->daily_end_time)) / 60, 1) . ' Hours'
                    : '-',
                'timezone' => $availability?->timezone ?: 'Asia/Kolkata',
            ],
        ]);
    }

    public function submit(BoothBooking $booking, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $readiness = $steps->checkPublishReadiness($booking);
        if (! $readiness['ready']) {
            return back()->withErrors(['publish' => 'Please complete all required setup steps before publishing.']);
        }

        BoothPublishRequest::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $booking->company_id,
                'status' => 'approved',
                'submitted_at' => now(),
                'reviewed_at' => now(),
                'reviewed_by' => null,
            ]
        );
        $booking->update(['booth_setup_status' => 'published']);
        $steps->markStepCompleted($booking, 'publish');

        return redirect()
            ->route('company.dashboard')
            ->with('status', 'Booth activated and is now live.');
    }
}
