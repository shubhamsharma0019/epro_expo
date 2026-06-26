@extends('layouts.company')

@section('title', 'EproExpo Halls Listing')

@section('content')
@php
    $filter = $filter ?? 'all';
    $hallFilterUrl = function (string $mode) use ($selectedPavilion, $search, $selectedExhibition) {
        return url('/company/booth-booking/halls?' . http_build_query(array_filter([
            'pavilion' => $selectedPavilion?->id,
            'search' => $search ?? null,
            'filter' => $mode,
            'exhibition' => $selectedExhibition?->slug,
        ])));
    };
    $tabClass = function (string $mode) use ($filter) {
        return $filter === $mode
            ? 'h-[48px] border-b-2 border-purple px-4 text-[13px] font-semibold text-purple sm:h-[56px] sm:px-8 sm:text-[15px]'
            : 'h-[48px] px-4 text-[13px] font-medium text-[#34405F] hover:text-purple sm:h-[56px] sm:px-8 sm:text-[15px]';
    };
@endphp

<section class="w-full max-w-[1500px] px-4 py-6 sm:px-8 sm:py-8 lg:px-10 lg:py-10">
    <div class="mb-6 sm:mb-8">
        <h1 class="text-[26px] font-semibold leading-[32px] tracking-[-0.4px] text-navy sm:text-[36px] sm:leading-[40px] sm:tracking-[-0.8px]">
            {{ $selectedPavilion ? $selectedPavilion->title . ' Halls' : 'Halls' }}
        </h1>
    </div>

    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="w-full overflow-x-auto rounded-lg border border-borderColor bg-white shadow-sm xl:w-auto">
            <div class="flex min-w-max items-center">
                <a href="{{ $hallFilterUrl('all') }}" class="{{ $tabClass('all') }} inline-flex items-center">
                    All ({{ $allCount ?? 0 }})
                </a>
                <a href="{{ $hallFilterUrl('available') }}" class="{{ $tabClass('available') }} inline-flex items-center">
                    Available ({{ $availableCount ?? 0 }})
                </a>

            </div>
        </div>

        <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center xl:w-auto">
            <form id="hall-search-form" method="GET" action="{{ url('/company/booth-booking/halls') }}" class="relative block w-full sm:min-w-[320px] xl:w-[360px]" autocomplete="off">
                @if ($selectedPavilion)
                    <input type="hidden" name="pavilion" value="{{ $selectedPavilion->id }}">
                @endif
                @if ($selectedExhibition)
                    <input type="hidden" name="exhibition" value="{{ $selectedExhibition->slug }}">
                @endif
                @if (in_array($filter, ['all', 'available'], true))
                    <input type="hidden" name="filter" value="{{ $filter }}">
                @endif
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
                <input id="hall-search-input" type="search" name="search" value="{{ $search ?? '' }}" placeholder="Search halls..."
                    class="h-[52px] w-full rounded-md border border-borderColor bg-white pl-11 {{ ($search ?? '') !== '' ? 'pr-12' : 'pr-4' }} text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8] focus:border-purple">
                @if (($search ?? '') !== '')
                    <a href="{{ url('/company/booth-booking/halls?' . http_build_query(array_filter(['pavilion' => $selectedPavilion?->id, 'filter' => $filter, 'exhibition' => $selectedExhibition?->slug]))) }}" class="absolute right-3 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-full text-[#5A6480] hover:bg-gray-100" aria-label="Clear hall search">
                        <i class="fa-solid fa-xmark text-[13px]"></i>
                    </a>
                @endif
            </form>

            <button type="submit" form="hall-search-form" class="inline-flex h-[52px] w-full items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple sm:w-auto sm:min-w-[120px]">
                <i class="fa-solid fa-magnifying-glass text-[15px]"></i>
                Search
            </button>
        </div>
    </div>

    <div class="space-y-5">
        @forelse ($halls as $hall)
            @php
                $totalBooths = (int) $hall->booths_count;
                $availableBooths = $hall->available_booths_count ?: max($totalBooths - (int) $hall->booth_bookings_count, 0);
                $isAvailable = $availableBooths > 0;
                $imagePath = $hall->image ?: optional($hall->pavilion)->image ?: 'assets/images/pavilions/innovation-pavilion.png';
                $imageUrl = str_starts_with($imagePath, 'http') ? $imagePath : asset($imagePath);
                $bookedBooths = max($totalBooths - $availableBooths, 0);
            @endphp
            <div
                class="rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-5"
                data-hall-card
                data-search="{{ strtolower($hall->title . ' ' . $hall->slug . ' ' . ($hall->description ?? '') . ' ' . optional($hall->pavilion)->title . ' ' . optional($hall->pavilion)->slug . ' ' . $availableBooths . ' ' . $totalBooths) }}"
            >
                <div class="grid grid-cols-1 gap-4 sm:gap-5 xl:grid-cols-[170px_minmax(0,1fr)_330px] xl:items-center">
                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $hall->title }}"
                        class="h-[150px] w-full rounded-md object-cover sm:h-[132px] xl:w-[150px]"
                    >

                    <div class="min-w-0">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h2 class="text-[19px] font-semibold tracking-[-0.2px] text-navy sm:text-[20px] sm:tracking-[-0.3px]">
                                    {{ $hall->title }}
                                </h2>
                                <p class="mt-2 text-[14px] font-medium text-[#5A6480]">
                                    {{ optional($hall->pavilion)->title ?? 'Pavilion' }}
                                </p>
                            </div>

                            <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold {{ $isAvailable ? 'bg-[#EAF9F0] text-[#16A34A]' : 'bg-[#FEF2F2] text-[#DC2626]' }}">
                                {{ $isAvailable ? 'Available' : 'Booked Out' }}
                            </span>
                        </div>

                        <div class="grid gap-3 text-[14px] font-medium text-[#34405F] sm:grid-cols-2">
                            <p class="flex items-center gap-3">
                                <i class="fa-solid fa-shop w-4 text-purple"></i>
                                {{ number_format($availableBooths) }} Available Booths
                            </p>
                            <p class="flex items-center gap-3">
                                <i class="fa-regular fa-square w-4 text-purple"></i>
                                {{ number_format($bookedBooths) }} Booked Booths
                            </p>

                            <p class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-4 text-purple"></i>
                                {{ number_format($totalBooths) }} Total Booths
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-borderColor pt-5 xl:border-l xl:border-t-0 xl:py-2 xl:pl-7">
                        <p class="text-[14px] font-medium text-[#5A6480]">Hall Code</p>
                        <p class="mt-2 break-words text-[16px] font-semibold text-navy">{{ strtoupper($hall->slug) }}</p>

                        <div class="my-5 border-t border-borderColor"></div>

                        <p class="text-[14px] font-medium text-[#5A6480]">Availability</p>
                        <p class="mt-2 text-[22px] font-semibold leading-none text-navy sm:text-[24px]">{{ number_format($availableBooths) }} Available Booths</p>

                        <div class="mt-5 flex flex-col gap-3 sm:flex-row xl:flex-col">
                            <a href="{{ url('/company/booth-booking/floor-plan?' . http_build_query(array_filter(['hall' => $hall->id, 'exhibition' => $selectedExhibition?->slug]))) }}"
                                class="inline-flex h-[46px] w-full items-center justify-center gap-3 rounded-md border border-purple px-5 text-[14px] font-semibold text-purple sm:w-auto sm:min-w-[150px] xl:w-full xl:min-w-0">
                                View Details
                                <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            </a>

                            <a href="{{ url('/company/booth-booking/sizes?' . http_build_query(array_filter(['hall' => $hall->id, 'exhibition' => $selectedExhibition?->slug]))) }}"
                                class="inline-flex h-[46px] w-full items-center justify-center gap-3 rounded-md border border-purple px-5 text-[14px] font-semibold text-purple sm:w-auto sm:min-w-[150px] xl:w-full xl:min-w-0">
                                Book Booth
                                <i class="fa-solid fa-arrow-right text-[13px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-borderColor bg-white p-10 text-center shadow-sm">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#F4F0FF] text-purple">
                    <i class="fa-regular fa-building text-[24px]"></i>
                </div>
                <h3 class="text-[22px] font-semibold tracking-[-0.4px] text-navy">
                    No halls found
                </h3>
                <p class="mx-auto mt-2 max-w-[520px] text-[15px] leading-6 font-medium text-[#5A6480]">
                    {{ ($search ?? '') !== '' ? 'Try another search term or clear the search to see available halls.' : 'Halls will appear here once they are added for this pavilion.' }}
                </p>
            </div>
        @endforelse

        <div id="hall-search-empty" class="hidden rounded-xl border border-borderColor bg-white p-10 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#F4F0FF] text-purple">
                <i class="fa-solid fa-magnifying-glass text-[22px]"></i>
            </div>
            <h3 class="text-[22px] font-semibold tracking-[-0.4px] text-navy">
                No matching halls
            </h3>
            <p class="mx-auto mt-2 max-w-[520px] text-[15px] leading-6 font-medium text-[#5A6480]">
                Try searching by hall name, pavilion name, hall code, or booth count.
            </p>
        </div>
    </div>

</section>

@push('scripts')
<script>
    (() => {
        const hallSearchForm = document.getElementById('hall-search-form');
        const hallSearchInput = document.getElementById('hall-search-input');
        let hallSearchTimer;

        if (!hallSearchForm || !hallSearchInput) {
            return;
        }

        const cards = Array.from(document.querySelectorAll('[data-hall-card]'));
        const emptyState = document.getElementById('hall-search-empty');

        const filterCards = () => {
            const terms = hallSearchInput.value
                .trim()
                .toLowerCase()
                .split(/\s+/)
                .filter(Boolean);
            let visibleCount = 0;

            cards.forEach((card) => {
                const haystack = card.dataset.search || '';
                const isVisible = terms.length === 0 || terms.every((term) => haystack.includes(term));
                card.classList.toggle('hidden', !isVisible);
                visibleCount += isVisible ? 1 : 0;
            });

            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount !== 0 || terms.length === 0);
            }
        };

        hallSearchInput.addEventListener('input', () => {
            clearTimeout(hallSearchTimer);
            hallSearchTimer = setTimeout(filterCards, 120);
        });

        filterCards();
    })();
</script>
@endpush

@endsection
