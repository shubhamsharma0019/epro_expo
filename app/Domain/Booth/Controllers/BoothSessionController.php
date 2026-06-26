<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothSessionRequest;
use App\Http\Requests\Company\BoothSessionMeetingSetupRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMeetingAvailability;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Booth\Services\BoothSetupStepService;
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
            'sessions' => $sessionsQuery->get(),
            'teamMembers' => $booking->boothTeamMembers()->where('status', 'active')->get(),
            'sessionCounts' => $counts,
            'activeStatus' => $status,
            'activeSort' => $sort,
            'availability' => $booking->boothMeetingAvailability,
        ]);
    }
    public function create(BoothBooking $booking, BoothSetupStepService $steps): View { return $this->index($booking, $steps); }
    public function show(BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps): View { return $this->edit($booking, $session, $steps); }
    public function store(BoothSessionRequest $request, BoothBooking $booking, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        BoothSession::create($request->validated() + ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id]);
        $this->syncSessionStep($booking, $steps);
        return back()->with('status', 'Session saved.');
    }
    public function edit(BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps): View
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        return $this->index($booking, $steps)->with('session', $session);
    }
    public function update(BoothSessionRequest $request, BoothBooking $booking, BoothSession $session, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($session->company_id === (int) session('company_id') && $session->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $session->update($request->validated());
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

    private function defaultMeetingAvailabilityData(BoothBooking $booking): array
    {
        $defaultStart = $booking->exhibition?->start_date ?? now();
        $defaultEnd = $booking->exhibition?->end_date ?? $defaultStart;

        return [
            'company_id' => $booking->company_id,
            'booth_booking_id' => $booking->id,
            'available_start_date' => $defaultStart,
            'available_end_date' => $defaultEnd,
            'available_weekdays' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'daily_start_time' => '09:00:00',
            'daily_end_time' => '18:00:00',
            'meeting_types' => ['video'],
            'slot_duration' => 30,
            'buffer_time' => 10,
            'timezone' => 'Asia/Kolkata',
            'max_capacity' => 1,
            'allow_one_to_one' => true,
            'allow_one_to_many' => false,
            'allow_conference' => false,
        ];
    }

    private function syncSessionStep(BoothBooking $booking, BoothSetupStepService $steps): void
    {
        $booking->boothSessions()->exists()
            ? $steps->markStepCompleted($booking, 'sessions')
            : $steps->markStepPending($booking, 'sessions');
    }
}
