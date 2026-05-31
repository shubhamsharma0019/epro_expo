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
            'isPassActive' => (bool) session('visitor_pass_active', false),
        ]);
    }

    public function show(string $slug, string $companySlug): View
    {
        $booking = $this->baseBoothQuery($slug)
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
                'isPassActive' => (bool) session('visitor_pass_active', false),
            ]);
        }

        return view('frontend.exhibitions.booths.show', [
            'slug' => $slug,
            'companySlug' => $companySlug,
            'isPassActive' => (bool) session('visitor_pass_active', false),
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
            'company_meeting_id' => ['required', 'exists:company_meetings,id'],
            'visitor_name' => ['required', 'string', 'max:255'],
            'visitor_email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = $this->baseBoothQuery($slug)
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking || ! $booking->company_id) {
            return back()->with('error', 'Company not found.');
        }

        VisitorMeetingBooking::create([
            'company_id' => $booking->company_id,
            'company_meeting_id' => $validated['company_meeting_id'],
            'visitor_id' => auth()->id() ?? 1,
            'visitor_name' => $validated['visitor_name'],
            'visitor_email' => $validated['visitor_email'],
            'message' => $validated['message'] ?? '',
            'status' => 'pending',
        ]);

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

        $booking = $this->baseBoothQuery($slug)
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

    private function baseBoothQuery(string $slug): Builder
    {
        $exhibition = Exhibition::query()->where('slug', $slug)->first();

        return BoothBooking::query()
            ->with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothProfile'])
            ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('booth_setup_status', ['published', 'approved', 'live']);
    }

    private function companySlug(BoothBooking $booking): string
    {
        return Str::slug($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?: '');
    }
}
