<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothSessionRequest;
use App\Http\Requests\Company\BoothSessionMeetingSetupRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMeetingAvailability;
use App\Support\BoothMeetingAvailabilityDefaults;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Booth\Services\BoothSessionConferenceService;
use App\Domain\Booth\Services\BoothSetupStepService;
use App\Domain\Shared\Services\GoogleMeetService;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothSessionController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $status = request('status', 'all');
        $sort = request('sort', 'upcoming');
        $sessionsQuery = $booking->boothSessions()->with('teamMember');
        $counts = [
            'all' => (clone $sessionsQuery)->count(),
            'upcoming' => (clone $sessionsQuery)->where('status', 'upcoming')->count(),
            'live' => (clone $sessionsQuery)->where('status', 'live')->count(),
            'completed' => (clone $sessionsQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $sessionsQuery)->where('status', 'cancelled')->count(),
        ];

        if (in_array($status, ['upcoming', 'live', 'completed', 'cancelled'], true)) {
            $sessionsQuery->where('status', $status);
        }

        match ($sort) {
            'oldest' => $sessionsQuery->orderBy('session_date')->orderBy('start_time'),
            'title' => $sessionsQuery->orderBy('title'),
            'created' => $sessionsQuery->latest(),
            default => $sessionsQuery->orderByRaw("CASE status WHEN 'live' THEN 0 WHEN 'upcoming' THEN 1 WHEN 'completed' THEN 2 ELSE 3 END")
                ->orderBy('session_date')
                ->orderBy('start_time'),
        };

        return view('company.booth-setup.sessions', $this->commonData($booking, $steps) + [
            'sessions' => $sessionsQuery->with('companyMeeting')->get(),
            'teamMembers' => $booking->boothTeamMembers()->where('status', 'active')->get(),
            'sessionCounts' => $counts,
            'activeStatus' => $status,
            'activeSort' => $sort,
            'availability' => $booking->boothMeetingAvailability,
            'sessionJoinRequests' => VisitorMeetingBooking::query()
                ->whereIn('booth_session_id', $booking->boothSessions()->pluck('id'))
                ->whereNotNull('booth_session_id')
                ->whereNotNull('join_requested_at')
                ->whereIn('status', ['pending', 'waitlisted'])
                ->with(['boothSession', 'companyMeeting'])
                ->latest('join_requested_at')
                ->get(),
        ]);
    }
    public function create(BoothBooking $booking, BoothSetupStepService $steps): View { return $this->index($booking, $steps); }
    public function show(BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps): View { return $this->edit($booking, $session, $steps); }
    public function store(BoothSessionRequest $request, BoothBooking $booking, BoothSetupStepService $steps, BoothSessionConferenceService $conference): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $session = BoothSession::create($request->validated() + ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id]);
        $conference->syncConferenceMeeting($session);
        $notified = $conference->notifyExhibitionPassHolders($session->fresh());
        $this->syncSessionStep($booking, $steps);

        $message = 'Session saved.';
        if ($notified > 0) {
            $message .= ' ' . $notified . ' exhibition pass holder(s) were notified.';
        }

        return back()->with('status', $message);
    }
    public function edit(BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps): View
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        return $this->index($booking, $steps)->with('session', $session);
    }
    public function update(BoothSessionRequest $request, BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps, BoothSessionConferenceService $conference): RedirectResponse
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $wasLive = $session->status === 'live';
        $session->update($request->validated());
        $session = $session->fresh();
        $conference->syncConferenceMeeting($session);

        if ($session->status === 'live' && ! $wasLive) {
            $conference->broadcastSessionLive(
                $session,
                $session->companyMeeting?->zoom_join_url ?: $session->companyMeeting?->meeting_link
            );
        }

        $this->syncSessionStep($booking, $steps);

        return back()->with('status', 'Session updated.');
    }
    public function destroy(BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $session->delete();
        $this->syncSessionStep($booking, $steps);
        return back()->with('status', 'Session deleted.');
    }

    public function updateMeetingSetup(BoothSessionMeetingSetupRequest $request, BoothBooking $booking): RedirectResponse
    {
        $booking = $this->setupBooking($booking);

        $flags = [
            'allow_one_to_one' => $request->boolean('allow_one_to_one'),
            'allow_one_to_many' => $request->boolean('allow_one_to_many'),
            'allow_conference' => $request->boolean('allow_conference'),
        ];

        $conferenceCapacity = $request->integer('conference_capacity');
        if ($flags['allow_conference'] && $conferenceCapacity > 0) {
            $flags['max_capacity'] = max($conferenceCapacity, (int) ($booking->boothMeetingAvailability?->max_capacity ?? 1));
        }

        $availability = $booking->boothMeetingAvailability;

        if ($availability) {
            $availability->update($flags);
        } else {
            BoothMeetingAvailability::create($this->defaultMeetingAvailabilityData($booking) + $flags);
        }

        return back()->with('meeting_setup_status', 'Meeting setup preferences saved.');
    }

    public function createMeet(BoothBooking $booking, BoothSession $session, BoothSessionConferenceService $conference, GoogleMeetService $googleMeetService): RedirectResponse
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);

        $joinUrl = $conference->provisionGoogleMeet($session, $googleMeetService);

        if (! $joinUrl) {
            return back()->with('error', 'Google Meet is not configured or the link could not be created. Add GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, and GOOGLE_REFRESH_TOKEN to .env.');
        }

        return redirect()->away($joinUrl);
    }

    public function startConference(BoothBooking $booking, BoothSession $session, BoothSessionConferenceService $conference, GoogleMeetService $googleMeetService): RedirectResponse
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);

        $result = $conference->startConference($session, $googleMeetService);

        if ($result['host_url']) {
            return redirect()->away($result['host_url']);
        }

        return back()->with('error', 'Conference marked live but Google Meet link is not available yet. Create the Meet link first.');
    }

    public function approveJoinRequest(
        BoothBooking $booking,
        BoothSession $session,
        VisitorMeetingBooking $visitorBooking,
        BoothSessionConferenceService $conference,
        GoogleMeetService $googleMeetService
    ): RedirectResponse {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);
        abort_unless((int) $visitorBooking->booth_session_id === (int) $session->id, 404);
        abort_unless((int) $visitorBooking->company_id === (int) session('company_id'), 403);

        try {
            $result = $conference->approveJoinRequest($visitorBooking, $googleMeetService);
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }

        if (! empty($result['host_url'])) {
            return redirect()->away($result['host_url']);
        }

        return back()->with('status', 'Join request approved. Add a Google Meet link from Create Meet if visitors cannot join yet.');
    }

    private function defaultMeetingAvailabilityData(BoothBooking $booking): array
    {
        return BoothMeetingAvailabilityDefaults::forBooking($booking);
    }

    private function syncSessionStep(BoothBooking $booking, BoothSetupStepService $steps): void
    {
        $booking->boothSessions()->exists()
            ? $steps->markStepCompleted($booking, 'sessions')
            : $steps->markStepPending($booking, 'sessions');
    }
}
