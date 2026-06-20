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

        <form method="GET" action="{{ url('/company/booth-booking/payment') }}">
            <input type="hidden" name="exhibition" value="{{ session('company_booth_booking.exhibition_slug') }}">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="rounded-xl border border-borderColor bg-white p-8 shadow-sm">
                <div class="mb-8 flex items-center justify-between gap-5">
                    <h2 class="text-[26px] font-semibold text-navy">Review Your Order</h2>
                    <a href="{{ url('/company/booth-booking/services?' . http_build_query(array_filter(['exhibition' => session('company_booth_booking.exhibition_slug')]))) }}" class="text-[18px] font-semibold text-purple">
                        Edit
                    </a>
                </div>

                <div class="space-y-5 text-[16px] sm:text-[19px] text-navy">
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] sm:grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Pavilion</span>
                        <span>{{ $summary?->pavilion_title ?? $booking->pavilion?->title ?? 'Pavilion' }}</span>
                    </div>
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] sm:grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Hall</span>
                        <span>{{ $summary?->hall_title ?? $booking->hall?->title ?? 'Hall' }}</span>
                    </div>
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] sm:grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Booth</span>
                        <span>{{ $summary?->booth_number ? 'Booth ' . $summary->booth_number : ($booking->booth ? 'Booth ' . $booking->booth->booth_number : 'Booth') }}{{ $summary?->booth_size_title ? ' (' . $summary->booth_size_title . ')' : '' }}</span>
                    </div>
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] sm:grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Duration</span>
                        <span>{{ $selectedDays->count() }} {{ $selectedDays->count() === 1 ? 'Day' : 'Days' }}</span>
                    </div>
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] sm:grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Selected Days</span>
                        <span>{{ $daysLabel ?: 'No days selected' }}</span>
                    </div>
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] sm:grid-cols-[180px_minmax(0,1fr)] gap-5">
                        <span>Services</span>
                        <span>{{ $selectedServicesLabel }}</span>
                    </div>
                </div>

                <div class="my-8 border-t border-borderColor"></div>

                <div class="space-y-5 text-[17px] sm:text-[19px] text-[#34405F]">
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
                    <span class="text-[17px] sm:text-[19px] font-semibold text-navy">Total Amount</span>
                    <span class="text-[26px] sm:text-[32px] font-semibold leading-none text-navy">&#8377;{{ number_format($amountToPay) }}</span>
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-6 sm:p-8 shadow-sm">
                <h2 class="mb-6 sm:mb-9 text-[22px] sm:text-[26px] font-semibold text-navy">
                    Terms and Conditions
                </h2>

                <div class="mb-6 h-[220px] overflow-y-auto rounded-lg border border-borderColor bg-[#FBFAFF] p-4 text-[14px] leading-6 text-[#5A6480]">
                    <h3 class="mb-1.5 font-bold text-navy">1. Booth Booking and Allocation</h3>
                    <p class="mb-4">Booths are allocated on a first-come, first-served basis upon receipt of full payment. The organizer reserves the right to alter the layout or relocate booths if necessary for event optimization.</p>
                    
                    <h3 class="mb-1.5 font-bold text-navy">2. Payment Terms</h3>
                    <p class="mb-4">All bookings must be paid in full to confirm the reservation. Failure to complete the payment within the designated timeframe may result in cancellation of the booking draft and release of the selected space.</p>
                    
                    <h3 class="mb-1.5 font-bold text-navy">3. Cancellation and Refund Policy</h3>
                    <p class="mb-4">Cancellations made more than 30 days before the exhibition start date will receive a 50% refund. No refunds will be provided for cancellations made within 30 days of the event, or for no-shows.</p>
                    
                    <h3 class="mb-1.5 font-bold text-navy">4. Liability and Insurance</h3>
                    <p class="mb-4 font-semibold">Exhibitors must maintain adequate insurance coverage. The organizer is not liable for any loss, damage, theft of exhibitor property, or injury to personnel during the event.</p>
                </div>

                <div class="space-y-6 sm:space-y-9">
                    <label class="flex cursor-pointer items-center gap-4 sm:gap-5 text-[16px] sm:text-[19px] text-navy">
                        <input type="checkbox" name="terms_accepted" required class="h-6 w-6 sm:h-7 sm:w-7 circular-checkbox">
                        <span>I agree to the terms and conditions.</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-4 sm:gap-5 text-[16px] sm:text-[19px] text-navy">
                        <input type="checkbox" name="cancellation_policy_accepted" required class="h-6 w-6 sm:h-7 sm:w-7 circular-checkbox">
                        <span>I understand the cancellation policy.</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-4 sm:gap-5 text-[16px] sm:text-[19px] text-navy">
                        <input type="checkbox" name="details_confirmed" required checked class="h-6 w-6 sm:h-7 sm:w-7 circular-checkbox">
                        <span>I confirm all details are correct.</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-borderColor bg-white px-5 py-5 sm:px-8 shadow-sm">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <h2 class="text-[22px] sm:text-[28px] font-semibold text-navy">Total Amount</h2>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <span class="text-[24px] sm:text-[30px] font-semibold leading-none text-navy">&#8377;{{ number_format($amountToPay) }}</span>
                    <button type="submit"
                        class="inline-flex h-[56px] sm:h-[66px] w-full sm:w-auto min-w-0 sm:min-w-[300px] items-center justify-center gap-4 sm:gap-5 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 sm:px-8 text-[17px] sm:text-[21px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                        Confirm and Proceed to Payment
                        <i class="fa-solid fa-arrow-right text-[17px]"></i>
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>

</section>

@endsection
