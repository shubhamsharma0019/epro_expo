<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        if (session('exhibition_booking_path')) {
            $pendingSlug = $request->query('slug') ?? session('activeExhibitionSlug');
            $pendingExhibition = $pendingSlug ? Exhibition::where('slug', $pendingSlug)->first() : null;
            $hasCompletedPass = Visitor::query()
                ->where('email', $userEmail)
                ->when($pendingExhibition, fn ($query) => $query->where('exhibition_id', $pendingExhibition->id))
                ->where('payment_status', 'completed')
                ->exists();

            if (! $hasCompletedPass) {
                return redirect(session('exhibition_booking_path'));
            }
        }

        // 1. Fetch Event Tickets & Exhibition Passes
        $eventTickets = VisitorTicket::where('user_id', $user->id)
            ->with(['companyEvent.branding', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        $exhibitionPasses = Visitor::where('email', $userEmail)
            ->with('exhibition')
            ->orderBy('created_at', 'desc')
            ->get();

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
        })->with('company')->latest()->get();

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
        $sessions = VisitorSessionRegistration::where(function ($query) use ($user, $bookingIds) {
            $query->where('user_id', $user->id);
            if ($bookingIds->isNotEmpty()) {
                $query->orWhereIn('visitor_booking_id', $bookingIds);
            }
        })->with('boothSession')->latest()->get();

        foreach ($sessions as $session) {
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

        return view('frontend.user.dashboard', [
            'user' => $user,
            'eventTickets' => $eventTickets,
            'exhibitionPasses' => $exhibitionPasses,
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
        ]);
    }
}
