@extends('layouts.frontend')

@section('title', 'Visitor Halls - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
    $halls = [
        ['image' => 'innovation-pavilion.png', 'title' => 'Hall A - Technology & AI', 'companies' => '86 Companies', 'booths' => '120 Booths', 'sessions' => '18 Sessions', 'footfall' => 'High activity', 'code' => 'HALL-A', 'href' => route('exhibitions.visitor.floor-map', $slug)],
        ['image' => 'business-pavilion.png', 'title' => 'Hall B - Cloud & Business', 'companies' => '72 Companies', 'booths' => '96 Booths', 'sessions' => '12 Sessions', 'footfall' => 'Meeting zone', 'code' => 'HALL-B', 'href' => route('exhibitions.visitor.floor-map', $slug)],
        ['image' => 'healthcare-pavilion.png', 'title' => 'Hall C - Healthcare', 'companies' => '64 Companies', 'booths' => '88 Booths', 'sessions' => '10 Sessions', 'footfall' => 'Demo zone', 'code' => 'HALL-C', 'href' => route('exhibitions.visitor.floor-map', $slug)],
        ['image' => 'sustainability-pavilion.png', 'title' => 'Hall D - Sustainability', 'companies' => '54 Companies', 'booths' => '74 Booths', 'sessions' => '9 Sessions', 'footfall' => 'Launch zone', 'code' => 'HALL-D', 'href' => route('exhibitions.visitor.floor-map', $slug)],
    ];
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7 rounded-xl border border-borderColor bg-white p-6 shadow-sm lg:p-8">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
            <div>
                <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor navigation</p>
                <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">Floor Map / Halls / Booths</h1>
                <p class="mt-3 max-w-[820px] text-[16px] font-medium leading-7 text-[#5A6480]">Explore halls as a visitor. Open the floor map, find company booths, check sessions, and continue to booth pages for meetings, chat, brochures and demos.</p>
            </div>
            <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex h-12 items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[14px] font-semibold text-white">
                <i class="fa-regular fa-map"></i>
                Open Floor Map
            </a>
        </div>
    </div>

    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="overflow-hidden rounded-lg border border-borderColor bg-white shadow-sm">
            <div class="flex min-w-max items-center overflow-x-auto">
                @foreach (['All Halls', 'High Activity', 'Live Demos', 'Meeting Zones'] as $index => $tab)
                    <button type="button" class="h-[56px] {{ $index === 0 ? 'border-b-2 border-purple text-purple' : 'text-[#34405F]' }} px-8 text-[15px] font-semibold">{{ $tab }}</button>
                @endforeach
            </div>
        </div>

        <label class="relative block w-full sm:w-[420px]">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
            <input type="text" placeholder="Search hall, company, booth number..." class="h-[52px] w-full rounded-md border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8] focus:border-purple">
        </label>
    </div>

    <div class="space-y-5">
        @foreach ($halls as $hall)
            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-5">
                <div class="grid grid-cols-1 gap-5 xl:grid-cols-[170px_minmax(0,1fr)_310px] xl:items-center">
                    <img src="{{ asset('assets/images/pavilions/' . $hall['image']) }}" alt="{{ $hall['title'] }}" class="h-[132px] w-full rounded-md object-cover xl:w-[150px]">

                    <div class="min-w-0">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h2 class="text-[20px] font-semibold tracking-[-0.3px] text-navy">{{ $hall['title'] }}</h2>
                                <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $hall['footfall'] }}</p>
                            </div>
                            <span class="w-fit rounded-md bg-[#EAF9F0] px-3 py-1.5 text-[13px] font-semibold text-[#16A34A]">Open for visitors</span>
                        </div>

                        <div class="grid gap-3 text-[14px] font-medium text-[#34405F] sm:grid-cols-3">
                            <p class="flex items-center gap-3"><i class="fa-solid fa-building w-4 text-purple"></i>{{ $hall['companies'] }}</p>
                            <p class="flex items-center gap-3"><i class="fa-solid fa-store w-4 text-purple"></i>{{ $hall['booths'] }}</p>
                            <p class="flex items-center gap-3"><i class="fa-regular fa-circle-play w-4 text-purple"></i>{{ $hall['sessions'] }}</p>
                        </div>
                    </div>

                    <div class="border-t border-borderColor pt-5 xl:border-l xl:border-t-0 xl:py-2 xl:pl-7">
                        <p class="text-[14px] font-medium text-[#5A6480]">Hall Code</p>
                        <p class="mt-2 text-[18px] font-semibold text-navy">{{ $hall['code'] }}</p>
                        <div class="mt-5 flex flex-col gap-3">
                            <a href="{{ $hall['href'] }}" class="inline-flex h-[46px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[14px] font-semibold text-purple">View Map <i class="fa-solid fa-chevron-right text-[12px]"></i></a>
                            <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="inline-flex h-[46px] items-center justify-center gap-3 rounded-md bg-[#F4F0FF] px-5 text-[14px] font-semibold text-purple">Companies in Hall</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
