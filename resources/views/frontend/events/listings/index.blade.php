@extends('layouts.frontend')

@section('title', 'Events Page')

@section('content')
<main class="px-[44px] pt-8 pb-10">
            <div class="mb-6">
                <h1 class="text-[22px] font-extrabold tracking-[-0.02em] text-[#212D6B]">All Events</h1>
                <p class="mt-2 text-[14px] text-[#4E567A]">Discover and book events that interest you.</p>
            </div>

            <div class="mb-6 flex items-center gap-5">
                <form id="event-listing-search" method="GET" action="{{ route('events.listings.index') }}"
                    class="flex h-[54px] flex-1 items-center gap-3 rounded-xl border border-[#E8E4F1] bg-white px-4 shadow-[0_1px_3px_rgba(31,42,107,0.03)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#9095AD]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..."
                        class="flex-1 bg-transparent text-[15px] text-[#2B3263] outline-none placeholder:text-[#9CA1B8]" />
                </form>

                <button type="submit" form="event-listing-search"
                    class="flex h-[50px] items-center gap-3 rounded-xl border border-[#A58CEB] bg-white px-7 text-[15px] font-semibold text-[#5B35D5] transition hover:bg-[#6D55E7] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 4.5h18L14 12v5.25l-4 2.25V12L3 4.5Z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>

            <div class="mb-5 flex gap-10 border-b border-[#E6E1F0]">
                <button class="-mb-px border-b-2 border-[#5B35D5] pb-[14px] text-[15px] font-semibold text-[#5B35D5]">Upcoming</button>
                <button class="pb-[14px] text-[15px] text-[#444C72]">Ongoing</button>
                <button class="pb-[14px] text-[15px] text-[#444C72]">Past</button>
            </div>

            <div class="space-y-4">
                @forelse (($dbEvents ?? collect()) as $event)
                        @php
                            $eventBanner = $event->branding?->banner_path ? asset('storage/' . $event->branding->banner_path) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&h=350&fit=crop';
                            $eventDates = $event->starts_at ? $event->starts_at->format('M d') . ($event->ends_at ? ' - ' . $event->ends_at->format('d, Y') : $event->starts_at->format(', Y')) : 'Date TBD';
                            $eventLocation = $event->venue_name ? $event->venue_name . ', ' . ($event->city ?? '') : ($event->venue_address ?? 'Location TBD');
                        @endphp
                        <article
                            class="flex items-center justify-between rounded-2xl border border-[#E8E3F0] bg-white px-3 py-3 shadow-[0_1px_2px_rgba(27,36,87,0.02)]">
                            <div class="flex items-center gap-7">
                                <img src="{{ $eventBanner }}"
                                    alt="{{ $event->title }}" class="h-[108px] w-[184px] rounded-xl object-cover bg-gray-100" />
                                <div>
                                    <h2 class="mb-3 text-[18px] font-bold tracking-[-0.01em] text-[#1F2A6A]">{{ $event->title }}</h2>
                                    <div class="mb-3 flex items-center gap-7 text-[14px] text-[#50597A]">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 2.25v3m7.5-3v3M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                            </svg>
                                            <span>{{ $eventDates }}</span>
                                        </span>
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 21s6-4.35 6-10.125a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                            </svg>
                                            <span>{{ $eventLocation }}</span>
                                        </span>
                                    </div>
                                    <div class="flex gap-3">
                                        <span class="rounded-lg bg-[#F4F0FF] px-3 py-1.5 text-[14px] text-[#5B35D5]">{{ ucfirst(str_replace('_', ' ', $event->event_type ?? 'Event')) }}</span>
                                        <span class="rounded-lg bg-[#F4F0FF] px-3 py-1.5 text-[14px] text-[#5B35D5]">{{ $event->category ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>
                            <button onclick="window.location.href='{{ route('events.listings.show', $event->slug) }}'"
                                class="mr-2 h-[42px] rounded-xl border border-[#B9A8F3] px-7 text-[15px] font-semibold text-[#5B35D5] transition hover:border-[#6D55E7] hover:bg-[#6D55E7] hover:text-white">
                                View Details
                            </button>
                        </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#D8DDF0] bg-white px-6 py-10 text-center">
                        <p class="text-[16px] font-bold text-[#1F2A6A]">No events found</p>
                        <p class="mt-2 text-[14px] text-[#4E567A]">Create an event in company flow or adjust your search filters.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex items-center justify-between">
                <p class="text-[14px] text-[#444C72]">Showing {{ count($dbEvents ?? []) }} of {{ count($dbEvents ?? []) }} events</p>
            </div>
        </main>
@endsection
