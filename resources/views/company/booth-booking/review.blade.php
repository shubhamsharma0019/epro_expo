@extends('layouts.company-flow')

@section('title', 'EproExpo Review and Confirm')
@section('page-title', 'Review and Confirm')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="rounded-xl border border-borderColor bg-white px-6 py-7 shadow-sm sm:px-8">
        <h1 class="mb-6 text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">
            Review and Confirm
        </h1>

        <p class="mb-8 text-[22px] leading-8 text-[#5A6480]">
            Review your details before confirming.
        </p>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="rounded-xl border border-borderColor bg-white p-8 shadow-sm">
                <div class="mb-8 flex items-center justify-between gap-5">
                    <h2 class="text-[26px] font-semibold text-navy">Review Your Order</h2>
                    <a href="{{ url('/company/booth-booking/services') }}" class="text-[18px] font-semibold text-purple">
                        Edit
                    </a>
                </div>

                <div class="space-y-5 text-[19px] text-navy">
                    <div class="grid grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Pavilion</span>
                        <span>{{ $summary?->pavilion_title ?? $booking->pavilion?->title ?? 'Pavilion' }}</span>
                    </div>
                    <div class="grid grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Hall</span>
                        <span>{{ $summary?->hall_title ?? $booking->hall?->title ?? 'Hall' }}</span>
                    </div>
                    <div class="grid grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Booth</span>
                        <span>{{ $summary?->booth_number ? 'Booth ' . $summary->booth_number : ($booking->booth ? 'Booth ' . $booking->booth->booth_number : 'Booth') }}{{ $summary?->booth_size_title ? ' (' . $summary->booth_size_title . ')' : '' }}</span>
                    </div>
                    <div class="grid grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Duration</span>
                        <span>{{ $selectedDays->count() }} {{ $selectedDays->count() === 1 ? 'Day' : 'Days' }}</span>
                    </div>
                    <div class="grid grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Selected Days</span>
                        <span>{{ $daysLabel ?: 'No days selected' }}</span>
                    </div>
                    <div class="grid grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Services</span>
                        <span>{{ $selectedServicesLabel }}</span>
                    </div>
                </div>

                <div class="my-8 border-t border-borderColor"></div>

                <div class="space-y-5 text-[19px] text-[#34405F]">
                    <div class="flex items-center justify-between gap-6">
                        <span>Booth Price</span>
                        <span class="font-semibold text-navy">&#8377;{{ number_format($boothPrice) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-6">
                        <span>Days Amount</span>
                        <span class="font-semibold text-navy">&#8377;{{ number_format($daysAmount) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-6">
                        <span>Services Amount</span>
                        <span class="font-semibold text-navy">&#8377;{{ number_format($servicesAmount) }}</span>
                    </div>
                </div>

                <div class="my-8 border-t border-borderColor"></div>

                <div class="flex items-center justify-between gap-6">
                    <span class="text-[19px] font-semibold text-navy">Total Amount</span>
                    <span class="text-[32px] font-semibold leading-none text-navy">&#8377;{{ number_format($amountToPay) }}</span>
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-8 shadow-sm">
                <h2 class="mb-9 text-[26px] font-semibold text-navy">
                    Terms and Conditions
                </h2>

                <div class="space-y-9">
                    <label class="flex cursor-pointer items-center gap-5 text-[19px] text-navy">
                        <input type="checkbox" class="h-7 w-7 rounded border-[#8FA0C7] text-purple">
                        <span>I agree to the terms and conditions.</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-5 text-[19px] text-navy">
                        <input type="checkbox" class="h-7 w-7 rounded border-[#8FA0C7] text-purple">
                        <span>I understand the cancellation policy.</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-5 text-[19px] text-navy">
                        <input type="checkbox" checked class="h-7 w-7 rounded border-[#8FA0C7] text-purple">
                        <span>I confirm all details are correct.</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-borderColor bg-white px-8 py-5 shadow-sm">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <h2 class="text-[28px] font-semibold text-navy">Total Amount</h2>

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <span class="text-[30px] font-semibold leading-none text-navy">&#8377;{{ number_format($amountToPay) }}</span>
                    <a href="{{ url('/company/booth-booking/payment') }}"
                        class="inline-flex h-[66px] min-w-[420px] items-center justify-center gap-5 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[21px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                        Confirm and Proceed to Payment
                        <i class="fa-solid fa-arrow-right text-[17px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
