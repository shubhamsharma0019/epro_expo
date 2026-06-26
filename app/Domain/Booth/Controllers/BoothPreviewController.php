<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothPreviewController extends BaseBoothSetupController
{
    public function show(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);

        $booking->loadMissing([
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
            'boothTeamMembers',
            'boothSessions.teamMember',
            'boothMeetingSlots',
        ]);

        return view('company.booth-setup.preview', $this->commonData($booking, $steps) + [
            'products' => $booking->boothProducts
                ->sortBy([['sort_order', 'asc'], ['created_at', 'desc']])
                ->values(),
            'documents' => $booking->boothDocuments
                ->sortByDesc('created_at')
                ->values(),
            'catalogues' => $booking->boothCatalogues
                ->sortByDesc('created_at')
                ->values(),
            'mediaItems' => $booking->boothMedia
                ->sortBy([['sort_order', 'asc'], ['created_at', 'desc']])
                ->values(),
            'teamMembers' => $booking->boothTeamMembers
                ->sortByDesc('created_at')
                ->values(),
            'sessions' => $booking->boothSessions
                ->sortBy([['session_date', 'asc'], ['start_time', 'asc']])
                ->values(),
            'availableMeetingSlots' => $booking->boothMeetingSlots
                ->where('status', 'available')
                ->sortBy([['date', 'asc'], ['start_time', 'asc']])
                ->values(),
        ]);
    }

    public function markReady(BoothBooking $booking, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $booking->update(['booth_setup_status' => 'ready_to_publish']);
        $steps->markStepCompleted($booking, 'preview');

        if (request('next') === 'publish') {
            return redirect()
                ->route('company.booth-setup.publish.show', $booking)
                ->with('status', 'Preview marked as ready.');
        }

        return back()->with('status', 'Preview marked as ready.');
    }
}
