@extends('layouts.company')

@section('title', 'Exhibition Details')
@section('page-title', 'Exhibition Details')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
            @php
                $imageUrl = $exhibition->banner_image ? asset($exhibition->banner_image) : asset('images/exhibitions/hero-pavilion-scene.png');
                $dates = \Carbon\Carbon::parse($exhibition->start_date)->format('M d') . ' - ' . \Carbon\Carbon::parse($exhibition->end_date)->format('M d, Y');
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $exhibition->title }}" class="h-[280px] w-full object-cover">
            <div class="p-6 sm:p-8">
                <span class="rounded-md bg-[#F4F0FF] px-3 py-1.5 text-[13px] font-semibold text-purple">
                    @if ($exhibition->user_booking_status === 'booked')
                        Booked
                    @elseif ($exhibition->user_booking_status === 'pending')
                        Pending Approval
                    @else
                        Open for exhibitors
                    @endif
                </span>
                <h1 class="mt-5 text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">{{ $exhibition->title }}</h1>
                <p class="mt-4 text-[16px] font-medium leading-7 text-[#34405F]">{{ $exhibition->description }}</p>

                <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-xl border border-borderColor p-5">
                        <p class="text-[22px] font-semibold text-navy">{{ $dates }}</p>
                        <p class="mt-2 text-[14px] font-medium text-[#5A6480]">Dates</p>
                    </div>
                    <div class="rounded-xl border border-borderColor p-5">
                        <p class="text-[22px] font-semibold text-navy">{{ $exhibition->pavilions->count() }} Pavilions</p>
                        <p class="mt-2 text-[14px] font-medium text-[#5A6480]">Zones</p>
                    </div>
                    <div class="rounded-xl border border-borderColor p-5">
                        <p class="text-[22px] font-semibold text-navy">1,200+ Booths</p>
                        <p class="mt-2 text-[14px] font-medium text-[#5A6480]">Capacity</p>
                    </div>
                </div>
            </div>
        </div>

        <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm xl:self-start">
            @if ($exhibition->user_booking_status === 'booked')
                <h2 class="text-[22px] font-semibold text-navy">Booth Confirmed</h2>
                <p class="mt-3 text-[15px] font-medium leading-7 text-[#34405F]">Your booth booking is approved. Go to your dashboard to complete your profile setup.</p>
                <a href="{{ route('company.dashboard') }}" class="mt-7 inline-flex h-[54px] w-full items-center justify-center gap-3 rounded-md bg-gradient-to-r from-success to-green-600 px-6 text-[16px] font-semibold text-white shadow-sm">
                    Go to Dashboard <i class="fa-solid fa-arrow-right text-[13px]"></i>
                </a>
            @elseif ($exhibition->user_booking_status === 'pending')
                <h2 class="text-[22px] font-semibold text-navy">Awaiting Approval</h2>
                <p class="mt-3 text-[15px] font-medium leading-7 text-[#34405F]">Your booth payment was successful. We are currently verifying your slot details.</p>
                <button disabled class="mt-7 inline-flex h-[54px] w-full items-center justify-center gap-3 rounded-md bg-gray-100 px-6 text-[16px] font-semibold text-gray-400 cursor-not-allowed">
                    Pending Verification <i class="fa-solid fa-clock text-[13px]"></i>
                </button>
            @else
                <h2 class="text-[22px] font-semibold text-navy">Start Booth Booking</h2>
                <p class="mt-3 text-[15px] font-medium leading-7 text-[#34405F]">Select pavilion, hall, floor plan, size, and slot before payment.</p>
                <a href="{{ url('/company/booth-booking/pavilions') }}" class="mt-7 inline-flex h-[54px] w-full items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[16px] font-semibold text-white">
                    Select Pavilion <i class="fa-solid fa-arrow-right text-[13px]"></i>
                </a>
            @endif
        </aside>
    </div>
</section>
@endsection
