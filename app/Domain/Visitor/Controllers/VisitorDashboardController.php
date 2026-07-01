<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\UserVisitorPasses;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class VisitorDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.user.login');
        }

        $user = Auth::user();
        $userEmail = $user->email;
        $bookingId = UserVisitorPasses::normalizeBookingId($request->query('booking_id'));

        UserVisitorPasses::linkPassesToUser($user, $bookingId);

        if (session('exhibition_booking_path')) {
            $pendingSlug = $request->query('slug') ?? session('activeExhibitionSlug');
            $pendingExhibition = $pendingSlug ? Exhibition::where('slug', $pendingSlug)->first() : null;
            $hasCompletedPass = UserVisitorPasses::queryForUser($user, $bookingId)
                ->when($pendingExhibition, fn ($query) => $query->where('exhibition_id', $pendingExhibition->id))
                ->where('payment_status', 'completed')
                ->exists();

            if (! $hasCompletedPass && $request->boolean('resume_exhibition_booking')) {
                return redirect(session('exhibition_booking_path'));
            }
        }

        // 1. Fetch Event Tickets & Exhibition Passes
        $eventTickets = VisitorTicket::where('user_id', $user->id)
            ->with(['companyEvent.branding', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        $exhibitionPasses = UserVisitorPasses::forUser($user, $bookingId);

        // 2. Resolve Active Exhibition Context
        $activeSlug = $request->query('slug') ?? session('activeExhibitionSlug');
        if (!$activeSlug) {
            // Default to the latest booked exhibition pass
            $latestPass = $exhibitionPasses->first();
            if ($latestPass && $latestPass->exhibition) {
                $activeSlug = $latestPass->exhibition->slug;
            } else {
                // Default to the first available exhibition in the database
                $firstExh = Exhibition::orderBy('start_date')->first();
                if ($firstExh) {
                    $activeSlug = $firstExh->slug;
                }
            }
        }

        if ($activeSlug) {
            session(['activeExhibitionSlug' => $activeSlug]);
        }

        // 3. Overview Widget counts
        $totalTicketsCount = $eventTickets->count() + $exhibitionPasses->count();

        $now = Carbon::now();

        // Exhibition categories
        $exhibitions = Exhibition::all();
        $upcomingExhibitions = $exhibitions->filter(fn($e) => $e->start_date && $e->start_date->gt($now));
        $liveExhibitions = $exhibitions->filter(fn($e) => $e->start_date && $e->end_date && $e->start_date->lte($now) && $e->end_date->gte($now));
        $completedExhibitions = $exhibitions->filter(fn($e) => $e->end_date && $e->end_date->lt($now));

        // Event categories
        $events = CompanyEvent::with('branding')->get();
        $upcomingEvents = $events->filter(fn($ev) => $ev->starts_at && $ev->starts_at->gt($now));
        $liveEvents = $events->filter(fn($ev) => $ev->starts_at && $ev->starts_at->lte($now) && ($ev->ends_at ? $ev->ends_at->gte($now) : true));
        $completedEvents = $events->filter(fn($ev) => $ev->ends_at && $ev->ends_at->lt($now));

        // Pending meeting requests
        $pendingMeetingsCount = VisitorMeetingBooking::where(function ($query) use ($user) {
            $query->where('visitor_id', $user->id);
            if ($user->email) {
                $query->orWhere('visitor_email', $user->email);
            }
        })->where('status', 'pending')->count();

        // 4. Generate Recent Activity Feed dynamically
        $activities = collect();

        // Event Ticket bookings
        foreach ($eventTickets as $ticket) {
            $activities->push([
                'type' => 'ticket_booked',
                'title' => 'Event Ticket Booked',
                'desc' => 'Booked ticket for ' . ($ticket->companyEvent->title ?? $ticket->ticket_name ?? 'Event'),
                'time' => $ticket->created_at,
                'icon' => 'fa-solid fa-ticket',
                'color' => 'bg-blue-100 text-blue-600',
            ]);
        }

        // Exhibition Pass registrations
        foreach ($exhibitionPasses as $pass) {
            $activities->push([
                'type' => 'exhibition_registered',
                'title' => 'Exhibition Registered',
                'desc' => 'Registered for exhibition: ' . ($pass->exhibition->title ?? $pass->exhibition->name ?? 'Exhibition'),
                'time' => $pass->created_at,
                'icon' => 'fa-solid fa-id-card',
                'color' => 'bg-indigo-100 text-indigo-600',
            ]);
        }

        // Meeting request sent
        $meetings = VisitorMeetingBooking::where(function ($query) use ($user) {
            $query->where('visitor_id', $user->id);
            if ($user->email) {
                $query->orWhere('visitor_email', $user->email);
            }
        })->with(['company', 'companyMeeting'])->latest()->get();

        foreach ($meetings as $meeting) {
            $activities->push([
                'type' => 'meeting_sent',
                'title' => 'Meeting Request Sent',
                'desc' => 'Sent meeting request to ' . ($meeting->company->company_name ?? $meeting->company->name ?? 'Company'),
                'time' => $meeting->created_at,
                'icon' => 'fa-regular fa-calendar-check',
                'color' => 'bg-purple-100 text-purple-600',
            ]);
        }

        // Session registrations
        $bookingIds = $exhibitionPasses->pluck('booking_id');
        $sessionRegistrations = $this->sessionRegistrationsQuery($user, $bookingIds)
            ->with('boothSession')
            ->latest()
            ->get();

        foreach ($sessionRegistrations as $session) {
            $activities->push([
                'type' => 'session_registered',
                'title' => 'Session Registered',
                'desc' => 'Registered for session: ' . ($session->boothSession->title ?? 'Session'),
                'time' => $session->created_at,
                'icon' => 'fa-regular fa-circle-play',
                'color' => 'bg-amber-100 text-amber-600',
            ]);
        }

        // Profile updated
        if ($user->updated_at && $user->updated_at->gt($user->created_at)) {
            $activities->push([
                'type' => 'profile_updated',
                'title' => 'Profile Updated',
                'desc' => 'Updated your profile information',
                'time' => $user->updated_at,
                'icon' => 'fa-regular fa-user',
                'color' => 'bg-teal-100 text-teal-600',
            ]);
        }

        $recentActivities = $activities->sortByDesc('time')->take(8)->values();

        $passes = collect();

        foreach ($eventTickets as $ticket) {
            $passes->push([
                'type' => 'event',
                'id' => $ticket->id,
                'pass_type' => 'Event Ticket',
                'name' => $ticket->companyEvent->title ?? $ticket->ticket_name ?? 'Event',
                'date' => $ticket->companyEvent?->starts_at,
                'ends_at' => $ticket->companyEvent?->ends_at,
                'status' => $ticket->status,
                'number' => $ticket->order_number,
                'quantity' => $ticket->quantity,
                'ticket_name' => $ticket->ticket_name,
                'email' => $userEmail,
            ]);
        }

        foreach ($exhibitionPasses as $pass) {
            $passes->push([
                'type' => 'exhibition',
                'id' => $pass->id,
                'pass_type' => 'Exhibition Pass',
                'name' => $pass->exhibition->title ?? $pass->exhibition->name ?? 'Exhibition',
                'date' => $pass->exhibition?->start_date,
                'ends_at' => $pass->exhibition?->end_date,
                'status' => $pass->payment_status === 'completed' ? 'confirmed' : $pass->payment_status,
                'number' => $pass->booking_id,
                'quantity' => 1,
                'ticket_name' => 'Visitor Pass',
                'email' => $pass->email,
                'slug' => $pass->exhibition->slug ?? '',
            ]);
        }

        $passes = $passes->map(function ($pass) use ($now) {
            $date = $pass['date'];
            $endsAt = $pass['ends_at'];

            if ($endsAt && $endsAt->lt($now)) {
                $category = 'completed';
            } elseif ($date && $date->gt($now)) {
                $category = 'upcoming';
            } else {
                $category = 'live';
            }

            $pass['category'] = $category;

            return $pass;
        })->sortBy(function ($pass) {
            return match ($pass['category']) {
                'upcoming' => 1,
                'live' => 2,
                default => 3,
            };
        })->values();

        $statCards = [
            ['label' => 'Event Tickets', 'value' => $eventTickets->count()],
            ['label' => 'Exhibition Passes', 'value' => $exhibitionPasses->count()],
            ['label' => 'Total Passes', 'value' => $totalTicketsCount],
            ['label' => 'Pending Meetings', 'value' => $pendingMeetingsCount],
        ];

        $quickActions = [
            ['label' => 'Browse Events', 'href' => url('/events/listings'), 'icon' => 'ph ph-calendar-blank'],
            ['label' => 'Browse Exhibitions', 'href' => route('exhibitions.index'), 'icon' => 'ph ph-buildings'],
            ['label' => 'My Passes', 'href' => route('frontend.user.passes'), 'icon' => 'ph ph-ticket'],
        ];

        $todayAgenda = $this->buildTodayAgenda($meetings, $sessionRegistrations, $now);
        $sessionProgress = $this->buildSessionProgress($sessionRegistrations);
        $liveSessionsCount = $sessionRegistrations
            ->filter(fn (VisitorSessionRegistration $registration) => $registration->boothSession?->status === 'live')
            ->count();

        return view('frontend.user.dashboard', [
            'user' => $user,
            'eventTickets' => $eventTickets,
            'exhibitionPasses' => $exhibitionPasses,
            'passes' => $passes,
            'activeSlug' => $activeSlug,
            'totalTicketsCount' => $totalTicketsCount,
            'upcomingExhibitions' => $upcomingExhibitions,
            'liveExhibitions' => $liveExhibitions,
            'completedExhibitions' => $completedExhibitions,
            'upcomingEvents' => $upcomingEvents,
            'liveEvents' => $liveEvents,
            'completedEvents' => $completedEvents,
            'pendingMeetingsCount' => $pendingMeetingsCount,
            'recentActivities' => $recentActivities,
            'statCards' => $statCards,
            'quickActions' => $quickActions,
            'todayAgenda' => $todayAgenda,
            'sessionProgress' => $sessionProgress,
            'liveSessionsCount' => $liveSessionsCount,
        ]);
    }

    private function sessionRegistrationsQuery($user, Collection $bookingIds)
    {
        return VisitorSessionRegistration::query()->where(function ($query) use ($user, $bookingIds) {
            $query->where('user_id', $user->id);

            if ($user->email) {
                $query->orWhereRaw('LOWER(visitor_email) = ?', [strtolower($user->email)]);
            }

            if ($bookingIds->isNotEmpty()) {
                $query->orWhereIn('visitor_booking_id', $bookingIds);
            }
        });
    }

    /** @return array{total:int,completed:int,percent:int} */
    private function buildSessionProgress(Collection $sessionRegistrations): array
    {
        $total = $sessionRegistrations->count();
        $completed = $sessionRegistrations->filter(function (VisitorSessionRegistration $registration) {
            if (in_array($registration->status, ['completed', 'attended'], true)) {
                return true;
            }

            return $registration->boothSession?->status === 'completed';
        })->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'percent' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
        ];
    }

    /** @return Collection<int, array<string, mixed>> */
    private function buildTodayAgenda(Collection $meetings, Collection $sessionRegistrations, Carbon $now): Collection
    {
        $agenda = collect();

        foreach ($meetings as $booking) {
            if (in_array($booking->status, ['cancelled', 'rejected', 'completed'], true)) {
                continue;
            }

            $startsAt = $this->resolveMeetingStart($booking);
            if (! $startsAt || ! $startsAt->isSameDay($now)) {
                continue;
            }

            $endsAt = $booking->companyMeeting?->end_time ?: $startsAt->copy()->addMinutes(30);
            $companyName = $booking->company?->company_name ?: $booking->company?->name ?: 'Company';
            $joinUrl = $booking->companyMeeting?->zoom_join_url ?: $booking->companyMeeting?->meeting_link;
            $isLive = $now->between($startsAt, $endsAt)
                && in_array($booking->status, ['confirmed', 'accepted'], true);

            $agenda->push([
                'type' => 'meeting',
                'title' => 'Meeting with ' . $companyName,
                'subtitle' => $this->agendaSubtitle($startsAt, $endsAt, $now, $isLive),
                'action_label' => $isLive && $joinUrl ? 'Join' : ($isLive ? 'View' : 'Join'),
                'action_url' => $joinUrl,
                'starts_at' => $startsAt,
            ]);
        }

        foreach ($sessionRegistrations as $registration) {
            $session = $registration->boothSession;
            if (! $session || ! $session->session_date?->isSameDay($now)) {
                continue;
            }

            if (in_array($session->status, ['cancelled'], true)) {
                continue;
            }

            $startsAt = $this->resolveSessionStart($session);
            if (! $startsAt) {
                continue;
            }

            $endsAt = $this->resolveSessionEnd($session, $startsAt);
            $isLive = $session->status === 'live' || ($endsAt && $now->between($startsAt, $endsAt));

            $agenda->push([
                'type' => 'session',
                'title' => 'Session: ' . ($session->title ?: 'Exhibitor session'),
                'subtitle' => $this->agendaSubtitle($startsAt, $endsAt, $now, $isLive),
                'action_label' => $isLive ? 'Join' : 'Remind me',
                'action_url' => null,
                'starts_at' => $startsAt,
            ]);
        }

        return $agenda
            ->sortBy('starts_at')
            ->values()
            ->take(4);
    }

    private function resolveMeetingStart(VisitorMeetingBooking $booking): ?Carbon
    {
        if ($booking->companyMeeting?->start_time) {
            return $booking->companyMeeting->start_time->copy();
        }

        if ($booking->preferred_date && $booking->preferred_time) {
            return Carbon::parse($booking->preferred_date->format('Y-m-d') . ' ' . $booking->preferred_time);
        }

        return null;
    }

    private function resolveSessionStart(BoothSession $session): ?Carbon
    {
        if (! $session->session_date || ! $session->start_time) {
            return null;
        }

        $time = $session->start_time;
        $timeString = $time instanceof Carbon ? $time->format('H:i:s') : (string) $time;

        return Carbon::parse($session->session_date->format('Y-m-d') . ' ' . $timeString);
    }

    private function resolveSessionEnd(BoothSession $session, Carbon $startsAt): ?Carbon
    {
        if (! $session->end_time) {
            return $startsAt->copy()->addHour();
        }

        $time = $session->end_time;
        $timeString = $time instanceof Carbon ? $time->format('H:i:s') : (string) $time;

        return Carbon::parse($session->session_date->format('Y-m-d') . ' ' . $timeString);
    }

    private function agendaSubtitle(Carbon $startsAt, ?Carbon $endsAt, Carbon $now, bool $isLive): string
    {
        $timeLabel = $startsAt->format('g:i A') . ' IST';

        if ($isLive) {
            return 'Live now · ' . $timeLabel;
        }

        if ($startsAt->lte($now)) {
            return 'Started · ' . $timeLabel;
        }

        $diffMinutes = (int) $now->diffInMinutes($startsAt);
        if ($diffMinutes < 60) {
            return 'Starts in ' . max($diffMinutes, 1) . ' min · ' . $timeLabel;
        }

        $hours = intdiv($diffMinutes, 60);
        $minutes = $diffMinutes % 60;

        return $timeLabel . ' · Live in ' . $hours . 'h ' . str_pad((string) $minutes, 2, '0', STR_PAD_LEFT) . 'm';
    }
}
