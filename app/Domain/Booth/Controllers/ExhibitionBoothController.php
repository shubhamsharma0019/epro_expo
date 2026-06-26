<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothView;
use App\Domain\Event\Models\Exhibition;
use App\Support\DbGuard;
use App\Support\LiveContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Company\Models\CompanyMeeting;

class ExhibitionBoothController extends Controller
{
    public function index(string $slug): View
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        if (! DbGuard::available()) {
            return view(request()->routeIs('exhibitions.visitor.companies') ? 'frontend.visitor-exhibition.booths.companies' : 'frontend.exhibitions.booths.index', [
                'slug' => $slug,
                'booths' => collect(),
                'isPassActive' => false,
            ]);
        }

        $exhibition = LiveContent::findLiveExhibitionBySlug($slug)
            ?: Exhibition::where('slug', $slug)->first();

        $booths = BoothBooking::query()
            ->with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothProfile', 'boothBranding', 'boothSessions'])
            ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->withCount([
                'boothProducts as published_products_count' => fn (Builder $query) => $query->where('status', 'published'),
                'boothCatalogues as public_catalogues_count' => fn (Builder $query) => $query->where('visibility', 'public')->where('status', 'active'),
            ])
            ->latest()
            ->get()
            ->filter(fn (BoothBooking $booking) => $this->companySlug($booking) !== '')
            ->values();

        if ($booths->isEmpty()) {
            $booths = BoothBooking::query()
                ->with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothProfile', 'boothBranding', 'boothSessions'])
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where('admin_status', 'approved')
                ->withCount([
                    'boothProducts as published_products_count' => fn (Builder $query) => $query->where('status', 'published'),
                    'boothCatalogues as public_catalogues_count' => fn (Builder $query) => $query->where('visibility', 'public')->where('status', 'active'),
                ])
                ->latest()
                ->get()
                ->filter(fn (BoothBooking $booking) => $this->companySlug($booking) !== '')
                ->values();
        }

        return view(request()->routeIs('exhibitions.visitor.companies') ? 'frontend.visitor-exhibition.booths.companies' : 'frontend.exhibitions.booths.index', [
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

        $exhibition = LiveContent::exhibitionQuery()->where('slug', $slug)->first()
            ?: Exhibition::where('slug', $slug)->first();

        $booking = $this->findBookingQuery($slug, true)
            ->with([
                'boothProfile',
                'boothBranding',
                'boothProducts' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order')->latest(),
                'boothDocuments' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active')->latest(),
                'boothCatalogues' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active')->latest(),
                'boothMedia' => fn ($query) => $query->where('status', 'active')->orderBy('sort_order')->latest(),
                'boothTeamMembers' => fn ($query) => $query->where('status', 'active')->latest(),
                'boothMeetingSlots' => fn ($query) => $query->where('status', 'available')->orderBy('date')->orderBy('start_time'),
                'boothMeetingAvailability',
                'boothSessions' => fn ($query) => $query->whereIn('status', ['upcoming', 'live'])->orderBy('session_date')->orderBy('start_time'),
            ])
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking) {
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
        }

        if (! $booking) {
            return view('frontend.visitor-exhibition.booths.show', [
                'slug' => $slug,
                'companySlug' => $companySlug,
                'isPassActive' => $this->isPassActive($slug),
                'visitorMeetings' => collect(),
            ]);
        }

        $this->recordBoothView($booking);

        return view('frontend.visitor-exhibition.booths.show', [
            'slug' => $slug,
            'companySlug' => $companySlug,
            'isPassActive' => $this->isPassActive($slug),
            'exhibition' => $exhibition,
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
            'meetingAvailability' => $booking->boothMeetingAvailability,
            'companyMeetings' => CompanyMeeting::query()
                ->where('company_id', $booking->company_id)
                ->where('status', 'approved')
                ->where('start_time', '>=', now()->startOfDay())
                ->orderBy('start_time')
                ->get(),
            'sessions' => $booking->boothSessions,
            'visitorMeetings' => $this->resolveVisitorMeetingsForCompany((int) $booking->company_id),
        ]);
    }

    /**
     * Log a booth view for analytics. Deduped per session per company and
     * wrapped so any failure can never break the visitor-facing booth page.
     */
    private function recordBoothView(BoothBooking $booking): void
    {
        try {
            if (! $booking->company_id || ! DbGuard::available()) {
                return;
            }

            $visitorId = auth()->id();

            // Avoid inflating counts on refreshes within the same session.
            $sessionKey = 'booth_view_logged_' . $booking->company_id;
            if (session()->has($sessionKey)) {
                return;
            }

            BoothView::create([
                'company_id' => $booking->company_id,
                'booth_profile_id' => $booking->boothProfile?->id,
                'visitor_id' => $visitorId,
                'ip_address' => request()->ip(),
                'user_agent' => Str::limit((string) request()->userAgent(), 500, ''),
                'viewed_at' => now(),
            ]);

            session([$sessionKey => now()->timestamp]);
        } catch (\Throwable $e) {
            // Analytics tracking is best-effort; never disrupt the page render.
        }
    }

    public function exhibitorEnquiryForm(): View
    {
        $bookings = BoothBooking::query()
            ->with(['company', 'exhibition', 'boothProfile'])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['approved', 'pending'])
            ->latest()
            ->get()
            ->filter(fn (BoothBooking $booking) => $booking->company_id)
            ->unique('company_id')
            ->values();

        return view('frontend.exhibitions.exhibitors.enquiries', [
            'bookings' => $bookings,
        ]);
    }

    public function sendExhibitorEnquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booth_booking_id' => ['required', 'integer', 'exists:booth_bookings,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $booking = BoothBooking::query()
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['approved', 'pending'])
            ->whereKey($validated['booth_booking_id'])
            ->first();

        if (! $booking || ! $booking->company_id) {
            return back()->with('error', 'Company not found.')->withInput();
        }

        Enquiry::create([
            'company_id' => $booking->company_id,
            'visitor_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Booth Enquiry',
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return back()->with('success', 'Enquiry sent successfully.');
    }

    public function bookMeeting(Request $request, string $slug, string $companySlug): RedirectResponse
    {
        if (! $this->isPassActive($slug)) {
            return back()->with('error', 'You must be a verified ticket holder of this exhibition to request a meeting.');
        }

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

        $booking = $this->findBookingQuery($slug, true)
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking) {
            $booking = $this->findBookingQuery($slug, false)
                ->get()
                ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);
        }

        if (! $booking || ! $booking->company_id) {
            return back()->with('error', 'Company not found.');
        }

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
            $slot = \App\Domain\Booth\Models\BoothMeetingSlot::where('booth_booking_id', $booking->id)
                ->where('status', 'available')
                ->find($validated['booth_meeting_slot_id']);
        }

        if ($slot) {
            $startTime = $slot->date->format('Y-m-d') . ' ' . $slot->start_time;
            $endTime = $slot->date->format('Y-m-d') . ' ' . $slot->end_time;
            $title = $validated['meeting_topic'];
        } else {
            $preferredDate = $validated['preferred_date'] ?? $this->defaultMeetingDateForExhibition($booking->exhibition);
            $preferredTime = $validated['preferred_time'] ?? '10:00';
            $startTime = $preferredDate . ' ' . $preferredTime;
            $endTime = \Carbon\Carbon::parse($startTime)->addMinutes(30)->format('Y-m-d H:i:s');
            $title = $validated['meeting_topic'];
        }

        // Validate using SmartSchedulingEngine
        $engine = new \App\Domain\Shared\Services\SmartSchedulingEngine();
        $validation = $engine->validateMeetingRequest(
            $booking->company_id,
            auth()->id(),
            $validated['visitor_email'],
            \Carbon\Carbon::parse($startTime)->toDateString(),
            \Carbon\Carbon::parse($startTime)->format('H:i:s'),
            $reqMeetingType,
            $booking->exhibition_id,
            $slot?->id
        );

        if (! $validation['valid']) {
            $errorMsg = $validation['conflict'];
            if ($validation['suggest_slot']) {
                $suggested = $validation['suggest_slot'];
                $sDate = \Carbon\Carbon::parse($suggested->date)->format('M d, Y');
                $sTime = \Carbon\Carbon::parse($suggested->start_time)->format('h:i A');
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
            'meeting_date' => \Carbon\Carbon::parse($startTime)->toDateString(),
            'meeting_time' => \Carbon\Carbon::parse($startTime)->format('H:i:s'),
            'max_attendees' => $slot?->max_capacity ?? ($reqMeetingType === 'one-to-many' ? 10 : 1),
            'status' => $initialStatus,
        ]);

        $visitorBooking = VisitorMeetingBooking::create([
            'company_id' => $booking->company_id,
            'company_meeting_id' => $companyMeeting->id,
            'visitor_id' => auth()->id(),
            'visitor_name' => $validated['visitor_name'],
            'visitor_email' => $validated['visitor_email'],
            'meeting_topic' => $validated['meeting_topic'],
            'preferred_date' => $validated['preferred_date'] ?? \Carbon\Carbon::parse($startTime)->toDateString(),
            'preferred_time' => $validated['preferred_time'] ?? \Carbon\Carbon::parse($startTime)->format('H:i:s'),
            'message' => $validated['message'] ?? '',
            'status' => $initialStatus,
            'created_by' => auth()->id(),
        ]);

        if ($slot && ! $isWaitlisted) {
            $maxCapacity = $slot->max_capacity ?? 1;
            $confirmedCount = VisitorMeetingBooking::where('company_id', $booking->company_id)
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

        // Add Notification
        \Illuminate\Support\Facades\DB::table('meeting_notifications')->insert([
            'visitor_id' => auth()->id(),
            'company_id' => $booking->company_id,
            'visitor_meeting_booking_id' => $visitorBooking->id,
            'type' => 'created',
            'title' => $isWaitlisted ? 'Meeting Waitlisted' : 'Meeting Request Created',
            'message' => ($isWaitlisted ? 'You have been added to the waitlist. ' : '') . 'A new meeting request was submitted by ' . $validated['visitor_name'] . ' regarding "' . $validated['meeting_topic'] . '".',
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add an Admin Notification
        \Illuminate\Support\Facades\DB::table('admin_notifications')->insert([
            'title' => 'Meeting Request: ' . $title,
            'type' => 'booking',
            'priority' => 'normal',
            'channel' => 'in_app',
            'status' => 'unread',
            'message' => 'Meeting requested between company #' . $booking->company_id . ' and visitor #' . auth()->id() . ' on ' . $startTime,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $successMsg = $isWaitlisted
            ? 'The slot is full. You have been placed on the waitlist for this meeting slot.'
            : 'Meeting request sent. The company will accept or reject your request.';

        return back()->with('success', $successMsg);
    }

    public function requestMeetingJoin(Request $request, string $slug, string $companySlug, int $id): RedirectResponse
    {
        if (! $this->isPassActive($slug)) {
            return back()->with('error', 'You must be a verified ticket holder to join meetings.');
        }

        if (! auth()->check()) {
            return back()->with('error', 'Please log in to join this meeting.');
        }

        $booking = $this->findBookingQuery($slug, true)
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking) {
            $booking = $this->findBookingQuery($slug, false)
                ->get()
                ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);
        }

        if (! $booking?->company_id) {
            return back()->with('error', 'Company not found.');
        }

        $meeting = VisitorMeetingBooking::with('companyMeeting')
            ->where('id', $id)
            ->where('company_id', $booking->company_id)
            ->where(function ($query) {
                $query->where('visitor_id', auth()->id())
                    ->orWhere('visitor_email', auth()->user()->email);
            })
            ->firstOrFail();

        $joinUrl = $meeting->companyMeeting?->meeting_link ?: $meeting->companyMeeting?->zoom_join_url;
        $topic = $meeting->meeting_topic ?: $meeting->companyMeeting?->title ?: 'Meeting';
        $visitorName = auth()->user()->name ?: $meeting->visitor_name;

        if ($joinUrl && in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled'], true)) {
            return redirect()->away($joinUrl);
        }

        if ($joinUrl && $meeting->status === 'pending') {
            $meeting->update(['status' => 'confirmed']);
            $meeting->companyMeeting?->update(['status' => 'confirmed']);

            \Illuminate\Support\Facades\DB::table('meeting_notifications')->insert([
                'visitor_id' => auth()->id(),
                'company_id' => $booking->company_id,
                'visitor_meeting_booking_id' => $meeting->id,
                'type' => 'confirmed',
                'title' => 'Meeting Accepted',
                'message' => 'Your meeting "' . $topic . '" is ready. Join here: ' . $joinUrl,
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->away($joinUrl);
        }

        \Illuminate\Support\Facades\DB::table('meeting_notifications')->insert([
            'visitor_id' => auth()->id(),
            'company_id' => $booking->company_id,
            'visitor_meeting_booking_id' => $meeting->id,
            'type' => 'join_request',
            'title' => 'Visitor ready to join',
            'message' => $visitorName . ' is at your booth and requested to join "' . $topic . '".',
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $hostName = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?: 'the host';

        return back()->with(
            'success',
            'Join request sent to ' . $hostName . '. The host will confirm and share the meeting link shortly.'
        );
    }

    public function sendEnquiry(Request $request, string $slug, string $companySlug): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $booking = $this->findBookingQuery($slug, true)
            ->get()
            ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);

        if (! $booking) {
            $booking = $this->findBookingQuery($slug, false)
                ->get()
                ->first(fn (BoothBooking $booking) => $this->companySlug($booking) === $companySlug);
        }

        if (! $booking || ! $booking->company_id) {
            return back()->with('error', 'Company not found.');
        }

        Enquiry::create([
            'company_id' => $booking->company_id,
            'visitor_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Booth Enquiry',
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return back()->with('success', 'Enquiry sent successfully.');
    }

    private function findBookingQuery(string $slug, bool $onlyPublished = true): Builder
    {
        $exhibition = LiveContent::exhibitionQuery()->where('slug', $slug)->first()
            ?: Exhibition::where('slug', $slug)->first();

        if (! $exhibition) {
            return BoothBooking::query()->whereRaw('0 = 1');
        }

        $query = BoothBooking::query()
            ->with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothProfile'])
            ->where('exhibition_id', $exhibition->id);

        if ($onlyPublished) {
            return $query->publiclyVisible();
        }

        return $query
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved');
    }

    private function baseBoothQuery(string $slug): Builder
    {
        return $this->findBookingQuery($slug, true);
    }

    private function companySlug(BoothBooking $booking): string
    {
        return Str::slug($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?: '');
    }

    private function resolveVisitorMeetingsForCompany(int $companyId): \Illuminate\Support\Collection
    {
        if (! $companyId || ! auth()->check()) {
            return collect();
        }

        return VisitorMeetingBooking::query()
            ->with('companyMeeting')
            ->where('company_id', $companyId)
            ->whereNotIn('status', ['cancelled', 'rejected', 'completed'])
            ->where(function ($query) {
                $query->where('visitor_id', auth()->id())
                    ->orWhere('visitor_email', auth()->user()->email);
            })
            ->latest()
            ->get();
    }

    private function defaultMeetingDateForExhibition(?Exhibition $exhibition): string
    {
        $candidate = now()->addDay()->startOfDay();

        if (! $exhibition) {
            return $candidate->toDateString();
        }

        $start = \Carbon\Carbon::parse($exhibition->start_date)->startOfDay();
        $end = \Carbon\Carbon::parse($exhibition->end_date)->endOfDay();

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

    private function isPassActive(string $slug): bool
    {
        if (session('visitor_pass_active', false)) {
            return true;
        }

        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
        if ($bookingId) {
            $exhibition = LiveContent::exhibitionQuery()->where('slug', $slug)->first()
                ?: Exhibition::where('slug', $slug)->first();
            $exists = \App\Domain\Visitor\Models\Visitor::where('booking_id', $bookingId)
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
            $exhibition = LiveContent::exhibitionQuery()->where('slug', $slug)->first()
                ?: Exhibition::where('slug', $slug)->first();

            $visitor = \App\Domain\Visitor\Models\Visitor::where('email', $userEmail)
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
