@extends('layouts.frontend')

@section('title', 'Hall Details - EproExpo')

@section('content')
@php
    $title = str($hallSlug ?? 'hall-1')->replace('-', ' ')->title();
    $booths = [
        ['01', 'circle', 18, 28, 'reserved'],
        ['02', 'square', 78, 30, 'reserved'],
        ['03', 'square', 138, 30, 'reserved'],
        ['04', 'square', 198, 30, 'reserved'],
        ['05', 'square', 258, 30, 'reserved'],
        ['06', 'square', 318, 30, 'reserved'],
        ['07', 'square', 386, 30, 'available'],
        ['08', 'square', 446, 30, 'available'],
        ['09', 'square', 506, 30, 'available'],
        ['10', 'circle', 640, 28, 'reserved'],
        ['11', 'square', 18, 82, 'available'],
        ['12', 'square', 640, 82, 'available'],
        ['22', 'large', 120, 122, 'available'],
        ['17', 'large', 250, 122, 'warning'],
        ['16', 'large', 380, 122, 'available'],
        ['18', 'large', 510, 122, 'booked'],
        ['24', 'square', 78, 248, 'selected'],
        ['25', 'square', 138, 248, 'selected'],
        ['26', 'square', 198, 248, 'reserved'],
        ['27', 'square', 258, 248, 'reserved'],
        ['28', 'square', 318, 248, 'reserved'],
        ['29', 'square', 386, 248, 'reserved'],
        ['30', 'square', 446, 248, 'selected'],
        ['31', 'square', 506, 248, 'selected'],
        ['44', 'square', 78, 306, 'selected'],
        ['45', 'square', 138, 306, 'selected'],
        ['48', 'square', 318, 306, 'available'],
        ['49', 'square', 386, 306, 'available'],
        ['50', 'square', 446, 306, 'available'],
    ];
    $stateClasses = [
        'available' => 'bg-[#21B86E] text-white',
        'selected' => 'bg-[#4B18D9] text-white',
        'booked' => 'bg-[#777777] text-white',
        'reserved' => 'bg-[#D5D6D8] text-[#071044]',
        'warning' => 'bg-[#FF7B33] text-white',
    ];
@endphp

<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <div class="grid gap-6 rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] lg:grid-cols-[1fr_420px] lg:p-8">
            <div class="min-w-0">
                <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Hall details</p>
                <h1 class="mt-3 text-[38px] font-bold text-[#071044]">{{ $title }}</h1>
                <p class="mt-4 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">Browse companies, booth activity, product demos, media previews, and floor map highlights inside this hall.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-bold text-white">View Companies</a>
                    <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#071044]">Floor Map</a>
                </div>
            </div>
            <aside class="rounded-[16px] bg-[#FBFAFF] p-5">
                <h2 class="text-[18px] font-bold text-[#071044]">Floor map preview</h2>
                <div class="mt-4 overflow-hidden rounded-[14px] border border-[#E7EAF3] bg-white p-4">
                    <p class="text-center text-[12px] font-bold text-[#071044]">Main Aisle</p>
                    <div class="relative mt-3 h-[230px] rounded-md border border-[#BFC8DE] bg-white">
                        <div class="absolute left-[16%] top-[44px] h-[170px] w-px bg-[#E2E6F0]"></div>
                        <div class="absolute right-[18%] top-[44px] h-[170px] w-px bg-[#E2E6F0]"></div>

                        @foreach ([
                            ['01', 'circle', '5%', '25px', 'reserved', 'h-[46px] w-[46px] text-[14px]'],
                            ['02', 'square', '22%', '28px', 'reserved', 'h-[46px] w-[54px] text-[14px]'],
                            ['03', 'square', '39%', '28px', 'reserved', 'h-[46px] w-[54px] text-[14px]'],
                            ['04', 'square', '56%', '28px', 'reserved', 'h-[46px] w-[54px] text-[14px]'],
                            ['05', 'square', '73%', '28px', 'reserved', 'h-[46px] w-[54px] text-[14px]'],
                            ['06', 'square', '90%', '28px', 'reserved', 'h-[46px] w-[54px] text-[14px] -translate-x-full'],
                            ['11', 'square', '5%', '92px', 'available', 'h-[46px] w-[52px] text-[14px]'],
                            ['22', 'large', '34%', '138px', 'available', 'h-[72px] w-[92px] text-[22px]'],
                            ['17', 'large', '72%', '138px', 'warning', 'h-[72px] w-[92px] text-[22px] -translate-x-1/2'],
                        ] as [$label, $shape, $left, $top, $state, $sizeClass])
                            <a href="{{ route('exhibitions.booths.index', $slug) }}"
                                style="left: {{ $left }}; top: {{ $top }};"
                                class="absolute flex items-center justify-center rounded-lg font-bold shadow-sm transition hover:scale-105 {{ $sizeClass }} {{ $shape === 'circle' ? 'rounded-full border border-[#26335E] bg-white text-[#071044]' : $stateClasses[$state] }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-3 text-[12px] font-bold text-[#34405F]">
                    <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-[#21B86E]"></span>Available</span>
                    <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-[#4B18D9]"></span>Selected</span>
                    <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-[#777777]"></span>Booked</span>
                    <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-[#D5D6D8]"></span>Reserved</span>
                </div>
                <p class="mt-4 text-[13px] font-medium leading-6 text-[#5A6480]">Purple zones indicate high-activity booths and live demos.</p>
            </aside>
        </div>

        <div class="mt-7 grid gap-6 lg:grid-cols-[1fr_360px]">
            <div>
                <h2 class="text-[24px] font-bold text-[#071044]">Featured companies</h2>
                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    @foreach ([['technova-solutions', 'TechNova Solutions', 'AI automation, analytics and visitor intelligence.'], ['cloudbridge', 'CloudBridge', 'Cloud migration, SaaS operations and security tooling.'], ['greenloop-energy', 'GreenLoop Energy', 'Clean energy systems and sustainability dashboards.'], ['finlytics', 'Finlytics', 'Finance analytics and risk intelligence.']] as [$companySlug, $company, $copy])
                        <div class="rounded-[16px] border border-[#E7EAF3] bg-white p-5 shadow-[0_8px_22px_rgba(7,16,68,0.04)]">
                            <div class="flex items-start gap-4">
                                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#F4F0FF] text-[18px] font-bold text-[#5b2eff]">{{ substr($company, 0, 1) }}</div>
                                <div class="min-w-0">
                                    <h3 class="text-[18px] font-bold text-[#071044]">{{ $company }}</h3>
                                    <p class="mt-2 text-[13px] font-medium leading-5 text-[#5A6480]">{{ $copy }}</p>
                                </div>
                            </div>
                            <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="mt-4 inline-flex h-10 items-center justify-center rounded-lg bg-[#F4F0FF] px-4 text-[13px] font-bold text-[#5b2eff]">Visit Booth</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <aside class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                <h2 class="text-[20px] font-bold text-[#071044]">Hall activity</h2>
                <div class="mt-5 space-y-3">
                    @foreach ([['Live demo', 'AI product showcase at Booth A12'], ['Q&A', 'Cloud migration experts available'], ['Catalogue', '18 new catalogues uploaded'], ['Meetings', '32 meetings booked today']] as [$label, $copy])
                        <div class="rounded-[12px] bg-[#FBFAFF] p-4">
                            <p class="text-[13px] font-bold text-[#5b2eff]">{{ $label }}</p>
                            <p class="mt-1 text-[13px] font-medium leading-5 text-[#34405F]">{{ $copy }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
