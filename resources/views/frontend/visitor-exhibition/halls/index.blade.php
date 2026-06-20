@extends('layouts.exhibition')

@section('title', 'Visitor Halls - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

<section class="visitor-flow-page bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <div class="visitor-flow-hero">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Exhibition map</p>
            <h1>Exhibition halls</h1>
            <p>Each hall contains exhibitor booths, product demos, downloadable documents and live activity.</p>
        </div>

        <div class="mt-7 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse (($halls ?? collect()) as $hall)
                @php
                    $hallSlug = $hall->slug ?: $hall->id;
                    $boothMeta = ($hall->active_booths_count ?? 0) . ' booths';
                @endphp
                <article class="visitor-flow-card">
                    <div class="grid h-14 w-14 place-items-center rounded-xl bg-[#F4F0FF] text-[18px] font-bold text-[#5b2eff]">{{ strtoupper(substr($hall->title ?? 'H', 0, 1)) }}</div>
                    <h2 class="mt-5 text-[20px] font-bold text-[#071044]">{{ $hall->title ?? 'Hall' }}</h2>
                    <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $hall->description ?: 'Explore companies and booth activity in this hall.' }}</p>
                    <p class="mt-4 rounded-lg bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#34405F]">{{ $boothMeta }}</p>
                    <a href="{{ route('exhibitions.visitor-halls.show', [$slug, $hallSlug]) }}" class="mt-5 inline-flex h-10 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-4 text-[13px] font-bold text-white">View Hall</a>
                </article>
            @empty
                <div class="visitor-flow-empty md:col-span-2 xl:col-span-3">
                    <p class="text-[16px] font-semibold text-[#071044]">No halls published yet</p>
                    <p class="mt-2 text-[14px] text-[#5A6480]">Active halls for this exhibition will appear here once configured.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
