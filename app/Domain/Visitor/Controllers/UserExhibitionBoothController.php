<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMeetingSlot;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Booth\Models\BoothView;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Shared\Services\SmartSchedulingEngine;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorBoothHubVisit;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Domain\Visitor\Services\SessionRegistrationMeetingService;
use App\Http\Controllers\Controller;
use App\Support\UserVisitorPasses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserExhibitionBoothController extends Controller
{
    public function show(string $slug, string $hallSlug, int $boothId): View|RedirectResponse
    {
        $context = $this->resolveHubContext($slug, $hallSlug, $boothId);

        if ($context instanceof RedirectResponse) {
            return $context;
        }

        ['user' => $user, 'exhibition' => $exhibition, 'hall' => $hall, 'booth' => $booth, 'booking' => $booking, 'visitorPass' => $visitorPass] = $context;

        $this->recordHubVisit($user, $visitorPass, $exhibition, $hall, $booth, $booking);

        $companyName = $booking->boothProfile?->company_name
            ?: $booking->company?->company_name
            ?: $booking->company?->name
            ?: 'Exhibitor';

        $hallTitle = $hall->title ?: 'Hall';

        $upcomingMeetings = VisitorMeetingBooking::query()
            ->with('companyMeeting')
            ->where('company_id', $booking->company_id)
            ->where(function ($query) use ($user) {
                $query->where('visitor_id', $user->id)->orWhere('visitor_email', $user->email);
            })
            ->whereIn('status', ['pending', 'confirmed', 'accepted', 'waitlisted'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (VisitorMeetingBooking $item) => $this->formatScheduleItem($item, $companyName, $hallTitle));

        $sessions = $booking->boothSessions->map(fn ($session) => [
            'title' => $session->title ?: 'Conference Session',
            'datetime' => $this->formatSessionDate($session->session_date, $session->start_time),
            'location' => $hallTitle,
            'icon' => 'fa-calendar-check',
        ]);

        $scheduleItems = $upcomingMeetings->concat($sessions)->take(3)->values();

        $eventPassesCount = VisitorTicket::query()->where('user_id', $user->id)->count()
            + UserVisitorPasses::forUser($user)->where('payment_status', 'completed')->count();
        $upcomingMeetingsCount = VisitorMeetingBooking::query()
            ->where(function ($query) use ($user) {
                $query->where('visitor_id', $user->id)->orWhere('visitor_email', $user->email);
            })
            ->whereIn('status', ['pending', 'confirmed', 'accepted', 'waitlisted'])
            ->count();
        $upcomingSessionsCount = $booking->boothSessions->count();
        $savedItemsCount = VisitorBoothHubVisit::query()->where('user_id', $user->id)->count();

        $registeredSessionIds = VisitorSessionRegistration::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('user_id', $user->id)
            ->pluck('booth_session_id')
            ->all();

        $sessionBookingIds = VisitorMeetingBooking::query()
            ->where('visitor_id', $user->id)
            ->whereIn('booth_session_id', $booking->boothSessions->pluck('id'))
            ->pluck('id', 'booth_session_id')
            ->all();

        $start = $exhibition->start_date;
        $end = $exhibition->end_date;
        $dateLabel = $start && $end
            ? ($start->format('M d') . ' - ' . $end->format('M d, Y'))
            : ($start?->format('M d, Y') ?? 'Date TBD');

        return view('frontend.user.booths.hub', [
            'user' => $user,
            'exhibition' => $exhibition,
            'hall' => $hall,
            'booth' => $booth,
            'booking' => $booking,
            'profile' => $booking->boothProfile,
            'branding' => $booking->boothBranding,
            'companyName' => $companyName,
            'products' => $booking->boothProducts,
            'documents' => $booking->boothDocuments->concat($booking->boothCatalogues),
            'mediaItems' => $booking->boothMedia,
            'sessions' => $booking->boothSessions,
            'scheduleItems' => $scheduleItems,
            'backUrl' => route('frontend.user.exhibitions.halls.show', [$slug, $hallSlug]),
            'heroBannerUrl' => $booking->boothBranding?->booth_banner
                ? asset('storage/' . $booking->boothBranding->booth_banner)
                : ($booking->boothProfile?->booth_banner
                    ? asset('storage/' . $booking->boothProfile->booth_banner)
                    : ($exhibition->banner_url ?: $exhibition->banner_image)),
            'eventMeta' => [
                'date_label' => $dateLabel,
                'time_label' => '09:00 AM - 08:00 PM (IST)',
                'venue' => $exhibition->venue ?: $exhibition->location ?: 'Venue TBD',
                'website' => $booking->boothProfile?->website ?: $booking->company?->website,
                'organized_by' => $exhibition->title ?: $exhibition->name ?: 'Event Organizer',
                'category' => $booking->boothProfile?->industry ?: $booking->company?->industry ?: 'Technology, Conference',
            ],
            'stats' => [
                'upcoming_events' => max($eventPassesCount, $upcomingSessionsCount),
                'meetings' => $upcomingMeetingsCount,
                'saved_items' => $savedItemsCount,
            ],
            'meetingSlots' => $booking->boothMeetingSlots,
            'meetingAvailability' => $booking->boothMeetingAvailability,
            'registeredSessionIds' => $registeredSessionIds,
            'sessionBookingIds' => $sessionBookingIds,
            'slug' => $slug,
            'hallSlug' => $hallSlug,
            'boothId' => $boothId,
        ]);
    }

    public function requestMeeting(Request $request, string $slug, string $hallSlug, int $boothId): RedirectResponse
    {
        $context = $this->resolveHubContext($slug, $hallSlug, $boothId);

        if ($context instanceof RedirectResponse) {
            return $context;
        }

        $user = $context['user'];
        $exhibition = $context['exhibition'];
        $booking = $context['booking'];

        $validated = $request->validate([
            'booth_meeting_slot_id' => ['nullable', 'exists:booth_meeting_slots,id'],
            'meeting_topic' => ['required', 'string', 'max:255'],
            'visitor_name' => ['required', 'string', 'max:255'],
            'visitor_email' => ['required', 'email', 'max:255'],
            'meeting_type' => ['nullable', 'string', 'in:one-to-one,one-to-many'],
            'preferred_date' => ['nullable', 'date'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $availability = $booking->boothMeetingAvailability;
        $reqMeetingType = $validated['meeting_type'] ?? 'one-to-one';

        if ($reqMeetingType === 'one-to-one' && $availability && ! $availability->allow_one_to_one) {
            return back()->with('error', 'One-to-One meetings are not available for this exhibitor.')->withInput();
        }

        if ($reqMeetingType === 'one-to-many' && $availability && ! $availability->allow_one_to_many) {
            return back()->with('error', 'One-to-Many meetings are not available for this exhibitor.')->withInput();
        }

        $slot = null;
        if (! empty($validated['booth_meeting_slot_id'])) {
            $slot = BoothMeetingSlot::query()
                ->where('booth_booking_id', $booking->id)
                ->where('status', 'available')
                ->find($validated['booth_meeting_slot_id']);
        }

        if ($slot) {
            $startTime = $slot->date->format('Y-m-d') . ' ' . $slot->start_time;
            $endTime = $slot->date->format('Y-m-d') . ' ' . $slot->end_time;
            $title = $validated['meeting_topic'];
        } else {
            $preferredDate = $validated['preferred_date'] ?? $this->defaultMeetingDateForExhibition($exhibition);
            $preferredTime = $validated['preferred_time'] ?? '10:00';
            $startTime = $preferredDate . ' ' . $preferredTime;
            $endTime = Carbon::parse($startTime)->addMinutes(30)->format('Y-m-d H:i:s');
            $title = $validated['meeting_topic'];
        }

        $engine = new SmartSchedulingEngine();
        $validation = $engine->validateMeetingRequest(
            $booking->company_id,
            $user->id,
            $validated['visitor_email'],
            Carbon::parse($startTime)->toDateString(),
            Carbon::parse($startTime)->format('H:i:s'),
            $reqMeetingType,
            $booking->exhibition_id,
            $slot?->id
        );

        if (! $validation['valid']) {
            $errorMsg = $validation['conflict'];
            if ($validation['suggest_slot']) {
                $suggested = $validation['suggest_slot'];
                $sDate = Carbon::parse($suggested->date)->format('M d, Y');
                $sTime = Carbon::parse($suggested->start_time)->format('h:i A');
                $errorMsg .= " Suggested next available slot: {$sDate} at {$sTime}.";
            }

            return back()->with('error', $errorMsg)->withInput();
        }

        $isWaitlisted = ($validation['conflict'] === 'waitlist');
        $initialStatus = $isWaitlisted ? 'waitlisted' : 'pending';

        $companyMeeting = CompanyMeeting::create([
            'company_id' => $booking->company_id,
            'title' => $title,
            'meeting_type' => $reqMeetingType,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'description' => $validated['message'] ?? null,
            'meeting_agenda' => $validated['message'] ?? null,
            'meeting_date' => Carbon::parse($startTime)->toDateString(),
            'meeting_time' => Carbon::parse($startTime)->format('H:i:s'),
            'max_attendees' => $slot?->max_capacity ?? ($reqMeetingType === 'one-to-many' ? 10 : 1),
            'status' => $initialStatus,
        ]);

        $visitorBooking = VisitorMeetingBooking::create([
            'company_id' => $booking->company_id,
            'company_meeting_id' => $companyMeeting->id,
            'visitor_id' => $user->id,
            'visitor_name' => $validated['visitor_name'],
            'visitor_email' => $validated['visitor_email'],
            'meeting_topic' => $validated['meeting_topic'],
            'preferred_date' => $validated['preferred_date'] ?? Carbon::parse($startTime)->toDateString(),
            'preferred_time' => $validated['preferred_time'] ?? Carbon::parse($startTime)->format('H:i:s'),
            'message' => $validated['message'] ?? '',
            'status' => $initialStatus,
            'created_by' => $user->id,
        ]);

        if ($slot && ! $isWaitlisted) {
            $maxCapacity = $slot->max_capacity ?? 1;
            $confirmedCount = VisitorMeetingBooking::query()
                ->where('company_id', $booking->company_id)
                ->where(function ($q) use ($slot) {
                    $q->whereHas('companyMeeting', function ($sub) use ($slot) {
                        $sub->where('start_time', $slot->date->format('Y-m-d') . ' ' . $slot->start_time);
                    })->orWhere(function ($sub) use ($slot) {
                        $sub->where('preferred_date', $slot->date->format('Y-m-d'))
                            ->where('preferred_time', $slot->start_time);
                    });
                })
                ->whereIn('status', ['confirmed', 'accepted', 'pending'])
                ->count();

            if ($reqMeetingType === 'one-to-one' || $confirmedCount >= $maxCapacity) {
                $slot->update(['status' => 'booked']);
            }
        }

        DB::table('meeting_notifications')->insert([
            'visitor_id' => $user->id,
            'company_id' => $booking->company_id,
            'visitor_meeting_booking_id' => $visitorBooking->id,
            'type' => 'created',
            'title' => $isWaitlisted ? 'Meeting Waitlisted' : 'Meeting Request Created',
            'message' => ($isWaitlisted ? 'You have been added to the waitlist. ' : '')
                . 'A new meeting request was submitted by ' . $validated['visitor_name']
                . ' regarding "' . $validated['meeting_topic'] . '".',
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('admin_notifications')->insert([
            'title' => 'Meeting Request: ' . $title,
            'type' => 'booking',
            'priority' => 'normal',
            'channel' => 'in_app',
            'status' => 'unread',
            'message' => 'Meeting requested between company #' . $booking->company_id . ' and visitor #' . $user->id . ' on ' . $startTime,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $successMsg = $isWaitlisted
            ? 'The slot is full. You have been placed on the waitlist for this meeting slot.'
            : 'Meeting request sent to ' . ($booking->boothProfile?->company_name ?: 'the exhibitor') . '. They will accept or reject your request.';

        return back()->with('success', $successMsg);
    }

    public function registerSession(string $slug, string $hallSlug, int $boothId, int $sessionId): RedirectResponse
    {
        $context = $this->resolveHubContext($slug, $hallSlug, $boothId);

        if ($context instanceof RedirectResponse) {
            return $context;
        }

        $user = $context['user'];
        $exhibition = $context['exhibition'];
        $booking = $context['booking'];
        $visitorPass = $context['visitorPass'];

        $boothSession = BoothSession::query()
            ->whereKey($sessionId)
            ->where('booth_booking_id', $booking->id)
            ->whereIn('status', ['upcoming', 'live'])
            ->firstOrFail();

        $registration = VisitorSessionRegistration::firstOrCreate(
            [
                'booth_session_id' => $boothSession->id,
                'exhibition_id' => $exhibition->id,
                'visitor_booking_id' => $visitorPass->booking_id,
                'user_id' => $user->id,
            ],
            [
                'visitor_email' => $user->email,
                'status' => 'registered',
            ]
        );

        app(SessionRegistrationMeetingService::class)->syncFromRegistration(
            $registration,
            $boothSession,
            $visitorPass
        );

        return back()->with('success', 'You are registered for "' . ($boothSession->title ?: 'this session') . '". The exhibitor has been notified.');
    }

    /** @return array{user:mixed,exhibition:Exhibition,hall:Hall,booth:Booth,booking:BoothBooking,visitorPass:Visitor}|RedirectResponse */
    private function resolveHubContext(string $slug, string $hallSlug, int $boothId): array|RedirectResponse
    {
        $user = auth()->user();
        $exhibition = Exhibition::query()->where('slug', $slug)->firstOrFail();
        $visitorPass = $this->resolveExhibitionPass($user, $exhibition);

        if (! $visitorPass) {
            return redirect()
                ->route('frontend.user.passes')
                ->with('error', 'You need an active exhibition pass to open exhibitor booths.');
        }

        $hall = Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->where(fn ($query) => $query->where('slug', $hallSlug)->orWhere('id', $hallSlug))
            ->firstOrFail();

        $booth = Booth::query()
            ->where('id', $boothId)
            ->where('hall_id', $hall->id)
            ->firstOrFail();

        $booking = BoothBooking::query()
            ->with([
                'company',
                'boothProfile',
                'boothBranding',
                'hall',
                'booth',
                'exhibition',
                'boothProducts' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order'),
                'boothDocuments' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active'),
                'boothCatalogues' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active'),
                'boothMedia' => fn ($query) => $query->where('status', 'active')->orderBy('sort_order'),
                'boothSessions' => fn ($query) => $query->whereIn('status', ['upcoming', 'live'])->orderBy('session_date')->with('companyMeeting'),
                'boothMeetingSlots' => fn ($query) => $query->where('status', 'available')->orderBy('date')->orderBy('start_time'),
                'boothMeetingAvailability',
            ])
            ->where('exhibition_id', $exhibition->id)
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->where(function ($query) use ($boothId) {
                $query->where('booth_id', $boothId)
                    ->orWhereJsonContains('selected_booth_ids', $boothId);
            })
            ->firstOrFail();

        return compact('user', 'exhibition', 'hall', 'booth', 'booking', 'visitorPass');
    }

    private function defaultMeetingDateForExhibition(?Exhibition $exhibition): string
    {
        $candidate = now()->addDay()->startOfDay();

        if (! $exhibition) {
            return $candidate->toDateString();
        }

        $start = Carbon::parse($exhibition->start_date)->startOfDay();
        $end = Carbon::parse($exhibition->end_date)->endOfDay();

        if (now()->gt($end)) {
            return $candidate->toDateString();
        }

        if ($candidate->lt($start)) {
            return $start->toDateString();
        }

        if ($candidate->gt($end)) {
            return $end->toDateString();
        }

        return $candidate->toDateString();
    }

    private function resolveExhibitionPass($user, Exhibition $exhibition): ?Visitor
    {
        return UserVisitorPasses::queryForUser($user)
            ->where('exhibition_id', $exhibition->id)
            ->where('payment_status', 'completed')
            ->orderByDesc('created_at')
            ->first();
    }

    private function recordHubVisit($user, Visitor $visitorPass, Exhibition $exhibition, Hall $hall, Booth $booth, BoothBooking $booking): void
    {
        try {
            VisitorBoothHubVisit::query()->create([
                'user_id' => $user->id,
                'visitor_pass_id' => $visitorPass->id,
                'exhibition_id' => $exhibition->id,
                'hall_id' => $hall->id,
                'booth_id' => $booth->id,
                'booth_booking_id' => $booking->id,
                'company_id' => $booking->company_id,
                'source' => 'hall_layout',
                'visited_at' => now(),
            ]);

            BoothView::query()->create([
                'company_id' => $booking->company_id,
                'booth_profile_id' => $booking->boothProfile?->id,
                'visitor_id' => $user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'viewed_at' => now(),
            ]);
        } catch (\Throwable) {
            // Analytics should never block the visitor flow.
        }
    }

    /** @return array{title:string,datetime:string,location:string,icon:string} */
    private function formatScheduleItem(VisitorMeetingBooking $booking, string $companyName, string $hallTitle): array
    {
        $meeting = $booking->companyMeeting;
        $startsAt = $meeting?->start_time
            ?: ($booking->preferred_date && $booking->preferred_time
                ? Carbon::parse($booking->preferred_date->format('Y-m-d') . ' ' . $booking->preferred_time)
                : null);

        return [
            'title' => $booking->meeting_topic ?: ('Meeting with ' . $companyName),
            'datetime' => $startsAt ? $startsAt->format('M d, Y • g:i A') : 'Time TBD',
            'location' => $hallTitle,
            'icon' => 'fa-handshake',
        ];
    }

    private function formatSessionDate($date, $time): string
    {
        if (! $date) {
            return 'Date TBD';
        }

        $label = Carbon::parse($date)->format('M d, Y');

        if ($time) {
            $label .= ' • ' . Carbon::parse($time)->format('g:i A');
        }

        return $label;
    }
}
