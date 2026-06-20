@extends('layouts.exhibition')

@section('title', 'My Meetings - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

<section class="visitor-flow-page max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="visitor-flow-hero mb-7">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor schedule</p>
        <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">My Meetings</h1>
        <p class="mt-3 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">Track meeting requests with participating companies and jump back into their booth pages.</p>
    </div>

    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="overflow-hidden rounded-lg border border-borderColor bg-white shadow-sm">
            <div class="visitor-flow-scroll-tabs flex items-center">
                <button type="button" data-filter="all" class="meeting-tab-btn h-[56px] border-b-2 border-purple text-purple px-6 text-[14px] sm:text-[15px] font-semibold focus:outline-none cursor-pointer transition-all shrink-0 whitespace-nowrap">
                    All Meetings ({{ $meetings->count() }})
                </button>
                <button type="button" data-filter="upcoming" class="meeting-tab-btn h-[56px] text-[#34405F] px-6 text-[14px] sm:text-[15px] font-semibold focus:outline-none cursor-pointer transition-all shrink-0 whitespace-nowrap">
                    Upcoming ({{ $upcoming->count() }})
                </button>
                <button type="button" data-filter="completed" class="meeting-tab-btn h-[56px] text-[#34405F] px-6 text-[14px] sm:text-[15px] font-semibold focus:outline-none cursor-pointer transition-all shrink-0 whitespace-nowrap">
                    Completed ({{ $completed->count() }})
                </button>
                <button type="button" data-filter="cancelled" class="meeting-tab-btn h-[56px] text-[#34405F] px-6 text-[14px] sm:text-[15px] font-semibold focus:outline-none cursor-pointer transition-all shrink-0 whitespace-nowrap">
                    Cancelled ({{ $cancelled->count() }})
                </button>
                <button type="button" data-filter="rescheduled" class="meeting-tab-btn h-[56px] text-[#34405F] px-6 text-[14px] sm:text-[15px] font-semibold focus:outline-none cursor-pointer transition-all shrink-0 whitespace-nowrap">
                    Rescheduled ({{ $rescheduled->count() }})
                </button>
            </div>
        </div>

        <label class="relative block w-full sm:w-[390px]">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
            <input type="text" id="meeting-search-input" placeholder="Search meeting topic, company..." class="h-[52px] w-full rounded-md border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8]">
        </label>
    </div>

    <div class="space-y-4">
        @if(isset($meetings) && $meetings->count() > 0)
            @foreach ($meetings as $meeting)
                @php
                    $cardFilterStatus = 'upcoming';
                    if ($meeting->status === 'completed') {
                        $cardFilterStatus = 'completed';
                    } elseif (in_array($meeting->status, ['cancelled', 'rejected'], true)) {
                        $cardFilterStatus = 'cancelled';
                    } elseif ($meeting->status === 'rescheduled') {
                        $cardFilterStatus = 'rescheduled';
                    }
                @endphp
                <x-visitor-exhibition.meeting-card 
                    :meeting="$meeting" 
                    :slug="$slug" 
                    class="meeting-card" 
                    data-status="{{ $cardFilterStatus }}"
                />
            @endforeach
        @else
            <div class="visitor-flow-empty">
                <p class="text-[16px] font-semibold text-navy">No meetings scheduled yet</p>
                <p class="mt-2 text-[14px] text-[#5A6480]">Book a meeting from an exhibitor booth to see it here.</p>
            </div>
        @endif
        
        <div id="meeting-filter-empty" class="hidden rounded-xl border border-borderColor bg-white p-8 text-center text-[15px] font-semibold text-[#5A6480] shadow-sm">
            No meetings found matching this filter or search query.
        </div>
    </div>
</section>

@push('scripts')
<script>
    (() => {
        const tabs = document.querySelectorAll('.meeting-tab-btn');
        const cards = document.querySelectorAll('.meeting-card');
        const searchInput = document.getElementById('meeting-search-input');
        const emptyState = document.getElementById('meeting-filter-empty');

        let activeFilter = 'all';
        let searchQuery = '';

        function applyFilters() {
            let visibleCount = 0;

            cards.forEach((card) => {
                const status = card.dataset.status;
                const text = card.textContent.toLowerCase();

                const matchesStatus = (activeFilter === 'all' || status === activeFilter);
                const matchesSearch = (!searchQuery || text.includes(searchQuery));

                if (matchesStatus && matchesSearch) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                if (visibleCount === 0 && cards.length > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        }

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                activeFilter = tab.dataset.filter;

                // Toggle active styles on tabs
                tabs.forEach((t) => {
                    t.classList.remove('border-b-2', 'border-purple', 'text-purple');
                    t.classList.add('text-[#34405F]');
                });

                tab.classList.add('border-b-2', 'border-purple', 'text-purple');
                tab.classList.remove('text-[#34405F]');

                applyFilters();
            });
        });

        searchInput?.addEventListener('input', (e) => {
            searchQuery = e.target.value.toLowerCase().trim();
            applyFilters();
        });
    })();
</script>
@endpush
@endsection
