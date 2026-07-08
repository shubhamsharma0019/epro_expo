@extends('layouts.frontend')

@section('title', 'Event Categories')

@section('content')
<main class="px-4 md:px-[44px] pt-8 pb-12">
    <div class="mx-auto max-w-6xl">
        <div class="mb-7 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-[12px] font-extrabold uppercase tracking-[0.22em] text-[#6D28D9]">Explore Events</p>
                <h1 class="mt-2 text-[26px] font-extrabold tracking-[-0.03em] text-[#071044] md:text-[34px]">Browse Events by Category</h1>
                <p class="mt-2 max-w-2xl text-[15px] leading-6 text-[#59617F]">Choose a category to see matching live and upcoming events from the database.</p>
            </div>
            <a href="{{ route('events.listings.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-[#E4DDF4] bg-white px-5 text-[14px] font-bold text-[#5B2EFF] shadow-sm transition hover:bg-[#F6F1FF]">View All Events</a>
        </div>

        @if ($categories->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($categories as $category)
                    @php
                        $name = $category['name'] ?? 'General';
                        $value = $category['value'] ?? $name;
                        $total = (int) ($category['total'] ?? 0);
                        $initial = strtoupper(substr($name, 0, 1));
                    @endphp
                    <a href="{{ route('events.listings.index', ['category' => $value]) }}" class="group rounded-3xl border border-[#E8E3F0] bg-white p-6 shadow-[0_16px_38px_rgba(17,24,78,0.08)] transition hover:-translate-y-1 hover:border-[#BBA7FF] hover:shadow-[0_20px_44px_rgba(91,46,255,0.14)]">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EEE7FF] text-[22px] font-black text-[#5B2EFF] transition group-hover:bg-[#5B2EFF] group-hover:text-white">{{ $initial }}</span>
                        <h2 class="mt-5 text-[18px] font-extrabold text-[#071044]">{{ $name }}</h2>
                        <p class="mt-2 text-[14px] font-semibold text-[#59617F]">{{ $total }} {{ \Illuminate\Support\Str::plural('event', $total) }} available</p>
                        <span class="mt-5 inline-flex text-[13px] font-extrabold text-[#5B2EFF]">Browse category -></span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-[#E8E3F0] bg-white p-8 text-center shadow-[0_16px_38px_rgba(17,24,78,0.08)]">
                <h2 class="text-[20px] font-extrabold text-[#071044]">No categories found</h2>
                <p class="mt-2 text-[15px] text-[#59617F]">Add event categories in MySQL to show them here.</p>
                <a href="{{ route('events.listings.index') }}" class="mt-6 inline-flex h-11 items-center justify-center rounded-xl bg-[#5B2EFF] px-6 text-[14px] font-bold text-white">Back to Events</a>
            </div>
        @endif
    </div>
</main>
@endsection