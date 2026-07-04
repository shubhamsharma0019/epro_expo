@extends('layouts.exhibition')

@section('title', 'Saved Booths - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

@php
    $savedBooths = ($savedBooths ?? collect())->map(function ($booking) {
        $company = $booking->boothProfile?->company_name
            ?: $booking->company?->company_name
            ?: $booking->company?->name
            ?: 'Company';
        $hall = $booking->hall?->title ?: $booking->hall?->name ?: 'Hall';
        $booth = $booking->booth?->booth_number ?: $booking->booth_id ?: 'N/A';

        return [
            'slug' => \Illuminate\Support\Str::slug($company),
            'company' => $company,
            'location' => $hall . ' / ' . $booth,
            'note' => $booking->boothProfile?->tagline
                ?: $booking->boothProfile?->about_company
                ?: 'Products, catalogues and meeting options are available in this booth.',
        ];
    });
@endphp

<section class="visitor-flow-page mx-auto w-full max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="visitor-flow-hero mb-7">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor workspace</p>
        <h1>Saved Booths</h1>
        <p>Your shortlisted companies, product demos, brochures and meeting notes in one place.</p>
    </div>

    @if ($savedBooths->isNotEmpty())
        <div class="grid gap-5 lg:grid-cols-3">
            @foreach ($savedBooths as $booth)
                <article class="visitor-flow-card">
                    <div class="flex items-start gap-4">
                        <div class="grid h-14 w-14 shrink-0 place-items-center rounded-xl bg-[#F4F0FF] text-[20px] font-semibold text-purple">{{ substr($booth['company'], 0, 1) }}</div>
                        <div>
                            <h2 class="text-[20px] font-semibold text-navy">{{ $booth['company'] }}</h2>
                            <p class="mt-1 text-[13px] font-semibold text-purple">{{ $booth['location'] }}</p>
                        </div>
                    </div>
                    <p class="mt-5 min-h-[54px] text-[14px] font-medium leading-6 text-[#5A6480]">{{ $booth['note'] }}</p>
                    <div class="mt-5 flex gap-3">
                        <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $booth['slug']]) }}" class="inline-flex h-11 flex-1 items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-4 text-[13px] font-semibold text-white">Open Booth</a>
                        <a href="{{ route('frontend.user.meetings') }}" class="inline-flex h-11 items-center justify-center rounded-md border border-borderColor px-4 text-[13px] font-semibold text-purple">Meeting</a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="visitor-flow-empty">
            <p class="text-[16px] font-semibold text-navy">No saved booths yet</p>
            <p class="mt-2 text-[14px] text-[#5A6480]">Save a booth from any company page to see it listed here.</p>
            <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="mt-5 inline-flex h-11 items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[13px] font-semibold text-white">Browse Companies</a>
        </div>
    @endif
</section>
@endsection
