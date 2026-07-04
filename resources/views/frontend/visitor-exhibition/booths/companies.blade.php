@extends('layouts.exhibition')

@section('title', 'Participating Companies - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')
@php
    $slug = $slug ?? '';
    $isPassActive = $isPassActive ?? false;
    $companies = isset($booths)
        ? $booths->map(function ($booking) {
            $company = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;

            return [
                \Illuminate\Support\Str::slug($company),
                $booking->exhibition?->slug ?: $slug,
                $company,
                $booking->boothProfile?->tagline ?: $booking->boothProfile?->about_company ?: 'Visit this booth to explore products, documents, catalogues and meeting options.',
                $booking->hall?->title ?: $booking->hall?->name ?: 'Hall',
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
@endphp

<section class="visitor-flow-page mx-auto w-full max-w-[1500px] px-4 py-6 sm:px-8 lg:px-10 lg:py-8">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($companies as [$companySlug, $companyExhibitionSlug, $company, $summary, $hall, $booth, $category, $status, $products, $brochures, $image])
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

                    <div class="company-card-actions mt-auto pt-4">
                        <a href="{{ route('exhibitions.visitor.companies.show', [$companyExhibitionSlug, $companySlug]) }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#6D28D9] px-3 text-[12px] font-bold text-white hover:bg-[#5726E8]">
                            Open Booth
                        </a>
                        <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#DCE1EE] px-3 text-[12px] font-bold text-navy hover:bg-[#F8F7FF]">
                            Map
                        </a>
                        <button class="inline-flex h-10 w-full items-center justify-center rounded-lg border border-[#DCE1EE] text-[#6D28D9] hover:bg-[#F8F7FF] sm:w-10" title="{{ $isPassActive ? 'Save booth' : 'Register / Get Pass to access this feature' }}">
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
