@extends('layouts.company')

@section('title', 'EproExpo Review and Confirm')
@section('page-title', 'Review and Confirm')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="rounded-xl border border-borderColor bg-white px-6 py-7 shadow-sm sm:px-8">
        <h1 class="mb-6 text-[26px] font-semibold leading-tight tracking-[-0.8px] text-navy sm:mb-8 sm:text-[34px] sm:leading-[42px]">
            Review and Confirm
        </h1>

        <form method="GET" action="{{ url('/company/booth-booking/payment') }}">
            <input type="hidden" name="exhibition" value="{{ session('company_booth_booking.exhibition_slug') }}">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center justify-between gap-5 sm:mb-8">
                    <h2 class="text-[22px] font-semibold text-navy sm:text-[26px]">Review Your Order</h2>
                    <a href="{{ url('/company/booth-booking/services?' . http_build_query(array_filter(['exhibition' => session('company_booth_booking.exhibition_slug')]))) }}" class="text-[16px] font-semibold text-purple sm:text-[18px]">
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

            <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-8">
                <div class="mb-2 flex items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#f5f2ff] text-purple">
                        <i class="fa-solid fa-file-contract text-[15px]"></i>
                    </span>
                    <h2 class="text-[22px] font-semibold text-navy sm:text-[26px]">Terms and Conditions</h2>
                </div>
                <p class="mb-5 text-[13.5px] font-medium leading-6 text-[#5A6480] sm:text-[14px]">
                    Please review and accept each term to confirm your exhibition booth booking.
                </p>

                @php
                    $exhibitionTerms = [
                        'booking_payment_allocation' => [
                            'title' => 'Booking, Payment & Booth Allocation',
                            'body' => 'All booth bookings, exhibition/event registrations, and payments are subject to availability and confirmation. Booth allocation will be managed according to the selected package, hall availability, and platform booking policies.',
                        ],
                        'cancellation_event_management' => [
                            'title' => 'Cancellation, Modifications & Event Management',
                            'body' => 'Any cancellation, modification, rescheduling, or refund request will be handled according to the platform\'s event and exhibition policies. Organizers reserve the right to make necessary changes to schedules, layouts, or event arrangements when required.',
                        ],
                        'participant_responsibilities' => [
                            'title' => 'Participant Responsibilities & Platform Usage',
                            'body' => 'Companies, exhibitors, and visitors are responsible for providing accurate information and complying with all event, exhibition, and platform guidelines. Any misuse, false information, or violation of platform policies may result in booking cancellation or restricted access.',
                        ],
                    ];
                @endphp

                <div class="space-y-2.5">
                    @foreach ($exhibitionTerms as $termKey => $term)
                        <label data-term-row class="flex cursor-pointer items-start gap-3 rounded-xl border border-borderColor bg-[#FBFAFF] p-3.5 transition-all duration-200 hover:border-[#c7bcff] sm:gap-4 sm:p-4">
                            <input
                                type="checkbox"
                                name="acknowledged_terms[{{ $termKey }}]"
                                value="1"
                                required
                                data-term-checkbox
                                class="mt-0.5 h-5 w-5 shrink-0 cursor-pointer accent-[#5b2eff]"
                            >
                            <span class="min-w-0">
                                <span class="block text-[15px] font-semibold text-navy">{{ $term['title'] }}</span>
                                <span class="mt-1 block text-[13px] leading-6 text-[#5A6480]">{{ $term['body'] }}</span>
                            </span>
                        </label>
                    @endforeach
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

@push('scripts')
<script>
    (() => {
        // Highlight a term row while its checkbox is acknowledged.
        document.querySelectorAll('[data-term-checkbox]').forEach((checkbox) => {
            const syncTermRow = () => {
                const row = checkbox.closest('[data-term-row]');
                if (!row) {
                    return;
                }

                row.classList.toggle('border-borderColor', ! checkbox.checked);
                row.classList.toggle('bg-[#FBFAFF]', ! checkbox.checked);
                row.classList.toggle('hover:border-[#c7bcff]', ! checkbox.checked);
                row.classList.toggle('border-[#5b2eff]', checkbox.checked);
                row.classList.toggle('bg-[#f5f2ff]', checkbox.checked);
                row.classList.toggle('shadow-[0_4px_12px_rgba(91,46,255,0.10)]', checkbox.checked);
            };

            checkbox.addEventListener('change', syncTermRow);
            syncTermRow();
        });
    })();
</script>
@endpush

@endsection
