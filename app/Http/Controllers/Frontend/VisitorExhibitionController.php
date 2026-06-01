<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BoothBooking;
use App\Models\BoothSession;
use App\Models\Exhibition;
use App\Models\VisitorMeetingBooking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Models\Visitor;

class VisitorExhibitionController extends Controller
{
    private function isPassActive(string $slug = null): bool
    {
        if (session('visitor_pass_active', false)) {
            return true;
        }

        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
        if ($bookingId) {
            $exhibition = Exhibition::where('slug', $slug)->first();
            $exists = Visitor::where('booking_id', $bookingId)
                ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
                ->where('payment_status', 'completed')
                ->exists();
            if ($exists) {
                session(['visitor_pass_active' => true]);
                session(['selected_visitor_booking_id' => $bookingId]);
                return true;
            }
        }

        if (auth()->check()) {
            $userEmail = auth()->user()->email;
            $exhibition = Exhibition::where('slug', $slug)->first();
            
            $visitor = Visitor::where('email', $userEmail)
                ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
                ->where('payment_status', 'completed')
                ->first();
                
            if ($visitor) {
                session(['visitor_pass_active' => true]);
                session(['selected_visitor_booking_id' => $visitor->booking_id]);
                return true;
            }
        }

        return false;
    }

    public function lobby(string $slug): View
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        $exhibition = Exhibition::query()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['published', 'approved', 'live']),
                'boothBookings.boothSessions',
                'boothBookings.hall',
                'boothBookings.booth'
            ])
            ->where('slug', $slug)
            ->first();
        $liveBooths = BoothBooking::query()
            ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile'])
            ->withCount([
                'boothProducts as published_products_count' => fn (Builder $query) => $query->where('status', 'published'),
                'boothCatalogues as public_catalogues_count' => fn (Builder $query) => $query->where('visibility', 'public')->where('status', 'active'),
            ])
            ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
            ->latest()
            ->take(6)
            ->get()
            ->filter(fn (BoothBooking $booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))
            ->values();

        return view('frontend.exhibitions.visit.lobby', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug),
            'liveBooths' => $liveBooths,
            'exhibition' => $exhibition,
        ]);
    }

    public function floorMap(string $slug): View
    {
        return view('frontend.exhibitions.halls.floor-plan', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function dashboard(string $slug): View
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        return view('frontend.exhibitions.dashboard', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function myPasses(string $slug): View
    {
        $visitors = Visitor::with('exhibition')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.exhibitions.booking.my-bookings', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug),
            'visitors' => $visitors
        ]);
    }

    public function savedBooths(string $slug): View
    {
        return view('frontend.exhibitions.visitor.saved.index', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function meetings(string $slug): View
    {
        $meetings = [];
        
        if (auth()->check()) {
            $meetings = VisitorMeetingBooking::with(['company', 'companyMeeting'])
                ->where('visitor_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('frontend.exhibitions.visitor.meetings.index', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug),
            'meetings' => $meetings
        ]);
    }

    public function sessions(string $slug): View
    {
        $exhibition = Exhibition::query()->where('slug', $slug)->first();

        $sessions = BoothSession::query()
            ->with([
                'teamMember',
                'boothBooking.company',
                'boothBooking.boothProfile',
                'boothBooking.hall',
                'boothBooking.booth',
            ])
            ->whereIn('status', ['live', 'upcoming', 'completed'])
            ->whereHas('boothBooking', function (Builder $query) use ($exhibition) {
                $query
                    ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->whereIn('booth_setup_status', [
                        'published',
                        'approved',
                        'live',
                    ]);
            })
            ->orderByRaw("CASE status WHEN 'live' THEN 0 WHEN 'upcoming' THEN 1 WHEN 'completed' THEN 2 ELSE 3 END")
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get();

        return view('frontend.exhibitions.visitor.sessions.index', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug),
            'sessions' => $sessions,
            'exhibition' => $exhibition,
        ]);
    }

    public function notifications(string $slug): View
    {
        return view('frontend.exhibitions.visitor.notifications.index', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function chat(string $slug, string $companySlug = 'technova-solutions'): View
    {
        return view('frontend.exhibitions.visitor.chat.show', [
            'slug' => $slug,
            'companySlug' => $companySlug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function hallsIndex(string $slug): View
    {
        return view('frontend.exhibitions.visitor.halls.index', [
            'slug' => $slug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function hallsShow(string $slug, string $hallSlug): View
    {
        return view('frontend.exhibitions.visitor.halls.show', [
            'slug' => $slug,
            'hallSlug' => $hallSlug,
            'isPassActive' => $this->isPassActive($slug)
        ]);
    }

    public function pavilionsIndex(string $slug): RedirectResponse
    {
        return redirect()->route('exhibitions.visitor.companies', $slug);
    }

    public function pavilionsShow(string $slug, string $pavilionSlug): RedirectResponse
    {
        return redirect()->route('exhibitions.visitor.companies', $slug);
    }
}
