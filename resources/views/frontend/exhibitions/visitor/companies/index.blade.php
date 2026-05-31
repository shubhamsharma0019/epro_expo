@extends('layouts.frontend')

@section('title', 'Participating Companies - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
    $isPassActive = $isPassActive ?? false;
    $companies = isset($booths)
        ? $booths->map(function ($booking) {
            $company = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;

            return [
                \Illuminate\Support\Str::slug($company),
                $company,
                $booking->boothProfile?->tagline ?: $booking->boothProfile?->about_company ?: 'Visit this booth to explore products, documents, catalogues and meeting options.',
                $booking->hall?->title ?: 'Hall',
                $booking->booth?->booth_number ?: 'N/A',
                $booking->boothProfile?->industry ?: $booking->company?->industry ?: 'Exhibitor',
                match ($booking->booth_setup_status ?? 'published') {
                    'pending_review', 'submitted_for_review' => 'Pending review',
                    'setup_in_progress', 'ready_to_publish', 'in_progress' => 'Setup in progress',
                    default => 'Live',
                },
                ($booking->published_products_count ?? 0) . ' Products',
                ($booking->public_catalogues_count ?? 0) . ' Catalogues',
                $booking->boothProfile?->company_logo ? 'storage/' . $booking->boothProfile->company_logo : 'images/home/booth-preview-new.png',
            ];
        })->filter(fn ($company) => filled($company[1]))->values()->all()
        : [];

    // Calculate dynamic statistics
    $boothsCount = isset($booths) ? $booths->count() : 0;
    $hallsCount = isset($booths) ? $booths->pluck('hall_id')->filter()->unique()->count() : 0;
    $sessionsCount = isset($booths) ? $booths->sum(fn($b) => $b->boothSessions->count()) : 0;
    
    $displayBooths = $boothsCount > 0 ? (string)$boothsCount : '0';
    $displayHalls = $hallsCount > 0 ? (string)$hallsCount : '0';
    $displaySessions = $sessionsCount > 0 ? (string)$sessionsCount : '0';

    // Resolve sidebar card image dynamically
    $publishedBookings = ($booths ?? collect());
    $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
        ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);
         
    $sidebarImage = 'images/home/booth-preview-new.png';
    if ($firstBooking) {
        if ($firstBooking->boothBranding?->booth_banner) {
            $bannerPath = $firstBooking->boothBranding->booth_banner;
            $sidebarImage = str_starts_with($bannerPath, 'storage/') ? $bannerPath : 'storage/' . $bannerPath;
        } elseif ($firstBooking->boothProfile?->company_logo) {
            $logoPath = $firstBooking->boothProfile->company_logo;
            $sidebarImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
        } elseif ($firstBooking->company?->logo) {
            $logoPath = $firstBooking->company->logo;
            $sidebarImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
        }
    }
    
    if (str_starts_with($sidebarImage, 'http://') || str_starts_with($sidebarImage, 'https://')) {
        // Keep absolute URLs as is
    } elseif (str_starts_with($sidebarImage, 'images/') || str_starts_with($sidebarImage, 'assets/') || str_starts_with($sidebarImage, 'storage/')) {
        $sidebarImage = asset($sidebarImage);
    } else {
        $sidebarImage = asset('storage/' . $sidebarImage);
    }
@endphp

<section class="max-w-[1500px] px-5 py-6 sm:px-8 lg:px-10 lg:py-8">
    <div class="mb-6 overflow-hidden rounded-[14px] border border-[#E7EAF3] bg-white shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
        <div class="grid gap-0 xl:grid-cols-[minmax(0,1fr)_310px]">
            <div class="p-5 lg:p-6">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-[#F4F0FF] px-3 py-1.5 text-[12px] font-semibold text-purple">
                    <i class="fa-solid fa-store"></i>
                    Visitor company directory
                </div>

                <h1 class="text-[30px] font-black leading-[36px] tracking-[-0.9px] text-navy sm:text-[42px] sm:leading-[46px]">
                    Participating <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">Companies</span>
                </h1>

                <p class="mt-3 max-w-[880px] text-[15px] font-medium leading-6 text-[#5A6480]">
                    Explore exhibitors by company, category, hall and booth number. Guests can preview company details; active visitor pass holders can save booths, book meetings, chat, download brochures and watch protected demos.
                </p>

                <div class="mt-5 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                    <label class="relative block">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
                        <input type="text" placeholder="Search companies, products, categories, halls..." class="h-[46px] w-full rounded-lg border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium outline-none placeholder:text-[#6B7280] focus:border-purple">
                    </label>

                    <div class="flex flex-wrap gap-2">
                        @foreach (['All', 'Technology', 'Healthcare', 'Finance', 'Education'] as $filter)
                            <button class="h-[38px] rounded-full border border-borderColor bg-[#FBFAFF] px-4 text-[12px] font-semibold text-[#34405F] hover:border-purple hover:bg-[#F4F0FF] hover:text-purple">
                                {{ $filter }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="border-t border-borderColor bg-[#F8F9FD] p-5 xl:border-l xl:border-t-0">
                <div class="rounded-xl bg-white p-3 shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
                    <img src="{{ $sidebarImage }}" alt="Company booth preview" class="h-[132px] w-full rounded-lg object-cover">
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex h-[42px] items-center justify-center gap-2 rounded-lg border border-borderColor bg-white px-3 text-[12px] font-semibold text-navy">
                            <i class="fa-regular fa-map"></i>
                            Floor Map
                        </a>
                        <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="inline-flex h-[42px] items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-3 text-[12px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                            <i class="fa-regular fa-id-card"></i>
                            Get Pass
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([[$displayBooths, 'Companies'], [$displayHalls, 'Halls'], [$displaySessions, 'Sessions'], [$isPassActive ? 'Active' : 'Guest', 'Access']] as [$value, $label])
            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm">
                <p class="text-[24px] font-semibold leading-none text-navy">{{ $value }}</p>
                <p class="mt-1.5 text-[13px] font-medium text-[#5A6480]">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    @unless ($isPassActive)
        <div class="mb-5 rounded-xl border border-[#EADCFD] bg-[#FBFAFF] p-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-[18px] font-semibold text-navy">Guest preview mode</h2>
                    <p class="mt-1 text-[14px] font-medium text-[#5A6480]">Register / Get Pass to access meeting booking, live chat, brochures, demos, sessions and saved booths.</p>
                </div>
                <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="inline-flex h-[44px] items-center justify-center rounded-md bg-[#5b2eff] px-5 text-[13px] font-semibold text-white">Get Visitor Pass</a>
            </div>
        </div>
    @endunless

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($companies as [$companySlug, $company, $summary, $hall, $booth, $category, $status, $products, $brochures, $image])
            <article class="flex min-h-[315px] flex-col rounded-xl border border-[#E7EAF3] bg-white p-4 shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition-transform hover:-translate-y-1">
                <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-[#6D28D9] text-[17px] font-black text-white">
                            {{ substr($company, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="truncate text-[16px] font-extrabold leading-5 text-navy">{{ $company }}</h2>
                            <p class="mt-1 text-[12px] font-bold text-[#6D28D9]">{{ $hall }} / Booth {{ $booth }}</p>
                        </div>
                    </div>
                    <span class="rounded-full border border-green-200 bg-[#E9FFF2] px-2 py-1 text-[10px] font-bold text-[#0A9A55]">{{ $isPassActive ? 'UNLOCKED' : 'PREVIEW' }}</span>
                </div>

                <div class="overflow-hidden rounded-lg border border-[#DCE1EE] bg-[#F8F9FD]">
                    <img src="{{ asset($image) }}" alt="{{ $company }} preview" class="h-[112px] w-full object-cover">
                </div>

                <div class="mt-4 flex flex-1 flex-col">
                    <div class="flex flex-wrap gap-2">
                        <span class="rounded-lg bg-[#F4F0FF] px-3 py-1.5 text-[11px] font-bold text-[#6D28D9]">{{ $category }}</span>
                        <span class="rounded-lg bg-[#FBFAFF] px-3 py-1.5 text-[11px] font-bold text-[#34405F]">{{ $status }}</span>
                    </div>

                    <p class="mt-3 line-clamp-2 text-[13px] font-medium leading-6 text-[#1F2B55]">{{ $summary }}</p>

                    <div class="mt-3 grid grid-cols-2 gap-2 text-[12px] font-bold text-[#34405F]">
                        <span class="rounded-lg border border-[#DCE1EE] px-3 py-2">{{ $products }}</span>
                        <span class="rounded-lg border border-[#DCE1EE] px-3 py-2">{{ $brochures }}</span>
                    </div>

                    <div class="mt-auto grid grid-cols-[1fr_1fr_auto] gap-2 pt-4">
                        <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#6D28D9] px-3 text-[12px] font-bold text-white hover:bg-[#5726E8]">
                            Open Booth
                        </a>
                        <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#DCE1EE] px-3 text-[12px] font-bold text-navy hover:bg-[#F8F7FF]">
                            Map
                        </a>
                        <button class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#DCE1EE] text-[#6D28D9] hover:bg-[#F8F7FF]" title="{{ $isPassActive ? 'Save booth' : 'Register / Get Pass to access this feature' }}">
                            <i class="fa-regular fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-[#E7EAF3] bg-white p-8 text-[14px] font-bold text-[#5A6480] xl:col-span-3">
                No live companies are available yet.
            </div>
        @endforelse
    </div>
</section>
@endsection
