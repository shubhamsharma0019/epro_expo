<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BoothBooking;
use App\Models\Exhibition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\VisitorMeetingBooking;
use App\Models\Enquiry;
use App\Models\CompanyMeeting;

class ExhibitionBoothController extends Controller
{
    public function index(string $slug): View
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        $booths = $this->baseBoothQuery($slug)
            ->with(['boothSessions'])
            ->withCount([
                'boothProducts as published_products_count' => fn (Builder $query) => $query->where('status', 'published'),
                'boothCatalogues as public_catalogues_count' => fn (Builder $query) => $query->where('visibility', 'public')->where('status', 'active'),
            ])
            ->latest()
            ->get()
            ->filter(fn (BoothBooking $booking) => $this->companySlug($booking) !== '')
            ->values();

        return view(request()->routeIs('exhibitions.visitor.companies') ? 'frontend.exhibitions.visitor.companies.index' : 'frontend.exhibitions.booths.index', [
            'slug' => $slug,
            'booths' => $booths,
            'isPassActive' => $this->isPassActive($slug),
        ]);
    }

    public function show(string $slug, string $companySlug): View
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        $booking = $this->findBookingQuery($slug, false)
            ->with([
                'boothProfile',
                'boothBranding',
                'boothProducts' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order')->latest(),
                'boothDocuments' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active')->latest(),
                'boothCatalogues' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active')->latest(),
                'boothMedia' => fn ($query) => $query->where('status', 'active')->orderBy('sort_order')->latest(),
                'boothTeamMembers' => fn ($query) => $query->where('status', 'active')->latest(),
                'boothMeetingSlots' => fn ($query) => $query->where('status', 'available')->orderBy('date')->orderBy('start_time'),
                'boothSessions' => fn ($query) => $query->whereIn('status', ['upcoming', 'live'])->orderBy('session_date')->orderBy('start_time'),
            ])
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking) {
            return view('frontend.exhibitions.booths.show', [
                'slug' => $slug,
                'companySlug' => $companySlug,
                'isPassActive' => $this->isPassActive($slug),
            ]);
        }

        return view('frontend.exhibitions.booths.show', [
            'slug' => $slug,
            'companySlug' => $companySlug,
            'isPassActive' => $this->isPassActive($slug),
            'booking' => $booking,
            'company' => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name,
            'profile' => $booking->boothProfile,
            'branding' => $booking->boothBranding,
            'products' => $booking->boothProducts,
            'documents' => $booking->boothDocuments,
            'catalogues' => $booking->boothCatalogues,
            'mediaItems' => $booking->boothMedia,
            'teamMembers' => $booking->boothTeamMembers,
            'meetingSlots' => $booking->boothMeetingSlots,
            'companyMeetings' => CompanyMeeting::query()
                ->where('company_id', $booking->company_id)
                ->where('status', 'approved')
                ->where('start_time', '>=', now()->startOfDay())
                ->orderBy('start_time')
                ->get(),
            'sessions' => $booking->boothSessions,
        ]);
    }

    public function bookMeeting(Request $request, string $slug, string $companySlug): RedirectResponse
    {
        $validated = $request->validate([
            'booth_meeting_slot_id' => ['required', 'exists:booth_meeting_slots,id'],
            'visitor_name' => ['required', 'string', 'max:255'],
            'visitor_email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = $this->findBookingQuery($slug, false)
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking || ! $booking->company_id) {
            return back()->with('error', 'Company not found.');
        }

        // Find the selected booth meeting slot
        $slot = \App\Models\BoothMeetingSlot::where('booth_booking_id', $booking->id)
            ->where('status', 'available')
            ->findOrFail($validated['booth_meeting_slot_id']);

        // Create a matching CompanyMeeting record for the booking
        $startTime = $slot->date->format('Y-m-d') . ' ' . $slot->start_time;
        $endTime = $slot->date->format('Y-m-d') . ' ' . $slot->end_time;

        $companyMeeting = \App\Models\CompanyMeeting::create([
            'company_id' => $booking->company_id,
            'title' => 'Meeting Slot: ' . ($slot->date ? $slot->date->format('M d, Y') : '') . ' (' . \Carbon\Carbon::parse($slot->start_time)->format('h:i A') . ')',
            'meeting_type' => $slot->meeting_type ?? 'video',
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
        ]);

        // Create the visitor meeting booking
        VisitorMeetingBooking::create([
            'company_id' => $booking->company_id,
            'company_meeting_id' => $companyMeeting->id,
            'visitor_id' => auth()->id() ?? 1,
            'visitor_name' => $validated['visitor_name'],
            'visitor_email' => $validated['visitor_email'],
            'message' => $validated['message'] ?? '',
            'status' => 'pending',
        ]);

        // Mark the slot as booked
        $slot->update(['status' => 'booked']);

        return back()->with('success', 'Meeting requested successfully.');
    }

    public function sendEnquiry(Request $request, string $slug, string $companySlug): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $booking = $this->findBookingQuery($slug, false)
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking || ! $booking->company_id) {
            return back()->with('error', 'Company not found.');
        }

        Enquiry::create([
            'company_id' => $booking->company_id,
            'visitor_id' => auth()->id() ?? 1,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Booth Enquiry',
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return back()->with('success', 'Enquiry sent successfully.');
    }

    private function findBookingQuery(string $slug, bool $onlyPublished = false): Builder
    {
        $exhibition = Exhibition::query()->where('slug', $slug)->first();

        $query = BoothBooking::query()
            ->with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothProfile'])
            ->when($exhibition, fn (Builder $q) => $q->where('exhibition_id', $exhibition->id))
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active']);

        if ($onlyPublished) {
            $query->whereIn('booth_setup_status', ['published', 'approved', 'live']);
        }

        return $query;
    }

    private function baseBoothQuery(string $slug): Builder
    {
        return $this->findBookingQuery($slug, true);
    }

    private function companySlug(BoothBooking $booking): string
    {
        return Str::slug($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?: '');
    }

    private function isPassActive(string $slug): bool
    {
        if (session('visitor_pass_active', false)) {
            return true;
        }

        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
        if ($bookingId) {
            $exhibition = Exhibition::where('slug', $slug)->first();
            $exists = \App\Models\Visitor::where('booking_id', $bookingId)
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
            
            $visitor = \App\Models\Visitor::where('email', $userEmail)
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
}
