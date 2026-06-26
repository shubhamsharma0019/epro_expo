@extends('layouts.exhibition')

@section('title', 'Company Booth - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')
@php
    use App\Domain\Booth\Models\BoothView;

    $company = $company ?? ($companySlug ? str($companySlug)->replace('-', ' ')->title() : 'Company');
    $isPassActive = $isPassActive ?? false;
    $booking = $booking ?? null;
    $lockMessage = 'Register / Get Pass to access this feature';
    $profile = $profile ?? null;
    $branding = $branding ?? null;
    $products = collect($products ?? []);
    $documents = collect($documents ?? []);
    $catalogues = collect($catalogues ?? []);
    $mediaItems = collect($mediaItems ?? []);
    $teamMembers = collect($teamMembers ?? []);
    $meetingSlots = collect($meetingSlots ?? []);
    $companyMeetings = collect($companyMeetings ?? []);
    $sessions = collect($sessions ?? []);
    $visitorMeetings = collect($visitorMeetings ?? []);

    $visitor = auth()->check() ? \App\Domain\Visitor\Models\Visitor::where('email', auth()->user()->email)->where('exhibition_id', $booking->exhibition_id ?? null)->first() : null;
    $visitorBookingId = $visitor?->booking_id;

    $boothVideo = $mediaItems->first(fn ($m) => $m->type === 'video' || !empty($m->video_url));
    $demoVideoUrl = $boothVideo
        ? ($boothVideo->file_path ? asset('storage/' . $boothVideo->file_path) : $boothVideo->video_url)
        : null;

    $nextBooths = isset($booking) ? \App\Domain\Booth\Models\BoothBooking::query()
        ->with(['company', 'boothProfile'])
        ->where('exhibition_id', $booking->exhibition_id)
        ->where('id', '!=', $booking->id)
        ->where('payment_status', 'paid')
        ->whereIn('booking_status', ['confirmed', 'active'])
        ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
        ->take(3)
        ->get()
        ->map(function ($b) {
            $name = $b->boothProfile?->company_name ?: $b->company?->company_name ?: $b->company?->name ?: 'Exhibitor';
            return [
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ];
        })
        : collect();

    $ticketUrl = route('exhibitions.tickets.select', $slug);
    $logoUrl = $profile?->company_logo ? asset('storage/' . $profile->company_logo) : null;
    $hallName = $booking?->hall?->title ?? $booking?->hall?->name ?? 'Hall';
    $boothNumber = $booking?->booth?->booth_number ?? $booking?->booth?->number ?? 'Booth';
    $boothLabel = str_starts_with(strtolower((string) $boothNumber), 'booth') ? $boothNumber : 'Booth ' . $boothNumber;
    $bannerUrl = $branding?->booth_banner
        ? asset('storage/' . $branding->booth_banner)
        : ($profile?->booth_banner ? asset('storage/' . $profile->booth_banner) : null);
    $welcomeHeading = $branding?->welcome_heading ?? $profile?->booth_title ?? $company;
    $welcomeTagline = $branding?->welcome_subheading ?? $profile?->tagline ?? ($profile?->about_company ? \Illuminate\Support\Str::limit(strip_tags($profile->about_company), 120) : '');
    $firstBrochure = $documents->first() ?? $catalogues->first();
    $nextSession = $sessions->first();
    $primaryRepresentative = $teamMembers->first();
    $boothViewsCount = $booking?->company_id ? BoothView::where('company_id', $booking->company_id)->count() : 0;
    $myMeetingsCount = $visitorMeetings->count();
    $confirmedMeetings = $visitorMeetings->filter(fn ($m) => in_array($m->status, ['confirmed', 'accepted', 'rescheduled'], true))->count();
    $pendingMeetings = $visitorMeetings->filter(fn ($m) => in_array($m->status, ['pending', 'waitlisted'], true))->count();
    $userFullName = auth()->check() ? (auth()->user()->first_name ? auth()->user()->first_name . ' ' . auth()->user()->last_name : auth()->user()->name) : '';
    $userEmail = auth()->check() ? auth()->user()->email : '';
@endphp

<section class="visitor-flow-page booth-home-page bg-[#FBFAFF] px-4 py-6 sm:px-8 sm:py-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        @if (session('success'))
            <div class="mb-6 flex items-center gap-2 rounded-[14px] border border-emerald-100 bg-emerald-50/50 p-4 text-[14px] font-bold text-emerald-800 backdrop-blur-sm">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 flex items-center gap-2 rounded-[14px] border border-rose-100 bg-rose-50/50 p-4 text-[14px] font-bold text-rose-800 backdrop-blur-sm">
                <svg class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @include('frontend.visitor-exhibition.booths.partials.header-bar')

        <div class="booth-home-grid">
            @include('frontend.visitor-exhibition.booths.partials.nav-sidebar')

            <div class="booth-home-main min-w-0 space-y-6">
                @include('frontend.visitor-exhibition.booths.partials.hero-preview')
                @include('frontend.visitor-exhibition.booths.partials.content-sections')
            </div>

            @include('frontend.visitor-exhibition.booths.partials.right-panel')
        </div>

        @include('frontend.visitor-exhibition.booths.partials.quick-links')
    </div>
</section>

@include('frontend.visitor-exhibition.booths.partials.modals-scripts')
@endsection
