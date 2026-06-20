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
            $publishedBookings = $item->boothBookings ?? collect();
            $image = $item->banner_image ?: ($item->banner_url ?: 'images/exhibitions/hero-pavilion-scene.png');
            $companyNames = $publishedBookings
                ->map(fn ($booking) => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
                ->filter()
                ->unique(fn ($name) => strtolower(trim($name)))
                ->values();
            $companyCount = $companyNames->count();
            $productsCount = $publishedBookings->sum(fn ($booking) => $booking->boothProducts?->where('status', 'published')->count() ?? 0);
            $cataloguesCount = $publishedBookings->sum(fn ($booking) => $booking->boothCatalogues?->where('status', 'active')->where('visibility', 'public')->count() ?? 0);

            return [
                'slug' => $item->slug,
                'title' => $item->title,
                'date' => optional($item->start_date)->format('F j') . ' - ' . optional($item->end_date)->format('j, Y'),
                'time' => '10:00 AM - 7:00 PM IST',
                'location' => $item->venue ?: ($item->location ?: 'Virtual'),
                'category' => str_contains(strtolower((string) ($item->location ?: $item->venue ?: '')), 'virtual') ? 'Virtual' : 'On-site / Hybrid',
                'status' => $item->start_date && $item->start_date->isFuture() ? 'Upcoming' : 'Live registration',
                'visitors' => (string) ($item->companies_count ?: max($companyCount, 0)),
                'companies' => (string) $companyCount,
                'halls' => (string) max($publishedBookings->pluck('hall_id')->filter()->unique()->count(), 1),
                'sessions' => (string) max(collect($publishedBookings)->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0), 1),
                'pass' => 'Free visitor pass available',
                'image' => $image,
                'accent' => '#5b2eff',
                'meta' => trim($productsCount . ' products / ' . $cataloguesCount . ' catalogues'),
                'company_names' => $companyNames->take(3)->all(),
            ];
        })->values()->all()
        : $fallbackExhibitions;

    $featuredExhibition = isset($dynamicExhibitions) && $dynamicExhibitions->isNotEmpty()
        ? $dynamicExhibitions->first()
        : \App\Support\LiveContent::exhibitionPageQuery()->orderBy('start_date')->first();
    $heroExhibition = $exhibitions[0] ?? null;

    if ($featuredExhibition) {
        $featuredPublishedBookings = $featuredExhibition->boothBookings ?? collect();
        $featuredPavilionsCount = \App\Domain\Event\Models\Pavilion::query()
            ->where('exhibition_id', $featuredExhibition->id)
            ->where('status', 'active')
            ->count();
        $featuredHallsCount = \App\Domain\Event\Models\Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $featuredExhibition->id))
            ->where('status', 'active')
            ->count();
        $featuredBoothsCount = \App\Domain\Booth\Models\Booth::query()
            ->whereHas('hall.pavilion', fn ($query) => $query->where('exhibition_id', $featuredExhibition->id))
            ->count();
        $featuredCompanyCount = $featuredPublishedBookings
            ->map(fn ($booking) => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
            ->filter()
            ->unique(fn ($name) => strtolower(trim((string) $name)))
            ->count();
        $featuredSessionsCount = max($featuredPublishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0), 1);
        $featuredPavilionsCount = max($featuredPavilionsCount, 1);
        $featuredHallsCount = max($featuredHallsCount, 1);
        $featuredBoothsCount = max($featuredBoothsCount, 1);
        $featuredStatus = $featuredExhibition->start_date && $featuredExhibition->start_date->isFuture() ? 'Upcoming' : 'Live registration';

        $heroImage = $featuredExhibition->banner_image ?: ($featuredExhibition->banner_url ?: ($heroExhibition['image'] ?? 'images/exhibitions/hero-pavilion-scene.png'));
        if (\Illuminate\Support\Str::startsWith($heroImage, ['http://', 'https://'])) {
            $heroImageUrl = $heroImage;
        } elseif (\Illuminate\Support\Str::startsWith($heroImage, ['images/', 'assets/', 'storage/'])) {
            $heroImageUrl = asset($heroImage);
        } else {
            $heroImageUrl = asset('storage/' . ltrim($heroImage, '/'));
        }
    } else {
        $featuredCompanyCount = (int) ($heroExhibition['companies'] ?? 0);
        $featuredHallsCount = (int) ($heroExhibition['halls'] ?? 0);
        $featuredSessionsCount = (int) ($heroExhibition['sessions'] ?? 0);
        $featuredBoothsCount = 1;
        $featuredPavilionsCount = 1;
        $featuredStatus = $heroExhibition['status'] ?? 'Visitor Preview';
        $heroImage = $heroExhibition['image'] ?? 'images/exhibitions/hero-pavilion-scene.png';
        $heroImageUrl = \Illuminate\Support\Str::startsWith($heroImage, ['http://', 'https://'])
            ? $heroImage
            : asset($heroImage);
    }

    if (isset($dynamicExhibitions) && $dynamicExhibitions->isNotEmpty()) {
        $aggregatePublishedBookings = $dynamicExhibitions
            ->flatMap(fn ($item) => $item->boothBookings ?? collect())
            ->values();

        $aggregateCompanyCount = $aggregatePublishedBookings
            ->map(fn ($booking) => $booking->company_id ?: strtolower(trim((string) ($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))))
            ->filter()
            ->unique()
            ->count();
        $aggregateHallCount = $aggregatePublishedBookings->pluck('hall_id')->filter()->unique()->count();
        $aggregateSessionCount = $aggregatePublishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0);
    } else {
        $aggregateCompanyCount = $featuredCompanyCount;
        $aggregateHallCount = $featuredHallsCount;
        $aggregateSessionCount = $featuredSessionsCount;
    }

    $heroStats = [
        [number_format($aggregateCompanyCount), 'Companies', 'fa-solid fa-store', '#6325E6'],
        [number_format($aggregateHallCount), 'Halls', 'fa-regular fa-map', '#FF9B41'],
        [number_format($aggregateSessionCount), 'Sessions', 'fa-regular fa-circle-play', '#3478E5'],
        ['QR', 'Visitor Pass', 'fa-solid fa-qrcode', '#48C4AE'],
    ];
    $exhibitionFilters = ['All', 'Technology', 'Healthcare'];
    $heroPavilionsCount = $featuredPavilionsCount;
    $heroHallsCount = $featuredHallsCount;
    $heroBoothsCount = $featuredBoothsCount;
    $heroPreviewStatus = strtoupper($featuredStatus);

    $visitorTools = [
        ['Companies', 'Search exhibitors, products, brochures and booth locations.', 'fa-solid fa-building'],
        ['Floor map', 'Preview halls and jump directly to company booth pages.', 'fa-regular fa-map'],
        ['Visitor pass', 'Register once and carry a QR pass for dashboard access.', 'fa-regular fa-id-card'],
        ['Meetings', 'Book meetings, join sessions and continue live chat after entry.', 'fa-regular fa-calendar-check'],
    ];
    $featuredSlug = $heroExhibition['slug'] ?? 'global-tech-expo-2024';
    $visitorAccessCards = [
        ['Preview allowed', ($heroExhibition['title'] ?? 'Exhibition') . ' details, companies, booth previews, floor map and schedule previews.'],
        ['Pass required', 'Book meeting, live chat, brochure download, protected demo, join session and save booth.'],
    ];
    $suggestedRouteSteps = [
        ['01', 'Detail', route('exhibitions.show', $featuredSlug)],
        ['02', 'Companies', route('exhibitions.visitor.companies', $featuredSlug)],
        ['03', 'Map', route('exhibitions.visitor-halls.index', $featuredSlug)],
        ['04', 'QR Pass', route('exhibitions.tickets.select', $featuredSlug)],
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
                    <a href="{{ $featuredExhibition ? route('exhibitions.show', $featuredExhibition->slug) : '#exhibition-list' }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-6 py-4 text-[15px] font-bold text-[#071044] shadow-sm hover:bg-[#F8F7FF] sm:w-auto sm:px-7">
                        <i class="far fa-id-card text-lg text-gray-500"></i> Featured Expo
                    </a>
                </div>
            </div>

            <div class="min-w-0">
                <div class="overflow-hidden rounded-[18px] border border-[#DCE1EE] bg-[#F8F9FD] shadow-[0_16px_40px_rgba(7,16,68,0.08)]">
                    <div class="flex items-center justify-between gap-3 border-b border-[#DCE1EE] bg-white px-4 py-3">
                        <div class="flex gap-2 overflow-x-auto text-[12px] font-bold">
                            <span class="rounded-lg bg-[#6D28D9] px-4 py-2 text-white">Pavilions {{ $heroPavilionsCount }}</span>
                            <span class="rounded-lg px-4 py-2 text-[#34405F]">Halls {{ $heroHallsCount }}</span>
                            <span class="rounded-lg px-4 py-2 text-[#34405F]">Booths {{ $heroBoothsCount }}</span>
                        </div>
                        <span class="hidden rounded-full border border-green-200 bg-[#E9FFF2] px-3 py-1 text-[10px] font-bold text-[#0A9A55] sm:inline-flex">{{ $heroPreviewStatus }}</span>
                    </div>
                    <img src="{{ $heroImageUrl }}" alt="{{ $heroExhibition['title'] ?? 'Virtual pavilion exhibition hall' }}" class="h-[240px] w-full object-cover sm:h-[360px] lg:h-[410px]">
                </div>
            </div>
        </div>

        <div class="mt-7 grid items-stretch gap-4 lg:grid-cols-[1fr_1fr]">
            <div class="grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 sm:grid-cols-4">
                @foreach ($heroStats as [$value, $label, $icon, $color])
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
                    <input id="exhibition-search" type="text" placeholder="Search exhibition, company, category or city" class="h-12 w-full rounded-xl border border-[#E7EAF3] bg-white pl-11 pr-4 text-[14px] font-semibold text-[#071044] outline-none placeholder:text-[#8A90A8] focus:border-[#5b2eff]">
                </label>
                <div class="grid gap-2 sm:grid-cols-3 lg:w-[460px]">
                    @foreach ($exhibitionFilters as $filter)
                        <button type="button" data-exhibition-filter="{{ $filter }}" class="h-12 rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] px-4 text-[13px] font-extrabold text-[#071044] hover:border-[#5b2eff] hover:bg-[#F4F0FF] hover:text-[#5b2eff]">
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
                <a href="{{ route('exhibitions.visitor.dashboard', $featuredSlug) }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-[#D8DCEB] bg-white px-5 py-3 text-[13px] font-extrabold text-[#071044] shadow-sm hover:bg-[#F8F7FF]">
                    <i class="fa-solid fa-house text-[#6D28D9]"></i>
                    Visitor Dashboard
                </a>
            </div>

            <div class="mt-5 grid gap-5 lg:grid-cols-3">
                @foreach ($exhibitions as $exhibition)
                    <article data-exhibition-card data-category="{{ $exhibition['category'] }}" data-search="{{ strtolower($exhibition['title'] . ' ' . $exhibition['category'] . ' ' . $exhibition['location'] . ' ' . implode(' ', $exhibition['company_names'] ?? [])) }}" class="flex min-h-[520px] flex-col overflow-hidden rounded-[14px] border border-[#E7EAF3] bg-white shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition-transform hover:-translate-y-1">
                        <div class="relative bg-[#071044]" style="height: 210px; overflow: hidden;">
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
                            <img src="{{ $imageUrl }}" alt="{{ $exhibition['title'] }}" class="h-full w-full object-cover" style="height: 100%; width: 100%; object-fit: cover;">
                            <div class="absolute left-4 top-4 rounded-full bg-white px-3 py-1.5 text-[11px] font-extrabold text-[#6D28D9] shadow-sm">{{ $exhibition['category'] }}</div>
                            <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-[#071044]/70 to-transparent"></div>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full bg-[#F4F0FF] px-3 py-1 text-[11px] font-extrabold text-[#6D28D9]">{{ $exhibition['status'] }}</span>
                                <span class="rounded-full bg-[#E9FFF2] px-3 py-1 text-[11px] font-extrabold text-[#0A7A58]">{{ $exhibition['pass'] }}</span>
                            </div>

                            <h3 class="mt-4 line-clamp-2 text-[24px] font-black leading-[29px] tracking-[-0.03em] text-[#071044]" title="{{ $exhibition['title'] }}" style="min-height: 58px;">{{ $exhibition['title'] }}</h3>
                            <div class="mt-3 space-y-2 text-[14px] font-semibold leading-5 text-[#53607C]" style="min-height: 80px;">
                                <p class="flex gap-2"><i class="fa-regular fa-calendar mt-0.5 w-4 text-[#6D28D9]"></i><span>{{ $exhibition['date'] }}</span></p>
                                <p class="flex gap-2"><i class="fa-regular fa-clock mt-0.5 w-4 text-[#6D28D9]"></i><span>{{ $exhibition['time'] }}</span></p>
                                <p class="flex gap-2"><i class="fa-solid fa-location-dot mt-0.5 w-4 text-[#6D28D9]"></i><span>{{ $exhibition['location'] }}</span></p>
                            </div>

                            <div class="mt-5 grid grid-cols-4 gap-1.5">
                                @foreach ([[$exhibition['visitors'], 'Visitors'], [$exhibition['companies'], 'Companies'], [$exhibition['halls'], 'Halls'], [$exhibition['sessions'], 'Sessions']] as [$value, $label])
                                    <div class="rounded-lg bg-[#F8F8FC] p-2 text-center flex flex-col justify-center" style="min-height: 54px;">
                                        <p class="text-[13px] font-black text-[#071044] truncate" title="{{ $value }}">{{ $value }}</p>
                                        <p class="mt-0.5 text-[10px] font-bold text-[#6B7280] truncate">{{ $label }}</p>
                                    </div>
                                @endforeach
                            </div>

                            @if (! empty($exhibition['company_names']))
                                <div class="mt-4 rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-3 flex flex-col justify-center" style="height: 74px;">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#6D28D9]">Published companies</p>
                                    <p class="mt-1 line-clamp-1 text-[13px] font-bold leading-5 text-[#071044]">{{ implode(', ', $exhibition['company_names']) }}</p>
                                </div>
                            @else
                                <div class="mt-4 rounded-xl border border-dashed border-[#E7EAF3] bg-white p-3 flex flex-col justify-center" style="height: 74px;">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#A0A8BC]">Published companies</p>
                                    <p class="mt-1 text-[13px] font-medium leading-5 text-[#8A90A8] italic">No companies published yet</p>
                                </div>
                            @endif

                            <div class="mt-auto flex flex-col gap-2 pt-5">
                                <a href="{{ route('exhibitions.show', $exhibition['slug']) }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-4 text-[13px] font-extrabold text-white w-full">Details</a>
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('exhibitions.visitor.companies', $exhibition['slug']) }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-[#D8DCEB] px-2 text-[13px] font-extrabold text-[#071044] hover:bg-[#F8F7FF] truncate">Companies</a>
                                    <a href="{{ route('exhibitions.tickets.select', $exhibition['slug']) }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-[#D8DCEB] px-2 text-[13px] font-extrabold text-[#071044] hover:bg-[#F8F7FF] truncate">Get Pass</a>
                                </div>
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
                        @foreach ($visitorAccessCards as [$heading, $copy])
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
                        <a href="{{ route('exhibitions.visit', $featuredSlug) }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-white px-5 py-3 text-[13px] font-extrabold text-[#071044]">
                            Preview Visitor Lobby
                        </a>
                    </div>
                    <div class="mt-5 grid gap-3 sm:grid-cols-4">
                        @foreach ($suggestedRouteSteps as [$step, $label, $href])
                            <a href="{{ $href }}" class="rounded-xl bg-white/10 p-3 transition hover:bg-white/15">
                                <span class="grid h-8 w-8 place-items-center rounded-full bg-white text-[12px] font-extrabold text-[#6D28D9]">{{ $step }}</span>
                                <p class="mt-2 text-[13px] font-bold text-white/90">{{ $label }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<script>
    (() => {
        const searchInput = document.getElementById('exhibition-search');
        const filterButtons = document.querySelectorAll('[data-exhibition-filter]');
        const cards = document.querySelectorAll('[data-exhibition-card]');
        let activeFilter = 'All';

        const applyFilters = () => {
            const search = (searchInput?.value || '').trim().toLowerCase();

            cards.forEach((card) => {
                const matchesSearch = ! search || card.dataset.search.includes(search);
                const matchesFilter = activeFilter === 'All' || card.dataset.category === activeFilter;
                card.classList.toggle('hidden', ! (matchesSearch && matchesFilter));
            });
        };

        filterButtons.forEach((button) => {
            button.addEventListener('click', () => {
                activeFilter = button.dataset.exhibitionFilter;
                filterButtons.forEach((item) => item.classList.remove('border-[#5b2eff]', 'bg-[#F4F0FF]', 'text-[#5b2eff]'));
                button.classList.add('border-[#5b2eff]', 'bg-[#F4F0FF]', 'text-[#5b2eff]');
                applyFilters();
            });
        });

        searchInput?.addEventListener('input', applyFilters);
    })();
</script>
@endsection
