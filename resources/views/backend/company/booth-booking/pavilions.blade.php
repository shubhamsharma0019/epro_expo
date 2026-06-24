@extends('layouts.company')

@section('title', 'EproExpo Pavilions')

@section('content')
@php
    $viewMode = $viewMode ?? 'grid';
    $viewUrl = function (string $mode) use ($search, $selectedExhibition) {
        return url('/company/booth-booking/pavilions?' . http_build_query(array_filter([
            'search' => $search ?? null,
            'view' => $mode,
            'exhibition' => $selectedExhibition?->slug,
        ])));
    };
    $exhibitionQuery = isset($selectedExhibition) && $selectedExhibition ? 'exhibition=' . urlencode($selectedExhibition->slug) . '&' : '';
    $viewButtonClass = function (string $mode) use ($viewMode) {
        return $viewMode === $mode
            ? 'flex h-10 w-10 items-center justify-center rounded-md bg-white text-purple shadow-sm ring-1 ring-purple sm:h-[48px] sm:w-[48px] sm:border sm:border-purple sm:ring-0'
            : 'flex h-10 w-10 items-center justify-center rounded-md text-[#43506D] hover:bg-white sm:h-[48px] sm:w-[48px] sm:border sm:border-borderColor';
    };
    $cardsClass = match ($viewMode) {
        'list' => 'space-y-5',
        'compact' => 'grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 sm:gap-5',
        default => 'grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3 sm:gap-7',
    };
@endphp

<section class="w-full max-w-[1500px] px-4 py-6 sm:px-8 sm:py-8 lg:px-10 lg:py-10">
    <!-- PAGE HEAD -->
    <div class="mb-6">
        <div class="mb-3 flex items-center gap-3 sm:gap-4">
            <i class="fa-regular fa-building text-[24px] text-navy sm:text-[28px]"></i>
            <h1 class="text-[26px] font-semibold leading-[32px] tracking-[-0.4px] sm:text-[34px] sm:leading-[36px]">
                All Pavilions
            </h1>
        </div>

    </div>

    <!-- SEARCH + VIEW BUTTONS -->
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <form id="pavilion-search-form" method="GET" action="{{ url('/company/booth-booking/pavilions') }}" class="relative w-full sm:max-w-[420px]">
            <input type="hidden" name="view" value="{{ $viewMode }}">
            @if ($selectedExhibition)
                <input type="hidden" name="exhibition" value="{{ $selectedExhibition->slug }}">
            @endif
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#5A6480] text-[16px]"></i>
            <input id="pavilion-search-input" type="search" name="search" value="{{ $search ?? '' }}" placeholder="Search pavilions..."
                class="h-[48px] w-full rounded-md border border-borderColor pl-11 {{ ($search ?? '') !== '' ? 'pr-12' : 'pr-4' }} text-[14px] font-medium outline-none placeholder:text-[#6B7280] focus:border-purple">
            @if (($search ?? '') !== '')
                <a href="{{ url('/company/booth-booking/pavilions?' . http_build_query(array_filter(['view' => $viewMode, 'exhibition' => $selectedExhibition?->slug]))) }}" class="absolute right-3 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-full text-[#5A6480] hover:bg-gray-100" aria-label="Clear pavilion search">
                    <i class="fa-solid fa-xmark text-[13px]"></i>
                </a>
            @endif
        </form>

        <div class="inline-flex shrink-0 items-center gap-1 self-start rounded-lg border border-borderColor bg-[#F8FAFC] p-1 sm:gap-2 sm:self-auto sm:border-0 sm:bg-transparent sm:p-0">
            <a href="{{ $viewUrl('grid') }}" class="{{ $viewButtonClass('grid') }}" aria-label="Grid view">
                <i class="fa-solid fa-table-cells-large text-[17px]"></i>
            </a>

            <a href="{{ $viewUrl('list') }}" class="{{ $viewButtonClass('list') }}" aria-label="List view">
                <i class="fa-solid fa-list text-[17px]"></i>
            </a>

            <a href="{{ $viewUrl('compact') }}" class="{{ $viewButtonClass('compact') }}" aria-label="Compact view">
                <i class="fa-solid fa-border-all text-[17px]"></i>
            </a>
        </div>
    </div>

    <!-- CARDS -->
    <div class="{{ $cardsClass }}">

        @forelse ($pavilions as $pavilion)
            @php
                $hallCount = $pavilion->halls_count;
                $boothCount = $pavilion->halls->sum('booths_count');
                $imagePath = $pavilion->image ?: 'assets/images/pavilions/innovation-pavilion.png';
                $imageUrl = str_starts_with($imagePath, 'http')
                    ? $imagePath
                    : asset($imagePath);
            @endphp

            @if ($viewMode === 'list')
                <div class="overflow-hidden rounded-xl border border-borderColor bg-white p-4 shadow-sm">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[220px_minmax(0,1fr)_180px] lg:items-center lg:gap-5">
                        <img class="h-[150px] w-full rounded-md object-cover lg:h-[132px]"
                            src="{{ $imageUrl }}"
                            alt="{{ $pavilion->title }}">

                        <div class="min-w-0">
                            <h3 class="text-[20px] font-semibold tracking-[-0.2px] sm:text-[22px]">
                                {{ $pavilion->title }}
                            </h3>
                            <p class="mt-2 text-[14px] font-medium text-[#34405F] sm:text-[15px]">
                                {{ number_format($hallCount) }} {{ \Illuminate\Support\Str::plural('Hall', $hallCount) }}
                                <span class="mx-2">&bull;</span>
                                {{ number_format($boothCount) }} {{ \Illuminate\Support\Str::plural('Booth', $boothCount) }}
                            </p>
                            <p class="mt-3 text-[14px] leading-6 font-medium text-[#071044] sm:text-[15px]">
                                {{ $pavilion->description ?: optional($pavilion->exhibition)->title ?: 'Explore halls and available booths in this pavilion.' }}
                            </p>
                        </div>

                        <a href="{{ url('/company/booth-booking/halls?' . $exhibitionQuery . 'pavilion=' . $pavilion->id) }}" class="inline-flex h-[46px] w-full items-center justify-center gap-3 rounded-md border border-purple px-5 text-[14px] font-semibold text-purple lg:w-auto">
                            View Details
                            <i class="fa-solid fa-arrow-right text-[13px]"></i>
                        </a>
                    </div>
                </div>
            @elseif ($viewMode === 'compact')
                <div class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
                    <img class="h-[120px] w-full object-cover"
                        src="{{ $imageUrl }}"
                        alt="{{ $pavilion->title }}">

                    <div class="p-4 sm:p-5">
                        <h3 class="truncate text-[18px] font-semibold tracking-[-0.2px] sm:text-[19px]">
                            {{ $pavilion->title }}
                        </h3>
                        <p class="mt-2 text-[14px] font-medium text-[#34405F]">
                            {{ number_format($hallCount) }} {{ \Illuminate\Support\Str::plural('Hall', $hallCount) }}
                            <span class="mx-2">&bull;</span>
                            {{ number_format($boothCount) }} {{ \Illuminate\Support\Str::plural('Booth', $boothCount) }}
                        </p>
                        <a href="{{ url('/company/booth-booking/halls?' . $exhibitionQuery . 'pavilion=' . $pavilion->id) }}" class="mt-4 inline-flex items-center gap-3 text-[14px] font-semibold text-purple">
                            View Details
                            <i class="fa-solid fa-arrow-right text-[12px]"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
                    <img class="h-[160px] w-full object-cover"
                        src="{{ $imageUrl }}"
                        alt="{{ $pavilion->title }}">

                    <div class="p-5 sm:p-6">
                        <h3 class="mb-3 text-[20px] font-semibold tracking-[-0.2px] sm:text-[22px]">
                            {{ $pavilion->title }}
                        </h3>

                        <p class="mb-3 text-[15px] font-medium text-[#34405F]">
                            {{ number_format($hallCount) }} {{ \Illuminate\Support\Str::plural('Hall', $hallCount) }}
                            <span class="mx-2">&bull;</span>
                            {{ number_format($boothCount) }} {{ \Illuminate\Support\Str::plural('Booth', $boothCount) }}
                        </p>

                        <p class="mb-6 min-h-[48px] text-[15px] leading-6 font-medium text-[#071044]">
                            {{ $pavilion->description ?: optional($pavilion->exhibition)->title ?: 'Explore halls and available booths in this pavilion.' }}
                        </p>

                        <a href="{{ url('/company/booth-booking/halls?' . $exhibitionQuery . 'pavilion=' . $pavilion->id) }}" class="inline-flex items-center gap-3 text-[15px] font-semibold text-purple">
                            View Details
                            <i class="fa-solid fa-arrow-right text-[13px]"></i>
                        </a>
                    </div>
                </div>
            @endif
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-xl border border-borderColor bg-white p-10 text-center shadow-sm">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#F4F0FF] text-purple">
                    <i class="fa-regular fa-building text-[24px]"></i>
                </div>
                <h3 class="text-[22px] font-semibold tracking-[-0.4px] text-navy">
                    No pavilions found
                </h3>
                <p class="mx-auto mt-2 max-w-[520px] text-[15px] leading-6 font-medium text-[#5A6480]">
                    {{ ($search ?? '') !== '' ? 'Try another search term or clear the search to see all active pavilions.' : 'Active pavilions will appear here once they are added from the database.' }}
                </p>
                @if (($search ?? '') !== '')
                    <a href="{{ url('/company/booth-booking/pavilions') }}" class="mt-5 inline-flex items-center gap-3 text-[15px] font-semibold text-purple">
                        Clear Search
                        <i class="fa-solid fa-arrow-right text-[13px]"></i>
                    </a>
                @endif
            </div>
        @endforelse

    </div>

</section>

@push('scripts')
<script>
    const pavilionSearchForm = document.getElementById('pavilion-search-form');
    const pavilionSearchInput = document.getElementById('pavilion-search-input');
    let pavilionSearchTimer;

    if (pavilionSearchForm && pavilionSearchInput) {
        pavilionSearchInput.addEventListener('input', () => {
            clearTimeout(pavilionSearchTimer);
            pavilionSearchTimer = setTimeout(() => {
                pavilionSearchForm.submit();
            }, 450);
        });
    }
</script>
@endpush

@endsection
