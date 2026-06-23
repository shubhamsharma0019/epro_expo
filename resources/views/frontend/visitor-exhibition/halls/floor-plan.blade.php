@extends('layouts.exhibition')

@section('title', 'Visitor Floor Map - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')
@php
    $slug = $slug ?? '';
    $isPassActive = $isPassActive ?? false;
    $exhibitionName = $exhibition ? ($exhibition->title ?: $exhibition->name) : str($slug)->replace('-', ' ')->title();
    $exhibitionDescription = $exhibition?->description
        ?: 'Preview booth locations and details. Active pass holders can save booths, book meetings, chat, download brochures and join sessions.';
@endphp

<section class="visitor-flow-page mx-auto w-full max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7 rounded-xl border border-borderColor bg-white p-6 shadow-sm lg:p-8">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
            <div>
                <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor map</p>
                <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">{{ $exhibitionName }}</h1>
                <p class="mt-3 max-w-[820px] text-[16px] font-medium leading-7 text-[#5A6480]">{{ $exhibitionDescription }}</p>
            </div>
            @if ($isPassActive)
                <a href="{{ route('exhibitions.visitor.dashboard', $slug) }}" class="inline-flex h-12 items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[14px] font-semibold text-white">
                    <i class="fa-solid fa-gauge"></i>
                    Visitor Dashboard
                </a>
            @else
                <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="inline-flex h-12 items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[14px] font-semibold text-white">
                    <i class="fa-regular fa-id-card"></i>
                    Register / Get Pass
                </a>
            @endif
        </div>
    </div>

    @unless ($isPassActive)
        <div class="mb-6 rounded-xl border border-[#EADCFD] bg-[#FBFAFF] p-5">
            <h2 class="text-[18px] font-semibold text-navy">Guest floor preview</h2>
            <p class="mt-1 text-[14px] font-medium text-[#5A6480]">Register / Get Pass to access meeting booking, live chat, brochures, protected demos, sessions and saved booths.</p>
        </div>
    @endunless

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="floor-map-scroll overflow-hidden rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-5">
            @include('frontend.exhibitions.booths.partials.floor-diagram', ['hideDetailsPanel' => true])
        </div>

        <aside class="space-y-5">
            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm">
                <h2 class="text-[20px] font-semibold text-navy">Map Legend</h2>
                <div class="mt-5 space-y-3">
                    @foreach ([['Technology', '#5b2eff'], ['Cloud', '#246BFF'], ['Sustainability', '#16A34A'], ['Healthcare', '#EC4899'], ['Finance', '#F59E0B'], ['Education', '#0F766E']] as [$label, $color])
                        <div class="flex items-center gap-3 text-[14px] font-medium text-[#34405F]">
                            <span class="h-3 w-3 rounded-full" style="background: {{ $color }}"></span>
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm">
                <h2 class="text-[20px] font-semibold text-navy">Visitor Actions</h2>
                <div class="mt-5 space-y-3">
                    @foreach (['Open Company Booth', 'Book Meeting', 'Live Chat', 'Download Brochure', 'Join Session'] as $action)
                        <div class="rounded-lg bg-[#FBFAFF] p-3 text-[13px] font-semibold text-[#34405F]">
                            {{ $action }}
                            @unless ($isPassActive)
                                <span class="mt-1 block text-[12px] text-purple">Register / Get Pass to access this feature</span>
                            @endunless
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
