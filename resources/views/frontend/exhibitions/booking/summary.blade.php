@extends('layouts.exhibition')

@section('title', 'EproExpo Booking Summary')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">
            Booking Summary
        </h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">
            Review your selected pavilion, hall, booth, slots, and customization before adding services.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-8 flex items-center justify-between gap-5">
                <h2 class="text-[26px] font-semibold text-navy">Selected Booth Package</h2>
                <span class="rounded-md bg-[#EAF9F0] px-3 py-1.5 text-[13px] font-semibold text-[#16A34A]">Ready</span>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                @foreach ([
                    ['Pavilion', 'Innovation Pavilion', 'fa-layer-group'],
                    ['Hall', 'Hall 1 - Tech & Innovation', 'fa-building'],
                    ['Booth', 'Booth 12A (10m x 3m)', 'fa-shop'],
                    ['Slot', 'May 16, 11 AM - 12 PM', 'fa-calendar-days'],
                    ['Customization', 'Logo Fascia, Reception Counter', 'fa-pen-nib'],
                    ['Duration', 'May 16 - May 19, 2024 (4 Days)', 'fa-clock'],
                ] as [$label, $value, $icon])
                    <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-md bg-[#F4F0FF] text-purple">
                            <i class="fa-solid {{ $icon }} text-[15px]"></i>
                        </div>
                        <p class="text-[14px] font-medium text-[#5A6480]">{{ $label }}</p>
                        <p class="mt-2 text-[17px] font-semibold text-navy">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm xl:self-start">
            <h2 class="mb-6 text-[22px] font-semibold text-navy">Price Summary</h2>
            <div class="space-y-4 text-[15px] font-medium text-[#34405F]">
                @foreach ([
                    ['Booth Price', '₹499'],
                    ['Slot Price', '₹99'],
                    ['Customization', '₹128'],
                ] as [$label, $amount])
                    <div class="flex items-center justify-between gap-5">
                        <span>{{ $label }}</span>
                        <span class="font-semibold text-navy">{{ $amount }}</span>
                    </div>
                @endforeach
            </div>
            <div class="my-6 border-t border-borderColor"></div>
            <div class="flex items-center justify-between gap-5">
                <span class="text-[16px] font-semibold text-[#34405F]">Sub Total</span>
                <span class="text-[30px] font-semibold leading-none text-navy">₹726</span>
            </div>
            <a href="{{ url('/exhibitions/booking/services') }}" class="mt-7 inline-flex h-[58px] w-full items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                Add Services
                <i class="fa-solid fa-arrow-right text-[15px]"></i>
            </a>
        </aside>
    </div>

</section>

@endsection
