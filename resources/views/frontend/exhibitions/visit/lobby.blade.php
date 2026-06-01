@extends('layouts.frontend')

@section('title', 'Exhibition Lobby - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
    $liveBooths = $liveBooths ?? collect();
    
    // Resolve exhibition name and description
    $exhibitionName = isset($exhibition) ? ($exhibition->title ?? $exhibition->name) : 'Exhibition Lobby';
    $exhibitionDesc = isset($exhibition) && $exhibition->description ? $exhibition->description : 'Start here, then move through companies, halls, booth pages, sessions and your QR visitor pass.';

    // Resolve active visitor pass dynamically from database
    $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
    $visitor = null;
    if ($bookingId) {
        $visitor = \App\Models\Visitor::where('booking_id', $bookingId)->first();
    }
    if (!$visitor && auth()->check() && isset($exhibition)) {
        $visitor = \App\Models\Visitor::where('exhibition_id', $exhibition->id)
            ->where('email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->first();
    }
    if (!$visitor && isset($exhibition)) {
        $visitor = \App\Models\Visitor::where('exhibition_id', $exhibition->id)->orderBy('created_at', 'desc')->first();
    }
    $isPassActive = $visitor ? ($visitor->payment_status === 'completed') : false;
    $passName = $visitor ? ($visitor->pass_type ?: 'Free Visitor Pass') : 'No Active Pass';

    // Resolve banner image (prioritize booth setup banner or logo)
    $bannerImage = null;
    if (isset($exhibition)) {
        $publishedBookings = ($exhibition->boothBookings ?? collect())->filter(fn ($booking) => 
            in_array($booking->booth_setup_status, ['published', 'approved', 'live'])
        );
        $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
            ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);
            
        $bannerImage = $exhibition->banner_url ?: ($exhibition->banner_image ?: 'images/exhibitions/hero-pavilion-scene.png');
        if ($firstBooking) {
            if ($firstBooking->boothBranding?->booth_banner) {
                $bannerPath = $firstBooking->boothBranding->booth_banner;
                $bannerImage = str_starts_with($bannerPath, 'storage/') ? $bannerPath : 'storage/' . $bannerPath;
            } elseif ($firstBooking->boothProfile?->company_logo) {
                $logoPath = $firstBooking->boothProfile->company_logo;
                $bannerImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
            } elseif ($firstBooking->company?->logo) {
                $logoPath = $firstBooking->company->logo;
                $bannerImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
            }
        }

        if (str_starts_with($bannerImage, 'http://') || str_starts_with($bannerImage, 'https://')) {
            // Keep absolute URL
        } elseif (str_starts_with($bannerImage, 'images/') || str_starts_with($bannerImage, 'assets/') || str_starts_with($bannerImage, 'storage/')) {
            $bannerImage = asset($bannerImage);
        } else {
            $bannerImage = asset('storage/' . $bannerImage);
        }
    } else {
        $bannerImage = asset('images/exhibitions/hero-pavilion-scene.png');
    }

    // Resolve dynamic stats
    if (isset($exhibition)) {
        $boothsCount = $exhibition->boothBookings->count();
        $hallsCount = $exhibition->boothBookings->pluck('hall_id')->filter()->unique()->count();
        $sessionsCount = $exhibition->boothBookings->sum(fn($b) => $b->boothSessions->count());
        
        $displayBooths = $boothsCount > 0 ? (string)$boothsCount : '120';
        $displayHalls = $hallsCount > 0 ? (string)$hallsCount : '8';
        $displaySessions = $sessionsCount > 0 ? (string)$sessionsCount : '45';
        $displayVisitors = $boothsCount > 0 ? (string)($boothsCount * 60) . '+' : '18,500+';
    } else {
        $displayBooths = '420+';
        $displayHalls = '14';
        $displaySessions = '80+';
        $displayVisitors = '36K';
    }
@endphp

<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <div class="relative grid gap-6 overflow-hidden rounded-[22px] bg-[#0A0D26] p-7 text-white shadow-[0_18px_44px_rgba(7,16,68,0.16)] lg:grid-cols-[1fr_420px] lg:p-8">
            <!-- Background Image overlay -->
            <div class="absolute right-0 top-0 bottom-0 w-[100%] lg:w-[60%] bg-cover bg-center lg:bg-left opacity-35 mix-blend-screen mix-blend-lighten z-0" style="background-image: url('{{ $bannerImage }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b lg:bg-gradient-to-r from-[#0A0D26] via-[#0A0D26]/90 to-[#0A0D26]/40 lg:to-transparent z-0"></div>

            <div class="min-w-0 relative z-10">
                <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-indigo-200">Visitor lobby</p>
                <h1 class="mt-3 max-w-[760px] text-[36px] font-bold leading-tight tracking-[-0.03em] sm:text-[52px]">{{ $exhibitionName }}</h1>
                <p class="mt-4 max-w-[700px] text-[15px] font-medium leading-7 text-white/76">{{ $exhibitionDesc }}</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-white px-6 text-[14px] font-bold text-[#5b2eff] hover:bg-gray-50 transition-colors shadow">View Companies</a>
                    <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-white/35 px-6 text-[14px] font-bold text-white hover:bg-white/10 transition-colors">Floor Map</a>
                    <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-white/35 px-6 text-[14px] font-bold text-white hover:bg-white/10 transition-colors">Register / Get Pass</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 relative z-10">
                <div class="col-span-2 rounded-[14px] border border-white/15 bg-white p-5 text-[#071044] shadow-sm">
                    <p class="text-[12px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Visitor Pass</p>
                    <p class="mt-2 text-[20px] font-bold">{{ $passName }} {{ $isPassActive ? 'active' : 'inactive' }}</p>
                    <p class="mt-1 text-[13px] font-medium text-[#5A6480]">Use your QR pass for halls, meetings, sessions and protected booth content.</p>
                </div>
                @foreach ([[$displayBooths, 'Companies'], [$displayHalls, 'Halls'], [$displaySessions, 'Sessions'], [$displayVisitors, 'Visitors']] as [$value, $label])
                    <div class="rounded-[14px] border border-white/15 bg-white/10 p-5 backdrop-blur shadow-sm">
                        <p class="text-[28px] font-bold">{{ $value }}</p>
                        <p class="mt-1 text-[13px] font-medium text-white/70">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-7 grid gap-4 rounded-[16px] border border-[#E7EAF3] bg-white p-5 shadow-[0_8px_22px_rgba(7,16,68,0.05)] md:grid-cols-5">
            @foreach ([['1', 'Browse Exhibitions'], ['2', 'Open Detail'], ['3', 'View Companies'], ['4', 'Get Pass'], ['5', 'Dashboard']] as [$step, $label])
                <div class="rounded-[12px] bg-[#FBFAFF] p-4">
                    <p class="text-[13px] font-bold text-[#5b2eff]">Step {{ $step }}</p>
                    <p class="mt-1 text-[14px] font-bold text-[#071044]">{{ $label }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-7 grid gap-6 lg:grid-cols-[1fr_380px]">
            <div class="grid gap-5 md:grid-cols-2">
                @foreach ([
                    ['Participating Companies', 'Browse exhibitor profiles, products, booth locations and categories.', route('exhibitions.visitor.companies', $slug)],
                    ['Floor Map & Halls', 'Use the map to understand halls, booth positions and active zones.', route('exhibitions.visitor.floor-map', $slug)],
                    ['Sessions & Webinars', 'Join live product demos, expert talks and exhibitor sessions.', route('exhibitions.visitor.sessions', $slug)],
                    ['Featured Speakers', 'Meet our industry experts and keynote presenters.', route('exhibitions.show', $slug) . '#tab-speakers'],
                    ['Event Sponsors', 'Explore our premium sponsors and corporate partners.', route('exhibitions.show', $slug) . '#tab-sponsors'],
                    ['Visitor Dashboard', 'See your QR pass, meetings, saved booths and notifications.', route('exhibitions.visitor.dashboard', $slug)]
                ] as [$title, $copy, $href])
                    <article class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)] flex flex-col justify-between">
                        <div>
                            <h2 class="text-[20px] font-bold text-[#071044]">{{ $title }}</h2>
                            <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $copy }}</p>
                        </div>
                        <a href="{{ $href }}" class="mt-5 inline-flex h-10 items-center justify-center rounded-lg bg-[#F4F0FF] px-4 text-[13px] font-bold text-[#5b2eff] w-fit hover:bg-[#6D28D9] hover:text-white transition-colors">Open</a>
                    </article>
                @endforeach
            </div>

            <aside class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                <h2 class="text-[20px] font-bold text-[#071044]">{{ $liveBooths->isNotEmpty() ? 'Live booths' : 'Live now' }}</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($liveBooths as $booking)
                        @php
                            $companyName = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;
                            $companySlug = \Illuminate\Support\Str::slug($companyName);
                        @endphp
                        <a href="{{ route('exhibitions.booths.show', [$slug, $companySlug]) }}" class="block rounded-[12px] bg-[#FBFAFF] p-4 transition hover:bg-[#F4F0FF]">
                            <p class="text-[13px] font-bold text-[#5b2eff]">{{ $companyName }}</p>
                            <p class="mt-1 text-[14px] font-medium text-[#34405F]">
                                {{ $booking->hall?->title ?: 'Hall' }}@if($booking->booth?->booth_number) / Booth {{ $booking->booth->booth_number }}@endif
                            </p>
                            <p class="mt-2 text-[12px] font-bold text-[#0A7A58]">{{ $booking->published_products_count ?? 0 }} products live</p>
                        </a>
                    @empty
                        @foreach ([['11:30 AM', 'AI product demos'], ['01:00 PM', 'Cloud security panel'], ['03:15 PM', 'Visitor networking'], ['05:00 PM', 'VIP keynote']] as [$time, $item])
                            <div class="rounded-[12px] bg-[#FBFAFF] p-4">
                                <p class="text-[13px] font-bold text-[#5b2eff]">{{ $time }}</p>
                                <p class="mt-1 text-[14px] font-medium text-[#34405F]">{{ $item }}</p>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
