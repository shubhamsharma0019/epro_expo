@extends('layouts.company')

@section('title', 'Browse Exhibitions')
@section('page-title', 'Browse Exhibitions')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[26px] font-semibold leading-tight tracking-[-0.8px] text-navy sm:text-[34px] sm:leading-[42px]">Browse Exhibitions</h1>
    </div>

    <form method="GET" action="{{ route('company.exhibitions.index') }}" class="mb-7 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <label class="relative block w-full max-w-[420px]">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#5A6480] text-[16px]"></i>
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Search exhibitions..." class="h-[52px] w-full rounded-md border border-borderColor pl-11 pr-4 text-[14px] font-medium outline-none placeholder:text-[#6B7280] focus:border-purple">
        </label>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            @if (filled($search ?? ''))
                <a href="{{ route('company.exhibitions.index') }}" class="inline-flex h-[52px] items-center justify-center rounded-md border border-borderColor px-5 text-[15px] font-semibold text-[#34405F] hover:bg-gray-50">
                    Clear
                </a>
            @endif
            <button type="submit" class="inline-flex h-[52px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">
                <i class="fa-solid fa-filter text-[14px]"></i> Filter
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-7 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($exhibitions as $exhibition)
            @php
                $pavTitle = optional($exhibition->pavilions->first())->title
                    ?: ($exhibition->venue ?? $exhibition->location ?? 'Not available');
                $dates = ($exhibition->start_date && $exhibition->end_date)
                    ? \Carbon\Carbon::parse($exhibition->start_date)->format('M d') . ' - ' . \Carbon\Carbon::parse($exhibition->end_date)->format('M d, Y')
                    : 'Not available';
                $imageUrl = $exhibition->banner_image ? asset($exhibition->banner_image) : asset('assets/images/pavilions/innovation-pavilion.png');
            @endphp
            <article class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
                <img src="{{ $imageUrl }}" alt="{{ $exhibition->title ?? 'Exhibition' }}" class="h-[168px] w-full object-cover">
                <div class="p-6">
                    <h2 class="break-words text-[21px] font-semibold text-navy">{{ $exhibition->title ?? 'Not available' }}</h2>
                    <p class="mt-3 text-[15px] font-medium text-[#34405F]">{{ $pavTitle }}</p>
                    <p class="mt-2 text-[15px] font-medium text-[#5A6480]">{{ $dates }}</p>
                    
                    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                        @if ($exhibition->user_booking_status === 'booked')
                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-700">Booked & Approved</span>
                            <a href="{{ $exhibition->user_booking ? route('company.booth-setup.index', $exhibition->user_booking) : route('company.dashboard') }}" class="inline-flex h-[38px] items-center justify-center rounded-md bg-primary px-4 text-xs font-semibold text-white">
                                Setup Booth
                            </a>
                        @elseif ($exhibition->user_booking_status === 'pending')
                            <span class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-700">Pending Review</span>
                            <button disabled class="inline-flex h-[38px] items-center justify-center rounded-md bg-gray-100 px-4 text-xs font-semibold text-gray-400 cursor-not-allowed">
                                Locked
                            </button>
                        @else
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700">Available</span>
                            <a href="{{ route('company.booth-booking.pavilions', ['exhibition' => $exhibition->slug]) }}" class="inline-flex h-[38px] items-center justify-center rounded-md border border-purple px-4 text-xs font-semibold text-purple hover:bg-purple/5">
                                Book Now
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                {{ filled($search ?? '') ? 'No exhibitions matched your search.' : 'No active exhibitions found.' }}
            </div>
        @endforelse
    </div>
</section>
@endsection
