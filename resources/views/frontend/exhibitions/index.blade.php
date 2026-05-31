@extends('layouts.blank')

@section('title', 'Browse Exhibitions - EproExpo')

@section('content')
@php
    $fallbackExhibitions = [
        [
            'slug' => 'global-tech-expo-2026',
            'title' => 'Global Tech Expo 2026',
            'date' => 'June 12 - 14, 2026',
            'time' => '10:00 AM - 7:00 PM IST',
            'location' => 'Virtual + New Delhi',
            'category' => 'Technology',
            'status' => 'Live registration',
            'visitors' => '24,000+',
            'companies' => '420',
            'halls' => '14',
            'sessions' => '80+',
            'pass' => 'Free visitor pass available',
            'image' => 'images/exhibitions/hero-pavilion-scene.png',
            'accent' => '#5b2eff',
        ],
        [
            'slug' => 'healthcare-innovation-expo',
            'title' => 'Healthcare Innovation Expo',
            'date' => 'July 8 - 10, 2026',
            'time' => '11:00 AM - 6:00 PM IST',
            'location' => 'Virtual',
            'category' => 'Healthcare',
            'status' => 'Early access',
            'visitors' => '18,500+',
            'companies' => '260',
            'halls' => '9',
            'sessions' => '45+',
            'pass' => 'Business pass opens soon',
            'image' => 'assets/images/pavilions/healthcare-pavilion.png',
            'accent' => '#0F9F8F',
        ],
        [
            'slug' => 'sustainable-business-fair',
            'title' => 'Sustainable Business Fair',
            'date' => 'August 3 - 5, 2026',
            'time' => '9:30 AM - 5:30 PM IST',
            'location' => 'Hybrid',
            'category' => 'Sustainability',
            'status' => 'Coming soon',
            'visitors' => '16,200+',
            'companies' => '210',
            'halls' => '8',
            'sessions' => '38+',
            'pass' => 'Notify me for passes',
            'image' => 'assets/images/pavilions/sustainability-pavilion.png',
            'accent' => '#2C7A4B',
        ],
    ];

    $exhibitions = isset($dynamicExhibitions) && $dynamicExhibitions->isNotEmpty()
        ? $dynamicExhibitions->map(function ($item) {
            $publishedBookings = ($item->boothBookings ?? collect())->filter(fn ($booking) => 
                in_array($booking->booth_setup_status, ['published', 'approved', 'live'])
            );
            $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
                ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);
            $image = $item->banner_url ?: ($item->banner_image ?: 'images/exhibitions/hero-pavilion-scene.png');
            if ($firstBooking) {
                if ($firstBooking->boothBranding?->booth_banner) {
                    $bannerPath = $firstBooking->boothBranding->booth_banner;
                    $image = str_starts_with($bannerPath, 'storage/') ? $bannerPath : 'storage/' . $bannerPath;
                } elseif ($firstBooking->boothProfile?->company_logo) {
                    $logoPath = $firstBooking->boothProfile->company_logo;
                    $image = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
                } elseif ($firstBooking->company?->logo) {
                    $logoPath = $firstBooking->company->logo;
                    $image = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
                }
            }
            $companyCount = $publishedBookings->filter(fn ($booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))->count();
            $companyNames = $publishedBookings
                ->map(fn ($booking) => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
                ->filter()
                ->take(3)
                ->values();
            $productsCount = $publishedBookings->sum(fn ($booking) => $booking->boothProducts?->where('status', 'published')->count() ?? 0);
            $cataloguesCount = $publishedBookings->sum(fn ($booking) => $booking->boothCatalogues?->where('status', 'active')->where('visibility', 'public')->count() ?? 0);

            return [
                'slug' => $item->slug,
                'title' => $item->title,
                'date' => optional($item->start_date)->format('F j') . ' - ' . optional($item->end_date)->format('j, Y'),
                'time' => '10:00 AM - 7:00 PM IST',
                'location' => $item->location ?: 'Virtual',
                'category' => 'Technology',
                'status' => 'Live registration',
                'visitors' => '24,000+',
                'companies' => (string) max($companyCount, 1),
                'halls' => (string) max($publishedBookings->pluck('hall_id')->filter()->unique()->count(), 1),
                'sessions' => (string) max(collect($publishedBookings)->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0), 1),
                'pass' => 'Free visitor pass available',
                'image' => $image,
                'accent' => '#5b2eff',
                'meta' => trim($productsCount . ' products / ' . $cataloguesCount . ' catalogues'),
                'company_names' => $companyNames->all(),
            ];
        })->values()->all()
        : $fallbackExhibitions;

    $visitorTools = [
        ['Companies', 'Search exhibitors, products, brochures and booth locations.', 'fa-solid fa-building'],
        ['Floor map', 'Preview halls and jump directly to company booth pages.', 'fa-regular fa-map'],
        ['Visitor pass', 'Register once and carry a QR pass for dashboard access.', 'fa-regular fa-id-card'],
        ['Meetings', 'Book meetings, join sessions and continue live chat after entry.', 'fa-regular fa-calendar-check'],
    ];
@endphp

<section class="bg-white">
    <div class="mx-auto max-w-[1440px] px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <div class="grid items-center gap-8 lg:grid-cols-[0.86fr_1.14fr]">
            <div class="max-w-[620px]">
                <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">Visitor Exhibitions</p>
                <h1 class="mt-3 text-[36px] font-black leading-[1.04] tracking-[-0.045em] text-[#071044] sm:text-[54px] lg:text-[62px]">
                    Explore expos.<br>
                    Meet companies.<br>
                    <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">Get your QR pass.</span>
                </h1>
                <p class="mt-5 max-w-[540px] text-[15px] font-medium leading-[1.65] text-[#1F2B55] sm:text-[17px]">
                    Browse exhibitions, preview pavilion halls and company booths, then register for your visitor pass to unlock meetings, chat, brochures, demos and sessions.
                </p>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-5">
                    <a href="#exhibition-list" class="inline-flex w-full items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-4 text-[15px] font-bold text-white shadow-[0_14px_30px_rgba(91,46,255,0.28)] sm:w-auto sm:px-7">
                        <i class="far fa-building text-lg"></i> Browse Exhibitions
                    </a>
                    <a href="{{ route('exhibitions.show', 'global-tech-expo-2024') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-6 py-4 text-[15px] font-bold text-[#071044] shadow-sm hover:bg-[#F8F7FF] sm:w-auto sm:px-7">
                        <i class="far fa-id-card text-lg text-gray-500"></i> Featured Expo
                    </a>
                </div>
            </div>

            <div class="min-w-0">
                <div class="overflow-hidden rounded-[18px] border border-[#DCE1EE] bg-[#F8F9FD] shadow-[0_16px_40px_rgba(7,16,68,0.08)]">
                    <div class="flex items-center justify-between gap-3 border-b border-[#DCE1EE] bg-white px-4 py-3">
                        <div class="flex gap-2 overflow-x-auto text-[12px] font-bold">
                            <span class="rounded-lg bg-[#6D28D9] px-4 py-2 text-white">Pavilions</span>
                            <span class="rounded-lg px-4 py-2 text-[#34405F]">Halls</span>
                            <span class="rounded-lg px-4 py-2 text-[#34405F]">Booths</span>
                        </div>
                        <span class="hidden rounded-full border border-green-200 bg-[#E9FFF2] px-3 py-1 text-[10px] font-bold text-[#0A9A55] sm:inline-flex">VISITOR PREVIEW</span>
                    </div>
                    <img src="{{ asset('images/exhibitions/hero-pavilion-scene.png') }}" alt="Virtual pavilion exhibition hall" class="h-[240px] w-full object-cover sm:h-[360px] lg:h-[410px]">
                </div>
            </div>
        </div>

        <div class="mt-7 grid items-stretch gap-4 lg:grid-cols-[1fr_1fr]">
            <div class="grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 sm:grid-cols-4">
                @foreach ([['900+', 'Companies', 'fa-solid fa-store', '#6325E6'], ['31', 'Halls', 'fa-regular fa-map', '#FF9B41'], ['160+', 'Sessions', 'fa-regular fa-circle-play', '#3478E5'], ['QR', 'Visitor Pass', 'fa-solid fa-qrcode', '#48C4AE']] as [$value, $label, $icon, $color])
                    <div class="flex items-center gap-3 rounded-xl border border-[#E7EAF3] bg-white p-3 shadow-sm">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full text-white" style="background-color: {{ $color }}">
                            <i class="{{ $icon }} text-lg"></i>
                        </span>
                        <p class="text-[13px] font-bold leading-tight">{{ $value }}<br><span class="font-medium">{{ $label }}</span></p>
                    </div>
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-2 rounded-2xl border border-[#E7EAF3] bg-white p-3 shadow-[0_10px_28px_rgba(7,16,68,0.07)] sm:grid-cols-4">
                @foreach ($visitorTools as [$title, $copy, $icon])
                    <div class="flex min-h-[76px] flex-col items-center justify-center rounded-xl text-center text-[12px] font-semibold text-gray-700 transition-colors hover:bg-[#F8F7FF] hover:text-[#6D28D9]">
                        <div class="mb-1.5 text-[20px]"><i class="{{ $icon }}"></i></div>
                        {{ $title }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-[#F8F8FC] px-4 py-7 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-[1440px]">

        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-4 shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
            <div class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                <label class="relative block">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#7A819A]"></i>
                    <input type="text" placeholder="Search exhibition, company, category or city" class="h-12 w-full rounded-xl border border-[#E7EAF3] bg-white pl-11 pr-4 text-[14px] font-semibold text-[#071044] outline-none placeholder:text-[#8A90A8] focus:border-[#5b2eff]">
                </label>
                <div class="grid gap-2 sm:grid-cols-4 lg:w-[620px]">
                    @foreach (['All', 'Technology', 'Healthcare', 'Hybrid'] as $filter)
                        <button class="h-12 rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] px-4 text-[13px] font-extrabold text-[#071044] hover:border-[#5b2eff] hover:bg-[#F4F0FF] hover:text-[#5b2eff]">
                            {{ $filter }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="exhibition-list" class="mt-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">Upcoming exhibitions</p>
                    <h2 class="mt-2 text-[28px] font-black leading-tight tracking-[-0.03em] text-[#071044] sm:text-[38px]">Choose your next expo visit</h2>
                </div>
                <a href="{{ route('exhibitions.visitor.dashboard', 'global-tech-expo-2024') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-[#D8DCEB] bg-white px-5 py-3 text-[13px] font-extrabold text-[#071044] shadow-sm hover:bg-[#F8F7FF]">
                    <i class="fa-solid fa-house text-[#6D28D9]"></i>
                    Visitor Dashboard
                </a>
            </div>

            <div class="mt-5 grid gap-5 lg:grid-cols-3">
                @foreach ($exhibitions as $exhibition)
                    <article class="flex min-h-[520px] flex-col overflow-hidden rounded-[14px] border border-[#E7EAF3] bg-white shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition-transform hover:-translate-y-1">
                        <div class="relative h-[210px] bg-[#071044]">
                            @php
                                $imageUrl = $exhibition['image'];
                                if (!str_starts_with($imageUrl, 'http://') && !str_starts_with($imageUrl, 'https://')) {
                                    if (str_starts_with($imageUrl, 'images/') || str_starts_with($imageUrl, 'assets/')) {
                                        $imageUrl = asset($imageUrl);
                                    } else {
                                        $imageUrl = asset(str_starts_with($imageUrl, 'storage/') ? $imageUrl : 'storage/' . $imageUrl);
                                    }
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $exhibition['title'] }}" class="h-full w-full object-cover">
                            <div class="absolute left-4 top-4 rounded-full bg-white px-3 py-1.5 text-[11px] font-extrabold text-[#6D28D9] shadow-sm">{{ $exhibition['category'] }}</div>
                            <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-[#071044]/70 to-transparent"></div>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full bg-[#F4F0FF] px-3 py-1 text-[11px] font-extrabold text-[#6D28D9]">{{ $exhibition['status'] }}</span>
                                <span class="rounded-full bg-[#E9FFF2] px-3 py-1 text-[11px] font-extrabold text-[#0A7A58]">{{ $exhibition['pass'] }}</span>
                            </div>

                            <h3 class="mt-4 min-h-[58px] text-[24px] font-black leading-[29px] tracking-[-0.03em] text-[#071044]">{{ $exhibition['title'] }}</h3>
                            <div class="mt-3 space-y-2 text-[14px] font-semibold leading-5 text-[#53607C]">
                                <p class="flex gap-2"><i class="fa-regular fa-calendar mt-0.5 w-4 text-[#6D28D9]"></i><span>{{ $exhibition['date'] }}</span></p>
                                <p class="flex gap-2"><i class="fa-regular fa-clock mt-0.5 w-4 text-[#6D28D9]"></i><span>{{ $exhibition['time'] }}</span></p>
                                <p class="flex gap-2"><i class="fa-solid fa-location-dot mt-0.5 w-4 text-[#6D28D9]"></i><span>{{ $exhibition['location'] }}</span></p>
                            </div>

                            <div class="mt-5 grid grid-cols-4 gap-2">
                                @foreach ([[$exhibition['visitors'], 'Visitors'], [$exhibition['companies'], 'Companies'], [$exhibition['halls'], 'Halls'], [$exhibition['sessions'], 'Sessions']] as [$value, $label])
                                    <div class="rounded-xl bg-[#F8F8FC] p-3 text-center">
                                        <p class="text-[14px] font-black text-[#071044]">{{ $value }}</p>
                                        <p class="mt-1 text-[10px] font-bold text-[#6B7280]">{{ $label }}</p>
                                    </div>
                                @endforeach
                            </div>

                            @if (! empty($exhibition['company_names']))
                                <div class="mt-4 rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-3">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#6D28D9]">Published companies</p>
                                    <p class="mt-1 line-clamp-2 text-[13px] font-bold leading-5 text-[#071044]">{{ implode(', ', $exhibition['company_names']) }}</p>
                                </div>
                            @endif

                            <div class="mt-auto grid gap-3 pt-5 sm:grid-cols-3">
                                <a href="{{ route('exhibitions.show', $exhibition['slug']) }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-4 text-[13px] font-extrabold text-white">Details</a>
                                <a href="{{ route('exhibitions.visitor.companies', $exhibition['slug']) }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8DCEB] px-4 text-[13px] font-extrabold text-[#071044] hover:bg-[#F8F7FF]">Companies</a>
                                <a href="{{ route('exhibitions.tickets.select', $exhibition['slug']) }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8DCEB] px-4 text-[13px] font-extrabold text-[#071044] hover:bg-[#F8F7FF]">Get Pass</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6 grid gap-5 lg:grid-cols-[1.05fr_0.95fr]">
                <div class="rounded-[14px] border border-[#E7EAF3] bg-white p-5 shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">Visitor access</p>
                            <h3 class="mt-2 text-[22px] font-black tracking-[-0.03em] text-[#071044]">Guest preview first, pass access after registration.</h3>
                        </div>
                        <p class="rounded-xl bg-[#F4F0FF] px-4 py-3 text-[13px] font-extrabold text-[#6D28D9]">Register / Get Pass to access this feature</p>
                    </div>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ([['Preview allowed', 'Exhibition details, companies, booth previews, floor map and schedule previews.'], ['Pass required', 'Book meeting, live chat, brochure download, protected demo, join session and save booth.']] as [$heading, $copy])
                            <div class="rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-4">
                                <p class="text-[14px] font-extrabold text-[#071044]">{{ $heading }}</p>
                                <p class="mt-1 text-[13px] font-medium leading-5 text-[#5A6480]">{{ $copy }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[14px] border border-[#E7EAF3] bg-[#071A55] p-5 text-white shadow-[0_14px_34px_rgba(7,16,68,0.18)]">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-white/65">Suggested route</p>
                            <h3 class="mt-2 text-[22px] font-black tracking-[-0.03em]">Open, explore, register, enter.</h3>
                        </div>
                        <a href="{{ route('exhibitions.visit', 'global-tech-expo-2024') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-white px-5 py-3 text-[13px] font-extrabold text-[#071044]">
                            Preview Visitor Lobby
                        </a>
                    </div>
                    <div class="mt-5 grid gap-3 sm:grid-cols-4">
                        @foreach ([['01', 'Detail'], ['02', 'Companies'], ['03', 'Map'], ['04', 'QR Pass']] as [$step, $label])
                            <div class="rounded-xl bg-white/10 p-3">
                                <span class="grid h-8 w-8 place-items-center rounded-full bg-white text-[12px] font-extrabold text-[#6D28D9]">{{ $step }}</span>
                                <p class="mt-2 text-[13px] font-bold text-white/90">{{ $label }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
