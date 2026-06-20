@extends('layouts.frontend')

@section('title', 'Book Exhibition Halls & Booths')

@section('content')
<style>
    .pavilion-img {
        background:
            linear-gradient(180deg, rgba(15,23,42,.1), rgba(91,46,255,.18)),
            url("https://images.unsplash.com/photo-1595980542930-9eea66620834?auto=format&fit=crop&fm=jpg&ixlib=rb-4.1.0&q=80&w=1400");
        background-size: cover;
        background-position: center;
    }

    .pavilion-img-2 {
        background:
            linear-gradient(180deg, rgba(15,23,42,.08), rgba(91,46,255,.16)),
            url("https://images.unsplash.com/photo-1728919725572-64b812fb2b8d?auto=format&fit=crop&fm=jpg&ixlib=rb-4.1.0&q=80&w=1400");
        background-size: cover;
        background-position: center;
    }

    .booth-img {
        background:
            linear-gradient(180deg, rgba(15,23,42,.08), rgba(91,46,255,.14)),
            url("https://images.unsplash.com/photo-1761195696518-6384573549ea?auto=format&fit=crop&fm=jpg&ixlib=rb-4.1.0&q=80&w=1400");
        background-size: cover;
        background-position: center;
    }

    .custom-booth-img {
        background:
            linear-gradient(180deg, rgba(15,23,42,.10), rgba(91,46,255,.18)),
            url("https://images.unsplash.com/photo-1773405286291-d470befc09d6?auto=format&fit=crop&fm=jpg&ixlib=rb-4.1.0&q=80&w=1400");
        background-size: cover;
        background-position: center;
    }

    .floor-cell {
        width: 34px;
        height: 34px;
        border-radius: 3px;
        border: 1px solid #DDE2EE;
        background: #F2F4FA;
    }

    .floor-cell.selected {
        background: linear-gradient(135deg, #7047ff, #5b2eff);
        border-color: #5b2eff;
        color: white;
    }

    .floor-cell.booked { background: #C9CED8; }
    .floor-cell.reserved { background: #FFEBCB; }

    span.absolute.left-5.top-5 {
        left: 1rem !important;
        top: 1rem !important;
        background: #6D35FF !important;
        box-shadow: 0 5px 12px rgba(91, 46, 255, .32);
        font-size: 0 !important;
    }

    span.absolute.left-5.top-5::after {
        content: "\2713";
        font-size: 12px;
        font-weight: 900;
    }
</style>

@php
    $pavilions = [
        ['Innovation Pavilion', '4 Halls', '120+ Booths', 'High footfall, ideal for tech & innovation brands', 'images/exhibitions/pavilion-innovation-card.png', 'object-center', true],
        ['Business Pavilion', '3 Halls', '90+ Booths', 'Perfect for B2B meetings and networking', 'images/exhibitions/hero-pavilion-scene.png', 'object-[50%_48%]', false],
        ['Healthcare Pavilion', '3 Halls', '80+ Booths', 'Healthcare, pharma & medical devices', 'images/exhibitions/hero-pavilion-scene.png', 'object-[35%_48%]', false],
        ['Education Pavilion', '2 Halls', '60+ Booths', 'EdTech, training & academic solutions', 'images/exhibitions/hero-pavilion-scene.png', 'object-[62%_50%]', false],
        ['Sustainability Pavilion', '2 Halls', '50+ Booths', 'Green tech & sustainable future solutions', 'images/exhibitions/hero-pavilion-scene.png', 'object-[80%_48%]', false],
    ];
    $liveBooths = $liveBooths ?? collect();
@endphp

<main class="w-full overflow-x-hidden bg-white px-3 py-5 text-[#071044] sm:px-6 sm:py-6 lg:px-8">
    <section class="overflow-hidden rounded-[22px] border border-[#E7EAF3] bg-white shadow-[0_18px_45px_rgba(7,16,68,.08)]">
        <div class="grid grid-cols-1 lg:min-h-[430px] lg:grid-cols-[36%_64%]">
            <div class="relative z-10 flex flex-col justify-center bg-white px-5 py-8 sm:px-10 lg:px-11 lg:py-12 xl:px-12">
                <h1 class="max-w-[430px] text-[34px] font-extrabold leading-[1.08] tracking-[-1px] text-[#071044] min-[420px]:text-[38px] sm:text-[46px] lg:text-[48px] lg:tracking-[-1.3px] xl:text-[52px]">
                    Book <span class="text-[#5b2eff]">Exhibition</span><br>
                    Halls <span class="text-[#5b2eff]">&amp;</span> Booths
                </h1>

                <p class="mt-5 max-w-[430px] text-[15px] font-bold leading-[1.6] text-[#31385E] sm:mt-6 sm:text-[18px] lg:text-[17px] xl:text-[18px]">
                    Showcase your brand to the right audience<br class="hidden sm:block">
                    in the right virtual space.
                </p>

                <div class="mt-8 grid max-w-[470px] grid-cols-2 gap-x-3 gap-y-6 sm:grid-cols-4 sm:gap-x-0 sm:gap-y-8 lg:mt-11">
                    @foreach ([['Premium', 'Locations', 'pin'], ['Flexible', 'Spaces', 'booth'], ['Customizable', 'Booths', 'percent'], ['Global', 'Visibility', 'globe']] as [$line1, $line2, $icon])
                        <div class="flex min-h-[86px] flex-col items-center justify-start rounded-xl border border-[#EEF0F7] px-2 py-3 text-center sm:min-h-[92px] sm:rounded-none sm:border-0 sm:border-r sm:py-0 sm:last:border-r-0">
                            @if ($icon === 'pin')
                                <svg class="h-9 w-9 text-[#7B4DFF]" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 32s10-10.2 10-19A10 10 0 0 0 8 13c0 8.8 10 19 10 19Z"></path>
                                    <circle cx="18" cy="13" r="3.5"></circle>
                                </svg>
                            @elseif ($icon === 'booth')
                                <svg class="h-9 w-9 text-[#7B4DFF]" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="10" y="9" width="16" height="16" rx="2.5"></rect>
                                    <path d="M13 7v4M23 7v4M13 23v4M23 23v4M8 13h4M8 21h4M24 13h4M24 21h4"></path>
                                    <circle cx="18" cy="17" r="2"></circle>
                                </svg>
                            @elseif ($icon === 'percent')
                                <svg class="h-9 w-9 text-[#7B4DFF]" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 27 27 9"></path>
                                    <circle cx="12.5" cy="11.5" r="2.5"></circle>
                                    <circle cx="24.5" cy="24.5" r="2.5"></circle>
                                    <path d="M25 7h3v3M8 26h3v3"></path>
                                </svg>
                            @else
                                <svg class="h-9 w-9 text-[#7B4DFF]" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="18" cy="18" r="11"></circle>
                                    <path d="M7 18h22M18 7a17 17 0 0 1 0 22M18 7a17 17 0 0 0 0 22"></path>
                                </svg>
                            @endif
                            <p class="mt-5 text-[11px] font-extrabold leading-[1.35] text-[#071044] sm:text-[12px] lg:text-[11px] xl:text-[12px]">{{ $line1 }}<br>{{ $line2 }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative overflow-visible bg-white pb-6 lg:min-h-[430px] lg:overflow-hidden lg:pb-0">
                <div class="absolute inset-y-0 left-0 z-10 hidden w-[26%] bg-gradient-to-r from-white via-white/70 to-white/0 lg:block"></div>
                <img
                    src="{{ asset('images/exhibitions/hero-pavilion-scene.png') }}"
                    alt="Innovation Pavilion with exhibition halls"
                    class="h-[230px] w-full object-cover object-center sm:h-[320px] md:h-[360px] lg:h-full lg:min-h-[430px]"
                >

                <aside class="relative z-20 mx-auto -mt-8 w-[calc(100%-2rem)] max-w-[420px] rounded-[18px] bg-white p-5 shadow-[0_18px_38px_rgba(7,16,68,.18)] ring-1 ring-[#E7EAF3] sm:-mt-12 sm:w-[min(420px,calc(100%-3rem))] sm:p-6 lg:absolute lg:right-7 lg:top-1/2 lg:mx-0 lg:-mt-0 lg:w-[318px] lg:-translate-y-1/2 lg:p-5 xl:right-10">
                    <div class="flex items-center justify-between gap-4 border-b border-[#EEF0F7] pb-3">
                        <h2 class="text-[16px] font-extrabold text-[#071044]">Your Booking Summary</h2>
                        <span class="text-[24px] leading-none text-[#78809A]">&times;</span>
                    </div>

                    <div class="mt-5 space-y-5">
                        @foreach ([['Pavilion', 'Innovation Pavilion', 'pavilion'], ['Hall', 'Hall 1 - Tech & Innovation', 'hall'], ['Booth', '3m x 3m (9 sqm)', 'booth'], ['Duration', 'May 18 - May 21, 2024', 'duration'], ['Total Amount', '₹499', 'amount']] as [$label, $value, $icon])
                            <div class="grid grid-cols-[38px_minmax(0,1fr)] items-start gap-3 lg:grid-cols-[34px_minmax(0,1fr)]">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center text-[#7B4DFF]">
                                    @if ($icon === 'pavilion')
                                        <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="5" y="7" width="14" height="13" rx="2"></rect>
                                            <path d="M8 5v4M16 5v4M5 11h14M8 16h2M12 16h4"></path>
                                            <path d="M10 3h4"></path>
                                        </svg>
                                    @elseif ($icon === 'hall')
                                        <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8.8 14.8 7 16.6a3.4 3.4 0 0 1-4.8-4.8l3.3-3.3a3.4 3.4 0 0 1 4.8 0"></path>
                                            <path d="M15.2 9.2 17 7.4a3.4 3.4 0 0 1 4.8 4.8l-3.3 3.3a3.4 3.4 0 0 1-4.8 0"></path>
                                            <path d="m8.5 15.5 7-7"></path>
                                        </svg>
                                    @elseif ($icon === 'booth')
                                        <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="5" y="5" width="14" height="14" rx="3"></rect>
                                            <path d="M9 19v-5a3 3 0 0 1 6 0v5"></path>
                                            <path d="M8 10h2M14 10h2"></path>
                                            <path d="M7 5 12 2l5 3"></path>
                                        </svg>
                                    @elseif ($icon === 'duration')
                                        <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="4" y="6" width="16" height="14" rx="2.5"></rect>
                                            <path d="M8 4v4M16 4v4M4 11h16"></path>
                                            <path d="M9 15h6"></path>
                                        </svg>
                                    @else
                                        <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="4" y="7" width="16" height="13" rx="3"></rect>
                                            <path d="M8 7a4 4 0 0 1 8 0"></path>
                                            <circle cx="12" cy="13.5" r="2.5"></circle>
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-[12px] font-extrabold leading-4 text-[#071044]">{{ $label }}</p>
                                    <p class="mt-1 text-[12px] font-bold leading-4 text-[#343B62]">{{ $value }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('company.home') }}" class="mt-7 flex h-[48px] w-full items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-extrabold text-white shadow-[0_9px_20px_rgba(91,46,255,0.25)]">
                        Start Exhibition Flow
                    </a>
                </aside>
            </div>
        </div>
    </section>

    @if ($liveBooths->isNotEmpty())
        <section class="mt-8 rounded-[22px] border border-[#E7EAF3] bg-white p-4 shadow-[0_10px_28px_rgba(7,16,68,.06)] sm:p-6 lg:p-7">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="text-[12px] font-extrabold uppercase tracking-[0.16em] text-[#6D35FF]">Live exhibitor booths</span>
                    <h2 class="mt-2 text-[24px] font-extrabold leading-tight tracking-[-0.04em] text-[#071044] sm:text-[32px]">Published booths visitors can explore now</h2>
                </div>
                <a href="{{ route('exhibitions.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8DCEB] px-5 text-[13px] font-extrabold text-[#071044] hover:bg-[#F8F7FF]">Browse exhibitions</a>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($liveBooths as $booking)
                    @php
                        $companyName = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;
                        $companySlug = \Illuminate\Support\Str::slug($companyName);
                        $exhibitionSlug = $booking->exhibition?->slug;
                        $logo = $booking->boothProfile?->company_logo ? asset('storage/' . $booking->boothProfile->company_logo) : asset('images/exhibitions/hero-pavilion-scene.png');
                    @endphp
                    <article class="overflow-hidden rounded-[16px] border border-[#E7EAF3] bg-[#FBFCFF] shadow-[0_8px_22px_rgba(7,16,68,.045)]">
                        <div class="h-[150px] bg-[#071044]">
                            <img src="{{ $logo }}" alt="{{ $companyName }}" class="h-full w-full object-cover">
                        </div>
                        <div class="p-5">
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full bg-[#E9FFF2] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.08em] text-[#0A7A58]">Live</span>
                                @if ($booking->exhibition?->title)
                                    <span class="rounded-full bg-[#F4F0FF] px-3 py-1 text-[10px] font-extrabold text-[#5b2eff]">{{ $booking->exhibition->title }}</span>
                                @endif
                            </div>
                            <h3 class="mt-4 text-[20px] font-extrabold leading-tight text-[#071044]">{{ $companyName }}</h3>
                            <p class="mt-2 text-[13px] font-semibold leading-5 text-[#5A6480]">
                                {{ $booking->hall?->title ?: 'Hall' }}@if($booking->booth?->booth_number) / Booth {{ $booking->booth->booth_number }}@endif
                            </p>
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <div class="rounded-xl bg-white p-3 text-center">
                                    <p class="text-[16px] font-extrabold text-[#071044]">{{ $booking->published_products_count ?? 0 }}</p>
                                    <p class="text-[10px] font-bold uppercase text-[#6A7288]">Products</p>
                                </div>
                                <div class="rounded-xl bg-white p-3 text-center">
                                    <p class="text-[16px] font-extrabold text-[#071044]">{{ $booking->public_catalogues_count ?? 0 }}</p>
                                    <p class="text-[10px] font-bold uppercase text-[#6A7288]">Catalogues</p>
                                </div>
                            </div>
                            @if ($exhibitionSlug && $companySlug)
                                <a href="{{ route('exhibitions.booths.show', [$exhibitionSlug, $companySlug]) }}" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[13px] font-extrabold text-white">Visit Booth</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-8 rounded-[22px] border border-[#EEF0F7] bg-white px-4 py-5 shadow-[0_10px_28px_rgba(7,16,68,.04)] sm:px-6 sm:py-6 lg:px-7">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
            <h2 class="text-[18px] font-extrabold text-[#071044]">1. Choose Pavilion</h2>
            <a href="{{ route('company.booth-booking.pavilions') }}" class="inline-flex items-center gap-2 text-[14px] font-extrabold text-[#5b2eff]">View All Pavilions <span class="text-[18px] leading-none">&rarr;</span></a>
        </div>

        <div class="grid grid-cols-1 items-stretch gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-[repeat(5,minmax(0,1fr))_40px]">
            @foreach ($pavilions as [$title, $halls, $booths, $desc, $image, $position, $active])
                <a href="{{ route('company.booth-booking.halls') }}" class="relative block overflow-hidden rounded-xl bg-white shadow-[0_8px_22px_rgba(7,16,68,.045)] transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(7,16,68,.08)] {{ $active ? 'border-2 border-[#8B62FF]' : 'border border-[#EEF0F7]' }}">
                    @if ($active)
                        <span class="absolute left-5 top-5 z-10 flex h-6 w-6 items-center justify-center rounded-full bg-[#5b2eff] text-xs text-white">✓</span>
                    @endif
                    <div class="relative h-[118px] overflow-hidden rounded-t-[10px]">
                        <img src="{{ asset($image) }}" alt="{{ $title }}" class="h-full w-full object-cover {{ $position }}">
                    </div>
                    <div class="min-h-[134px] px-4 pb-4 pt-4">
                        <h3 class="text-[14px] font-extrabold leading-5 text-[#071044]">{{ $title }}</h3>
                        <p class="mt-3 text-[12px] font-bold leading-5 text-[#3F4568]">{{ $halls }} <span class="mx-1.5 text-[#9AA1B8]">&bull;</span> {{ $booths }}</p>
                        <p class="mt-2 text-[13px] font-semibold leading-6 text-[#343B62]">{{ $desc }}</p>
                    </div>
                </a>
            @endforeach

            <div class="hidden items-center justify-center lg:flex">
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#EEF0F7] bg-white text-[24px] font-bold leading-none text-[#071044] shadow-[0_7px_20px_rgba(7,16,68,.06)]">
                    &rsaquo;
                </button>
            </div>
        </div>
    </section>

    <section class="mt-8 rounded-[22px] border border-[#EEF0F7] bg-white p-4 shadow-[0_10px_28px_rgba(7,16,68,.04)] sm:p-6 lg:p-8">
        <div class="mb-7">
            <div>
                <span class="text-[12px] font-extrabold uppercase tracking-[0.16em] text-[#6D35FF]">Exhibition flow overview</span>
                <h2 class="mt-3 max-w-[760px] text-[26px] font-extrabold leading-tight tracking-[-0.5px] text-[#071044] sm:text-[34px] sm:tracking-[-0.8px]">Show the complete journey without turning this into a booking screen.</h2>
            </div>
        </div>

        <div class="overflow-hidden rounded-[20px] border border-[#EEF0F7]">
            <div class="grid grid-cols-1 lg:grid-cols-[230px_1fr_300px]">
                <aside class="bg-[#FBFCFF] p-5 lg:border-r lg:border-[#EEF0F7]">
                    <h3 class="text-[16px] font-extrabold text-[#071044]">Core Flow</h3>
                    <div class="mt-5 space-y-3">
                        @foreach ([['01', 'Dashboard'], ['02', 'Choose Pavilion'], ['03', 'Explore Halls'], ['04', 'Book Booths'], ['05', 'Manage Leads']] as [$step, $label])
                            <div class="flex items-center gap-3 rounded-xl border border-[#EEF0F7] bg-white px-4 py-3">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[11px] font-extrabold text-[#6D35FF]">{{ $step }}</span>
                                <span class="text-[13px] font-extrabold text-[#071044]">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </aside>

                <div class="p-5">
                    <div class="mb-5 grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 md:grid-cols-4 md:gap-4">
                        @foreach ([['Hall Categories', '4+'], ['Booth Zones', '60+'], ['Engagement Tools', '12'], ['Reports', 'Live']] as [$label, $value])
                            <div class="rounded-xl border border-[#EEF0F7] bg-white p-4">
                                <p class="text-[11px] font-bold text-[#5A6480]">{{ $label }}</p>
                                <p class="mt-1 text-[18px] font-extrabold text-[#071044]">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                    <img src="{{ asset('images/exhibitions/info-hall-floorplan.png') }}" alt="Hall and floor plan overview" class="h-[210px] w-full rounded-[16px] object-cover sm:h-[285px]">
                    <div class="mt-5 flex flex-wrap gap-3 text-[12px] font-bold text-[#5A6480]">
                        <span class="flex items-center gap-2"><i class="h-3.5 w-3.5 rounded-sm bg-[#F2F4FA] ring-1 ring-[#DDE2EE]"></i> Hall map</span>
                        <span class="flex items-center gap-2"><i class="h-3.5 w-3.5 rounded-sm bg-[#5b2eff]"></i> Featured zones</span>
                        <span class="flex items-center gap-2"><i class="h-3.5 w-3.5 rounded-sm bg-[#C9CED8]"></i> Booked spaces</span>
                    </div>
                </div>

                <aside class="border-t border-[#EEF0F7] bg-[#FBFCFF] p-5 lg:border-l lg:border-t-0">
                    <img src="{{ asset('images/exhibitions/info-custom-booth.png') }}" alt="Custom booth overview" class="h-[170px] w-full rounded-[16px] object-cover">
                    <h3 class="mt-5 text-[18px] font-extrabold text-[#071044]">Booth Experience</h3>
                    <p class="mt-3 text-[13px] font-semibold leading-6 text-[#3F4568]">Explain how exhibitors can add branding, products, videos, documents, meetings, and lead capture tools.</p>
                    <div class="mt-5 grid gap-2">
                        @foreach (['Brand setup', 'Product showcase', 'Meeting tools', 'Lead capture'] as $item)
                            <div class="flex items-center gap-3 rounded-lg bg-white px-3 py-2 text-[12px] font-extrabold text-[#071044] ring-1 ring-[#EEF0F7]">
                                <span class="h-2 w-2 rounded-full bg-[#6D35FF]"></span>
                                {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[20px] border border-[#E7EAF3] bg-[#071044] shadow-[0_14px_34px_rgba(7,16,68,.12)]">
            <div class="grid grid-cols-1 lg:grid-cols-[1.05fr_1fr_1fr]">
                @foreach ([
                    ['01', 'Choose Pavilion', 'Start with pavilions, then continue through hall, booth, slot, and payment.', route('company.booth-booking.pavilions'), 'Explore pavilions', 'images/exhibitions/hero-book-exhibition.png', 'object-[55%_50%]'],
                    ['02', 'Choose Pavilion', 'Start with the right category, traffic level, and audience fit.', route('company.booth-booking.pavilions'), 'Explore pavilions', 'images/exhibitions/pavilion-innovation-card.png', 'object-center'],
                    ['03', 'Pick Booth Space', 'Compare hall layout, booth sizes, duration, and available slots.', route('company.booth-booking.sizes'), 'Select booth', 'images/exhibitions/info-custom-booth.png', 'object-center'],
                ] as [$step, $title, $desc, $href, $label, $image, $position])
                    <article class="relative min-h-[310px] overflow-hidden border-b border-white/10 bg-[#071044] p-5 text-white last:border-b-0 sm:min-h-[244px] sm:p-6 lg:border-b-0 lg:border-r lg:last:border-r-0">
                        <div class="absolute inset-x-5 bottom-5 h-[42%] overflow-hidden rounded-[18px] border border-white/15 bg-white/5 shadow-[0_18px_34px_rgba(0,0,0,.24)] sm:inset-y-5 sm:left-auto sm:h-auto sm:w-[48%]">
                            <img src="{{ asset($image) }}" alt="{{ $title }}" class="h-full w-full object-cover {{ $position }} opacity-90">
                            <span class="absolute inset-0 bg-[#071044]/12"></span>
                            <span class="absolute inset-0 bg-gradient-to-l from-transparent via-[#071044]/5 to-[#071044]/55"></span>
                            <span class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-[#071044]/65 to-transparent"></span>
                        </div>
                        <span class="absolute inset-0 bg-gradient-to-b from-[#071044] via-[#071044]/92 to-[#071044]/30 sm:bg-gradient-to-r sm:from-[#071044] sm:via-[#071044]/88 sm:to-transparent"></span>
                        <span class="absolute inset-0 bg-gradient-to-t from-[#071044]/72 via-transparent to-[#071044]/10"></span>

                        <div class="relative z-10 flex items-start justify-between gap-5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[13px] font-extrabold text-[#5b2eff] shadow-[0_10px_20px_rgba(0,0,0,.16)]">{{ $step }}</span>
                            <span class="h-2 w-2 rounded-full bg-[#8B62FF] shadow-[0_0_18px_rgba(139,98,255,.9)]"></span>
                        </div>

                        <div class="relative z-10 max-w-full sm:max-w-[62%]">
                            <h3 class="mt-6 text-[20px] font-extrabold tracking-[-0.02em]">{{ $title }}</h3>
                            <p class="mt-3 text-[13px] font-semibold leading-6 text-white/78">{{ $desc }}</p>
                        </div>

                        <a href="{{ $href }}" class="relative z-10 mt-6 inline-flex h-10 items-center justify-center rounded-lg bg-white/10 px-4 text-[13px] font-extrabold text-white ring-1 ring-white/18 transition hover:bg-white hover:text-[#5b2eff]">
                            {{ $label }}
                            <span class="ml-2 text-[16px] leading-none">-&gt;</span>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hidden mt-8 overflow-hidden rounded-[22px] border border-[#E7EAF3] bg-white shadow-[0_12px_30px_rgba(7,16,68,.055)]">
        <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr_310px]">
            <aside class="border-b border-[#E7EAF3] p-6 lg:border-b-0 lg:border-r">
                <h2 class="mb-6 text-[18px] font-bold">2. Select Hall</h2>
                <div class="space-y-4">
                    @foreach ([['Hall 1', 'Tech & Innovation', true], ['Hall 2', 'AI & Robotics', false], ['Hall 3', 'Digital Solutions', false], ['Hall 4', 'Future Mobility', false]] as [$hall, $subtitle, $active])
                        <button class="w-full rounded-lg p-4 text-left {{ $active ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white shadow-lg' : 'border border-[#E7EAF3] bg-white' }}">
                            <p class="text-[14px] font-bold">{{ $hall }}</p>
                            <p class="mt-1 text-[11px] {{ $active ? 'opacity-90' : 'text-[#5A6480]' }}">{{ $subtitle }}</p>
                        </button>
                    @endforeach
                </div>
            </aside>

            <div class="p-6">
                <h3 class="text-[16px] font-bold">Hall 1 - Tech & Innovation</h3>

                <div class="mt-6 grid grid-cols-2 gap-5 xl:grid-cols-4">
                    @foreach ([['Booths Available', '45'], ['Total Booths', '60'], ['Hall Size', '10,000 sqm'], ['Footfall', 'High']] as [$label, $value])
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#8B72FF]">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7">
                                    <rect x="3" y="5" width="14" height="10" rx="2"></rect>
                                    <path d="M7 3v14M13 3v14"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-[#5A6480]">{{ $label }}</p>
                                <p class="text-[14px] font-bold">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 overflow-x-auto rounded-xl border border-[#E7EAF3] bg-[#F8FAFF] p-5">
                    <div class="relative h-[190px] min-w-[640px]">
                        @foreach ([0, 105, 210, 320, 430, 525] as $left)
                            <div class="absolute top-0 grid grid-cols-3 gap-2" style="left: {{ $left }}px">
                                @for ($i = 0; $i < 6; $i++)
                                    <div class="floor-cell {{ $left === 210 && $i === 4 ? 'selected flex items-center justify-center text-xs font-bold' : '' }} {{ in_array($i, [2, 5]) && $left !== 210 ? 'booked' : '' }}">{{ $left === 210 && $i === 4 ? 'A' : '' }}</div>
                                @endfor
                            </div>
                        @endforeach

                        @foreach ([0, 145, 340, 540] as $left)
                            <div class="absolute bottom-0 grid grid-cols-4 gap-2" style="left: {{ $left }}px">
                                @for ($i = 0; $i < 8; $i++)
                                    <div class="floor-cell {{ $i === 5 ? 'booked' : '' }}"></div>
                                @endfor
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap items-center gap-9 text-[12px] font-semibold text-[#5A6480]">
                    <span class="flex items-center gap-2"><i class="h-4 w-4 rounded-sm border border-[#DDE2EE] bg-[#F2F4FA]"></i> Available</span>
                    <span class="flex items-center gap-2"><i class="h-4 w-4 rounded-sm bg-[#5b2eff]"></i> Selected</span>
                    <span class="flex items-center gap-2"><i class="h-4 w-4 rounded-sm bg-[#C9CED8]"></i> Booked</span>
                    <span class="flex items-center gap-2"><i class="h-4 w-4 rounded-sm bg-[#FFEBCB]"></i> Reserved</span>
                </div>
            </div>

            <aside class="border-t border-[#E7EAF3] p-6 lg:border-l lg:border-t-0">
                <div class="booth-img h-[175px] rounded-xl"></div>
                <div class="mt-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-[18px] font-bold">Booth 12A</h3>
                        <span class="rounded-full bg-green-50 px-3 py-1 text-[10px] font-bold text-green-600">Available</span>
                    </div>
                    <p class="mt-3 text-[12px] font-semibold text-[#5A6480]">Size: 3m x 3m (9 sqm)</p>
                    <p class="mt-2 text-[12px] font-semibold text-[#5A6480]">Location: Hall 1, Row B</p>
                    <p class="mt-2 text-[12px] font-bold">Price: ₹499</p>
                    <a href="{{ route('company.booth-booking.summary') }}" class="mt-5 inline-block text-[13px] font-bold text-[#5b2eff]">View Booth Details</a>
                    <a href="{{ route('company.booth-booking.slots') }}" class="mt-5 flex h-[42px] w-full items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[13px] font-bold text-white">
                        Select Booth
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <section class="hidden mt-8 grid-cols-1 gap-8 xl:grid-cols-[1fr_320px]">
        <div class="space-y-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1fr_300px]">
                <div class="rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_12px_30px_rgba(7,16,68,.055)]">
                    <h2 class="mb-6 text-[18px] font-bold">3. Choose Booth Size</h2>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-6">
                        @foreach ([['3m x 3m', '(9 sqm)', '₹499', true], ['3m x 6m', '(18 sqm)', '₹899', false], ['6m x 6m', '(36 sqm)', '₹1,499', false], ['6m x 9m', '(54 sqm)', '₹1,999', false], ['9m x 9m', '(81 sqm)', '₹2,499', false], ['Custom Size', 'Tailored to your needs', 'Contact Us', false]] as [$size, $area, $price, $active])
                            <button class="min-h-[150px] rounded-xl p-4 text-center {{ $active ? 'border-2 border-[#5b2eff]' : 'border border-[#E7EAF3]' }}">
                                <p class="text-[13px] font-bold">{{ $size }}</p>
                                <p class="mt-1 text-[11px] font-semibold text-[#5A6480]">{{ $area }}</p>
                                <div class="mx-auto mt-5 grid w-[52px] grid-cols-2 gap-1">
                                    @for ($i = 0; $i < 4; $i++)
                                        <span class="h-5 rounded-sm bg-[#9B72FF]"></span>
                                    @endfor
                                </div>
                                <p class="mt-5 text-[14px] font-bold">{{ $price }}</p>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_12px_30px_rgba(7,16,68,.055)]">
                    <h2 class="text-[18px] font-bold">4. Select Duration</h2>
                    <button class="mt-7 flex h-[52px] w-full items-center justify-between rounded-xl border border-[#E7EAF3] px-4 text-[12px] font-bold">
                        <span>May 18, 2024 - May 21, 2024</span>
                        <span class="text-[22px] text-[#8B72FF]">□</span>
                    </button>
                    <p class="mt-6 text-[13px] font-bold">Total Duration: 4 Days</p>
                    <p class="mt-2 text-[12px] font-medium leading-5 text-[#5A6480]">You can extend or modify duration later.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div class="rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_12px_30px_rgba(7,16,68,.055)]">
                    <h2 class="text-[18px] font-bold">5. Customize Your Booth</h2>
                    <p class="mt-3 text-[13px] font-medium leading-5 text-[#34405F]">Add branding, banners, products, videos and more to make your booth stand out.</p>
                    <div class="mt-5 grid grid-cols-1 items-center gap-6 md:grid-cols-[190px_1fr]">
                        <div>
                            <ul class="space-y-2 text-[12px] font-semibold text-[#34405F]">
                                <li>✓ Logo & Branding</li>
                                <li>✓ Banners & Posters</li>
                                <li>✓ Product Showcase</li>
                                <li>✓ Videos & Documents</li>
                                <li>✓ Live Chat & Meetings</li>
                                <li>✓ Lead Capture Forms</li>
                            </ul>
                            <a href="{{ route('company.booth-booking.customize') }}" class="mt-5 inline-flex h-10 items-center rounded-lg border border-[#E7EAF3] px-5 text-[12px] font-bold text-[#5b2eff]">Customize Booth -&gt;</a>
                        </div>
                        <div class="custom-booth-img relative h-[190px] overflow-hidden rounded-xl">
                            <div class="absolute left-1/2 top-5 -translate-x-1/2 rounded-md bg-[#111827] px-8 py-2 text-[17px] font-bold text-white">Your Brand</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_12px_30px_rgba(7,16,68,.055)]">
                    <h2 class="text-[18px] font-bold">6. Add Services <span class="font-semibold">(Optional)</span></h2>
                    <p class="mt-2 text-[12px] font-medium text-[#5A6480]">Enhance your presence with premium services.</p>
                    <div class="mt-6 space-y-5">
                        @foreach ([['Featured Listing', '₹99'], ['Email Campaign', '₹149'], ['Push Notifications', '₹99'], ['Dedicated Meeting Room', '₹199'], ['Lead Scan Devices', '₹149']] as [$service, $price])
                            <label class="flex items-center justify-between text-[13px] font-bold">
                                <span class="flex items-center gap-3"><input type="checkbox" class="h-4 w-4 accent-[#5b2eff]">{{ $service }}</span>
                                <span>{{ $price }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <aside class="h-fit rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_12px_30px_rgba(7,16,68,.055)]">
            <h2 class="text-[20px] font-bold tracking-[-0.2px]">Booking Summary</h2>
            <div class="mt-6 space-y-4 text-[12px]">
                @foreach ([['Pavilion', 'Innovation Pavilion'], ['Hall', 'Hall 1 - Tech & Innovation'], ['Booth', 'Booth 12A (3m x 3m)'], ['Duration', 'May 18 - May 21, 2024 (4 Days)']] as [$label, $value])
                    <div class="flex justify-between gap-4">
                        <span class="font-bold text-[#5A6480]">{{ $label }}</span>
                        <span class="text-right font-semibold leading-5">{{ $value }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-7 space-y-3.5 border-t border-[#E7EAF3] pt-5 text-[12px]">
                @foreach ([['Booth Price', '₹499'], ['Platform Fee', '₹50'], ['Tax (10%)', '₹54.90']] as [$label, $value])
                    <div class="flex justify-between"><span class="font-bold">{{ $label }}</span><span class="font-semibold">{{ $value }}</span></div>
                @endforeach
            </div>

            <div class="mt-7 flex items-center justify-between border-t border-[#E7EAF3] pt-5">
                <span class="text-[15px] font-bold">Total Amount</span>
                <span class="text-[28px] font-bold tracking-[-0.6px]">₹603.90</span>
            </div>

            <a href="{{ route('company.booth-booking.summary') }}" class="mt-6 flex h-[48px] w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[13px] font-bold text-white shadow-lg shadow-purple-200">
                Continue to Checkout
            </a>
        </aside>
    </section>

    <section class="mt-8 overflow-hidden rounded-[24px] border border-[#E7EAF3] bg-gradient-to-br from-white via-[#FBFCFF] to-[#F6F2FF] p-4 shadow-[0_16px_38px_rgba(7,16,68,.07)] sm:p-5 lg:p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Global Reach', 'Connect with attendees worldwide', 'from-[#5b2eff] to-[#246BFF]', 'M10 17s6-5.4 6-10a6 6 0 1 0-12 0c0 4.6 6 10 6 10Zm0-4a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z'],
                ['Real-time Analytics', 'Track visitors and engagement', 'from-[#00A7A7] to-[#35C88D]', 'M4 15V9m4 6V5m4 10v-4m4 4V7'],
                ['Secure & Reliable', 'Enterprise-grade infrastructure', 'from-[#FF8A2A] to-[#E84D7A]', 'M10 3 4.8 5v4.8c0 3 2.1 5.8 5.2 6.2 3.1-.4 5.2-3.2 5.2-6.2V5L10 3Z'],
                ['24/7 Support', 'We are here to help you always', 'from-[#7C3AED] to-[#C135FF]', 'M4 11a6 6 0 1 1 12 0v3a2 2 0 0 1-2 2h-2m-8-5h2v4H4a2 2 0 0 1-2-2v0a2 2 0 0 1 2-2Zm12 0h2a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-2v-4Z'],
            ] as [$title, $desc, $gradient, $path])
                <article class="group relative overflow-hidden rounded-[18px] border border-white bg-white p-5 shadow-[0_10px_24px_rgba(7,16,68,.055)] transition hover:-translate-y-1 hover:shadow-[0_18px_34px_rgba(7,16,68,.10)]">
                    <span class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-[#F4F0FF] transition group-hover:scale-125"></span>
                    <div class="relative z-10 flex h-[52px] w-[52px] items-center justify-center rounded-[15px] bg-gradient-to-br {{ $gradient }} text-white shadow-[0_10px_22px_rgba(91,46,255,.20)]">
                        <svg class="h-7 w-7" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="{{ $path }}"></path>
                        </svg>
                    </div>
                    <h4 class="relative z-10 mt-5 text-[16px] font-extrabold tracking-[-0.02em] text-[#071044]">{{ $title }}</h4>
                    <p class="relative z-10 mt-2 text-[13px] font-semibold leading-6 text-[#5A6480]">{{ $desc }}</p>
                    <span class="relative z-10 mt-5 block h-1 w-12 rounded-full bg-gradient-to-r {{ $gradient }}"></span>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mb-8 mt-8 overflow-hidden rounded-[24px] border border-[#E7EAF3] bg-gradient-to-br from-[#FBFCFF] via-white to-[#F6F2FF] p-4 shadow-[0_16px_38px_rgba(7,16,68,.07)] sm:p-5 lg:p-6">
        <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <span class="inline-flex rounded-full bg-[#F4F0FF] px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#6D35FF]">Trusted network</span>
                <h3 class="mt-4 text-[24px] font-extrabold leading-tight tracking-[-0.04em] text-[#071044] sm:text-[28px]">Trusted by leading brands</h3>
                <p class="mt-3 max-w-[560px] text-[14px] font-semibold leading-6 text-[#5A6480]">Enterprise-ready exhibition and event workflows for teams that need dependable booking, engagement, and management tools.</p>
            </div>

            <div class="grid grid-cols-1 gap-3 text-center min-[420px]:grid-cols-3">
                @foreach ([['120+', 'Booths'], ['40+', 'Brands'], ['24/7', 'Support']] as [$value, $label])
                    <div class="rounded-[14px] border border-[#E7EAF3] bg-white px-4 py-4 shadow-[0_8px_18px_rgba(7,16,68,.045)] sm:px-5">
                        <p class="text-[22px] font-extrabold tracking-[-0.04em] text-[#5b2eff]">{{ $value }}</p>
                        <p class="mt-1 text-[11px] font-extrabold uppercase tracking-[0.08em] text-[#6A7288]">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 sm:grid-cols-4 lg:grid-cols-8">
            @foreach ([
                ['Microsoft', '#63708C'],
                ['IBM', '#51607B'],
                ['SIEMENS', '#068C87'],
                ['P&G', '#0B3B8A'],
                ['Deloitte.', '#071044'],
                ['Infosys', '#67738E'],
                ['BOSCH', '#727A8D'],
                ['SAP', '#53617B'],
            ] as [$brand, $color])
                <div class="group flex h-[76px] items-center justify-center rounded-[16px] border border-[#E7EAF3] bg-white px-4 text-center text-[18px] font-extrabold tracking-[-0.02em] shadow-[0_8px_18px_rgba(7,16,68,.04)] transition hover:-translate-y-1 hover:border-[#CFC7F1] hover:shadow-[0_14px_26px_rgba(7,16,68,.08)] sm:h-[92px] sm:text-[19px]" style="color: {{ $color }}">
                    <span class="transition group-hover:scale-105">
                    {{ $brand }}
                    </span>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection
