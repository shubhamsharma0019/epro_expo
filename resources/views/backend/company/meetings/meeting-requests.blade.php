@extends('layouts.company')

@section('title', 'Meetings')
@section('page-title', 'Meetings')

@section('content')
<section class="max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Manage Meetings</h1>
    </div>

    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="overflow-hidden rounded-lg border border-borderColor bg-white shadow-sm">
            <div class="flex items-center flex-wrap">
                <button type="button" data-filter="all" class="meeting-tab-btn h-[52px] border-b-2 border-purple text-purple px-5 text-[14px] font-semibold focus:outline-none cursor-pointer transition-all">
                    All ({{ $meetings->count() }})
                </button>
                <button type="button" data-filter="upcoming" class="meeting-tab-btn h-[52px] text-[#34405F] px-5 text-[14px] font-semibold focus:outline-none cursor-pointer transition-all">
                    Upcoming ({{ $upcoming->count() }})
                </button>
                <button type="button" data-filter="completed" class="meeting-tab-btn h-[52px] text-[#34405F] px-5 text-[14px] font-semibold focus:outline-none cursor-pointer transition-all">
                    Completed ({{ $completed->count() }})
                </button>
                <button type="button" data-filter="cancelled" class="meeting-tab-btn h-[52px] text-[#34405F] px-5 text-[14px] font-semibold focus:outline-none cursor-pointer transition-all">
                    Cancelled ({{ $cancelled->count() }})
                </button>
                <button type="button" data-filter="rescheduled" class="meeting-tab-btn h-[52px] text-[#34405F] px-5 text-[14px] font-semibold focus:outline-none cursor-pointer transition-all">
                    Rescheduled ({{ $rescheduled->count() }})
                </button>
            </div>
        </div>

        <label class="relative block w-full sm:w-[350px]">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
            <input type="text" id="meeting-search-input" placeholder="Search attendee, topic..." class="h-[48px] w-full rounded-md border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8]">
        </label>
    </div>

    <div class="space-y-4">
        @forelse ($meetings as $meeting)
            @php
                $time = $meeting->companyMeeting ? \Carbon\Carbon::parse($meeting->companyMeeting->start_time)->format('M d, h:i A') : '';
                $title = $meeting->companyMeeting ? $meeting->companyMeeting->title : 'Meeting Appointment';
                
                $cardFilterStatus = 'upcoming';
                if ($meeting->status === 'completed') {
                    $cardFilterStatus = 'completed';
                } elseif (in_array($meeting->status, ['cancelled', 'rejected'], true)) {
                    $cardFilterStatus = 'cancelled';
                } elseif ($meeting->status === 'rescheduled') {
                    $cardFilterStatus = 'rescheduled';
                }
            @endphp
            <a href="{{ route('company.meetings.show', $meeting->id) }}" class="meeting-card block rounded-xl border border-borderColor bg-white p-5 shadow-sm hover:border-purple" data-status="{{ $cardFilterStatus }}">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-[19px] font-semibold text-navy">{{ $title }}</h2>
                        <p class="mt-2 text-[15px] font-medium text-[#34405F]">
                            {{ $meeting->visitor_name }} <span class="mx-2">&bull;</span> {{ $time }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Requested: {{ $meeting->created_at->format('M d, Y') }}</p>
                    </div>
                    <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold 
                        {{ $meeting->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : (in_array($meeting->status, ['confirmed', 'accepted'], true) ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700') }}">
                        {{ ucfirst($meeting->status) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="rounded-xl border border-borderColor bg-white p-8 text-center text-gray-500">
                No meetings scheduled yet.
            </div>
        @endforelse
        
        <div id="meeting-filter-empty" class="hidden rounded-xl border border-borderColor bg-white p-8 text-center text-gray-500">
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
