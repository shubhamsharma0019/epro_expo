@extends('layouts.frontend')

@section('title', 'My Visitor Passes - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7 rounded-xl border border-borderColor bg-white p-6 shadow-sm lg:p-8">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor access</p>
        <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">My Passes / Registered Exhibitions</h1>
        <p class="mt-3 max-w-[820px] text-[16px] font-medium leading-7 text-[#5A6480]">Manage your visitor passes, QR entry, registered exhibitions, session access and company booth activity.</p>
    </div>

    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="overflow-hidden rounded-lg border border-borderColor bg-white shadow-sm">
            <div class="flex min-w-max items-center">
                @foreach (['All Passes' => 'all', 'Active' => 'active', 'Upcoming' => 'upcoming', 'Completed' => 'completed'] as $tab => $filter)
                    <button type="button" 
                            data-filter="{{ $filter }}" 
                            class="pass-tab-btn h-[56px] {{ $filter === 'all' ? 'border-b-2 border-purple text-purple' : 'text-[#34405F]' }} px-8 text-[15px] font-semibold focus:outline-none cursor-pointer transition-all">
                        {{ $tab }}
                    </button>
                @endforeach
            </div>
        </div>

        <label class="relative block w-full sm:w-[390px]">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
            <input type="text" id="pass-search-input" placeholder="Search exhibition, pass ID, company..." class="h-[52px] w-full rounded-md border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8]">
        </label>
    </div>

    <div class="space-y-5">
        @if(isset($visitors) && $visitors->count() > 0)
            @foreach ($visitors as $visitor)
                @php
                    $exh = $visitor->exhibition;
                    $title = $exh->title ?: ($exh->name ?: 'Exhibition');
                    $pass = $visitor->pass_type ?: 'Free Visitor Pass';
                    $id = $visitor->booking_id;
                    if ($exh && $exh->start_date && $exh->end_date) {
                        $date = $exh->start_date->format('M d') . ' - ' . $exh->end_date->format('d, Y');
                    } else {
                        $date = 'June 12 - June 14, 2026';
                    }
                    // Count bookmarks/meetings
                    $bookmarksCount = \App\Models\Bookmark::where('booking_id', $visitor->booking_id)->where('bookmarkable_type', 'exhibitor')->count();
                    $meetingsCount = $visitor->meetings()->count();
                    
                    $visitorName = trim($visitor->first_name . ' ' . $visitor->last_name) ?: '-';
                    $visitorEmail = $visitor->email ?: '-';
                    $visitorMobile = $visitor->mobile ?: '-';

                    // Dynamic Status Calculation
                    $now = now();
                    if ($exh && $exh->start_date && $exh->end_date) {
                        if ($now->between($exh->start_date, $exh->end_date)) {
                            $status = 'Active';
                            $statusClass = 'bg-[#EAF9F0] text-[#16A34A]';
                        } elseif ($now->lt($exh->start_date)) {
                            $status = 'Upcoming';
                            $statusClass = 'bg-[#E8F3FF] text-[#0B7AE8]';
                        } else {
                            $status = 'Completed';
                            $statusClass = 'bg-[#F3F4F6] text-[#6B7280]';
                        }
                    } else {
                        $status = 'Active';
                        $statusClass = 'bg-[#EAF9F0] text-[#16A34A]';
                    }
                @endphp
                <article class="pass-card rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6" data-status="{{ strtolower($status) }}">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_330px] xl:items-center">
                        <div class="min-w-0">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h2 class="text-[22px] font-semibold text-navy">{{ $title }}</h2>
                                    <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $pass }} | {{ $date }}</p>
                                </div>
                                <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold {{ $statusClass }}">{{ $status }}</span>
                            </div>

                            <div class="mt-5 grid gap-3 text-[14px] font-medium text-[#34405F] sm:grid-cols-3">
                                <p><i class="fa-regular fa-id-card mr-2 text-purple"></i>{{ $id }}</p>
                                <p><i class="fa-solid fa-store mr-2 text-purple"></i>{{ $bookmarksCount }} saved booths</p>
                                <p><i class="fa-regular fa-calendar-check mr-2 text-purple"></i>{{ $meetingsCount }} meetings</p>
                            </div>

                            <div class="mt-4 border-t border-gray-100 pt-4 grid gap-3 text-[13px] text-[#5A6480] sm:grid-cols-3">
                                <p><i class="fa-regular fa-user mr-2 text-purple"></i>Attendee: <span class="font-semibold text-navy">{{ $visitorName }}</span></p>
                                <p><i class="fa-regular fa-envelope mr-2 text-purple"></i>Email: <span class="font-semibold text-navy">{{ $visitorEmail }}</span></p>
                                <p><i class="fa-solid fa-phone mr-2 text-purple"></i>Mobile: <span class="font-semibold text-navy">{{ $visitorMobile }}</span></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <a href="{{ route('exhibitions.tickets.e-ticket', $exh->slug ?? $slug) }}?booking_id={{ $id }}&id={{ $visitor->exhibition_id }}" class="inline-flex h-11 items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-semibold text-white">View QR Pass</a>
                            <a href="{{ route('exhibitions.visitor.dashboard', ['slug' => $exh->slug ?? $slug, 'booking_id' => $id]) }}" class="inline-flex h-11 items-center justify-center rounded-md border border-borderColor px-5 text-[14px] font-semibold text-purple">Open Dashboard</a>
                        </div>
                    </div>
                </article>
            @endforeach
        @else
            @foreach ([['Global Tech Expo 2026', 'Business Pass', 'VIS-2026-1048', 'June 12 - June 14, 2026', 'Active', 'bg-[#EAF9F0] text-[#16A34A]', 'John Doe', 'john.doe@email.com', '+91 98765 43210'], ['Healthcare Innovation Expo', 'Visitor Pass', 'VIS-2026-2210', 'July 8 - July 10, 2026', 'Upcoming', 'bg-[#E8F3FF] text-[#0B7AE8]', 'John Doe', 'john.doe@email.com', '+91 98765 43210'], ['Sustainable Business Fair', 'VIP Pass', 'VIS-2026-3309', 'August 3 - August 5, 2026', 'Upcoming', 'bg-[#E8F3FF] text-[#0B7AE8]', 'John Doe', 'john.doe@email.com', '+91 98765 43210']] as [$title, $pass, $id, $date, $status, $statusClass, $visitorName, $visitorEmail, $visitorMobile])
                <article class="pass-card rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6" data-status="{{ strtolower($status) }}">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_330px] xl:items-center">
                        <div class="min-w-0">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h2 class="text-[22px] font-semibold text-navy">{{ $title }}</h2>
                                    <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $pass }} | {{ $date }}</p>
                                </div>
                                <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold {{ $statusClass }}">{{ $status }}</span>
                            </div>

                            <div class="mt-5 grid gap-3 text-[14px] font-medium text-[#34405F] sm:grid-cols-3">
                                <p><i class="fa-regular fa-id-card mr-2 text-purple"></i>{{ $id }}</p>
                                <p><i class="fa-solid fa-store mr-2 text-purple"></i>8 saved booths</p>
                                <p><i class="fa-regular fa-calendar-check mr-2 text-purple"></i>3 meetings</p>
                            </div>

                            <div class="mt-4 border-t border-gray-100 pt-4 grid gap-3 text-[13px] text-[#5A6480] sm:grid-cols-3">
                                <p><i class="fa-regular fa-user mr-2 text-purple"></i>Attendee: <span class="font-semibold text-navy">{{ $visitorName }}</span></p>
                                <p><i class="fa-regular fa-envelope mr-2 text-purple"></i>Email: <span class="font-semibold text-navy">{{ $visitorEmail }}</span></p>
                                <p><i class="fa-solid fa-phone mr-2 text-purple"></i>Mobile: <span class="font-semibold text-navy">{{ $visitorMobile }}</span></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <a href="{{ route('exhibitions.visitor.qr-pass', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-semibold text-white">View QR Pass</a>
                            <a href="{{ route('exhibitions.visitor.dashboard', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-md border border-borderColor px-5 text-[14px] font-semibold text-purple">Open Dashboard</a>
                        </div>
                    </div>
                </article>
            @endforeach
        @endif
        
        <div id="pass-filter-empty" class="hidden rounded-xl border border-borderColor bg-white p-8 text-center text-[15px] font-semibold text-[#5A6480] shadow-sm">
            No passes found matching this filter or search query.
        </div>
    </div>
</section>

@push('scripts')
<script>
    (() => {
        const tabs = document.querySelectorAll('.pass-tab-btn');
        const cards = document.querySelectorAll('.pass-card');
        const searchInput = document.getElementById('pass-search-input');
        const emptyState = document.getElementById('pass-filter-empty');

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
                if (visibleCount === 0) {
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
