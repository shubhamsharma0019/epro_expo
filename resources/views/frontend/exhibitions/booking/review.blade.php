@extends('layouts.exhibition')

@section('title', 'EproExpo Review and Confirm')

@section('content')

<section class="max-w-[1500px] px-4 py-6 sm:px-8 lg:px-10 lg:py-10">

    <div class="rounded-xl border border-borderColor bg-white px-4 py-6 shadow-sm sm:px-8 sm:py-7">
        <h1 class="mb-4 text-[26px] font-semibold leading-tight text-navy sm:mb-6 sm:text-[34px] sm:leading-[42px]">
            Review and Confirm
        </h1>

        <div class="mb-6 flex items-center gap-5 overflow-x-auto rounded-xl border border-borderColor bg-white px-4 py-4 text-[14px] font-medium text-[#34405F] sm:mb-8 sm:justify-between sm:gap-8 sm:px-6 sm:py-5 sm:text-[16px]">
            @foreach ([
                ['Pavilions', '/exhibitions/pavilions/innovation-pavilion'],
                ['Halls', '/exhibitions/halls/hall-1'],
                ['Booth', '/exhibitions/booths/slots'],
                ['Booth Size', '/exhibitions/booths/sizes'],
                ['Services', '/exhibitions/booking/services'],
            ] as [$label, $href])
                <a href="{{ url($href) }}" class="flex shrink-0 items-center gap-4">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[15px] font-semibold text-white">
                        {{ $loop->iteration }}
                    </span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach

            <a href="{{ url('/exhibitions/booking/review') }}" class="flex shrink-0 items-center gap-4 text-purple">
                <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-purple bg-white text-[15px] font-semibold text-purple">6</span>
                <span class="font-semibold">Review</span>
            </a>
        </div>

        <p class="mb-6 text-[16px] leading-7 text-[#5A6480] sm:mb-8 sm:text-[22px] sm:leading-8">
            Review your details before confirming.
        </p>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center justify-between gap-5 sm:mb-8">
                    <h2 class="text-[21px] font-semibold text-navy sm:text-[26px]">Review Your Order</h2>
                    <a href="{{ url('/exhibitions/booking/services') }}" class="text-[16px] font-semibold text-purple sm:text-[18px]">
                        Edit
                    </a>
                </div>

                <div class="space-y-5 text-[16px] text-navy sm:text-[19px]">
                    <div class="grid gap-1 sm:grid-cols-[180px_minmax(0,1fr)] sm:gap-5">
                        <span>Pavilion</span>
                        <span>Innovation Pavilion</span>
                    </div>
                    <div class="grid gap-1 sm:grid-cols-[180px_minmax(0,1fr)] sm:gap-5">
                        <span>Hall</span>
                        <span>Hall 1 - Tech and Innovation</span>
                    </div>
                    <div class="grid gap-1 sm:grid-cols-[180px_minmax(0,1fr)] sm:gap-5">
                        <span>Booth</span>
                        <span>Booth 12A (10m &times; 3m)</span>
                    </div>
                    <div class="grid gap-1 sm:grid-cols-[180px_minmax(0,1fr)] sm:gap-5">
                        <span>Duration</span>
                        <span>May 16 &ndash; May 19, 2024 (4 Days)</span>
                    </div>
                    <div class="grid gap-1 sm:grid-cols-[180px_minmax(0,1fr)] sm:gap-5">
                        <span>Time Slots</span>
                        <span>May 16, 11 AM - 12 PM</span>
                    </div>
                    <div class="grid gap-1 sm:grid-cols-[180px_minmax(0,1fr)] sm:gap-5">
                        <span>Services</span>
                        <span>{{ $selectedServicesLabel }}</span>
                    </div>
                </div>

                <div class="my-8 border-t border-borderColor"></div>

                <div class="space-y-5 text-[16px] text-[#34405F] sm:text-[19px]">
                    <div class="flex items-center justify-between gap-6">
                        <span>Booth Price</span>
                        <span class="font-semibold text-navy">${{ number_format($boothPrice, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-6">
                        <span>Service Price</span>
                        <span class="font-semibold text-navy">${{ number_format($servicesAmount, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-6">
                        <span>Slot Price</span>
                        <span class="font-semibold text-navy">${{ number_format($slotPrice, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-6">
                        <span>Tax (10%)</span>
                        <span class="font-semibold text-navy">${{ number_format($taxAmount, 2) }}</span>
                    </div>
                </div>

                @if ($selectedServices->isNotEmpty())
                    <div class="my-8 border-t border-borderColor"></div>

                    <div class="space-y-3">
                        @foreach ($selectedServices as $service)
                            <div class="flex flex-col gap-1 rounded-lg bg-[#FBFAFF] px-4 py-3 text-[15px] font-semibold text-navy sm:flex-row sm:items-center sm:justify-between sm:gap-5">
                                <span>{{ $service->title }}</span>
                                <span>${{ number_format((float) $service->price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="my-8 border-t border-borderColor"></div>

                <div class="flex items-center justify-between gap-6">
                    <span class="text-[17px] font-semibold text-navy sm:text-[19px]">Total Amount</span>
                    <span class="text-[26px] font-semibold leading-none text-navy sm:text-[32px]">${{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-8">
                <h2 class="mb-6 text-[21px] font-semibold text-navy sm:mb-9 sm:text-[26px]">
                    Terms and Conditions
                </h2>

                <div class="space-y-6 sm:space-y-9">
                    <label class="flex cursor-pointer items-start gap-4 text-[16px] text-navy sm:items-center sm:gap-5 sm:text-[19px]">
                        <input type="checkbox" class="h-7 w-7 rounded border-[#8FA0C7] text-purple">
                        <span>I agree to the terms and conditions.</span>
                    </label>

                    <label class="flex cursor-pointer items-start gap-4 text-[16px] text-navy sm:items-center sm:gap-5 sm:text-[19px]">
                        <input type="checkbox" class="h-7 w-7 rounded border-[#8FA0C7] text-purple">
                        <span>I understand the cancellation policy.</span>
                    </label>

                    <label class="flex cursor-pointer items-start gap-4 text-[16px] text-navy sm:items-center sm:gap-5 sm:text-[19px]">
                        <input type="checkbox" checked class="h-7 w-7 rounded border-[#8FA0C7] text-purple">
                        <span>I confirm all details are correct.</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-borderColor bg-white px-4 py-5 shadow-sm sm:px-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <h2 class="text-[22px] font-semibold text-navy sm:text-[28px]">Total Amount</h2>

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <span class="text-[26px] font-semibold leading-none text-navy sm:text-[30px]">${{ number_format($totalAmount, 2) }}</span>
                    <a href="{{ url('/exhibitions/booking/payment') }}"
                        class="inline-flex h-[56px] w-full items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[16px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)] sm:h-[66px] sm:w-auto sm:min-w-[420px] sm:gap-5 sm:px-8 sm:text-[21px]">
                        Confirm and Proceed to Payment
                        <i class="fa-solid fa-arrow-right text-[17px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
