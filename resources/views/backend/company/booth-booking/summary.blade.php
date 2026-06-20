@extends('layouts.company-flow')

@section('title', 'EproExpo Booking Summary')

@section('content')
<section class="max-w-[1500px] px-4 py-6 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-6 sm:mb-8">
        <h1 class="text-[26px] sm:text-[34px] font-semibold leading-tight sm:leading-[42px] tracking-[-0.8px] text-navy">
            Booking Summary
        </h1>
        <p class="mt-2 sm:mt-3 text-[14px] sm:text-[16px] font-medium leading-relaxed sm:leading-7 text-[#34405F]">
            Review your selected pavilion, hall, booth, days, and total before adding services.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="rounded-xl border border-borderColor bg-white p-4 sm:p-6 md:p-8 shadow-sm">
            <div class="mb-6 sm:mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-[20px] sm:text-[26px] font-semibold text-navy">Selected Booth Package</h2>
                <span class="self-start rounded-md bg-[#EAF9F0] px-3 py-1.5 text-[13px] font-semibold text-[#16A34A] sm:self-auto">
                    {{ ucfirst($booking->booking_status) }}
                </span>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-4 rounded-xl border border-[#DCD3FF] bg-[#FBFAFF] p-4 sm:p-5 sm:grid-cols-[180px_minmax(0,1fr)] sm:items-center">
                <div class="flex items-baseline gap-3 sm:block">
                    <p class="text-[13px] font-semibold text-[#5A6480]">Selected Days</p>
                    <p class="mt-1 sm:mt-2 text-[32px] sm:text-[38px] font-semibold leading-none text-purple">{{ $summary->selected_days_count }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse (($summary->selected_days ?? []) as $day)
                        <span class="rounded-md border border-[#DCD3FF] bg-white px-3 py-2 text-[14px] font-semibold text-navy">
                            {{ $day['label'] ?? $day['date'] }}
                        </span>
                    @empty
                        <span class="text-[14px] font-semibold text-[#5A6480]">No days selected</span>
                    @endforelse
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 sm:gap-5">
                @foreach ([
                    ['Pavilion', $summary->pavilion_title ?? 'Pavilion', 'fa-layer-group'],
                    ['Hall', $summary->hall_title ?? 'Hall', 'fa-building'],
                    ['Booth', $summary->booth_number ? 'Booth ' . $summary->booth_number : 'Booth', 'fa-shop'],
                    ['Selected Days', collect($summary->selected_days ?? [])->pluck('label')->join(', ') ?: $daysLabel, 'fa-calendar-days'],
                    ['Booth Size', $summary->booth_size_title ?? 'Custom Size', 'fa-vector-square'],
                    ['Duration', $summary->selected_days_count . ' ' . ((int) $summary->selected_days_count === 1 ? 'Day' : 'Days'), 'fa-clock'],
                ] as [$label, $value, $icon])
                    <div class="rounded-xl border border-borderColor bg-white p-4 sm:p-5 shadow-sm">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-md bg-[#F4F0FF] text-purple">
                            <i class="fa-solid {{ $icon }} text-[15px]"></i>
                        </div>
                        <p class="text-[14px] font-medium text-[#5A6480]">{{ $label }}</p>
                        <p class="mt-2 text-[16px] sm:text-[17px] font-semibold text-navy">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="rounded-xl border border-borderColor bg-white p-4 sm:p-6 shadow-sm xl:self-start">
            <h2 class="mb-6 text-[20px] sm:text-[22px] font-semibold text-navy">Price Summary</h2>
            <div class="space-y-4 text-[15px] font-medium text-[#34405F]">
                @foreach ([
                    ['Booth Price', '&#8377;' . number_format((float) $summary->booth_price)],
                    ['Selected Days', $summary->selected_days_count],
                    ['Days Amount', '&#8377;' . number_format((float) $summary->days_amount)],
                    ['Services Amount', '&#8377;' . number_format((float) $summary->services_amount)],
                ] as [$label, $amount])
                    <div class="flex items-center justify-between gap-5">
                        <span>{{ $label }}</span>
                        <span class="font-semibold text-navy">{!! $amount !!}</span>
                    </div>
                @endforeach
            </div>
            <div class="my-6 border-t border-borderColor"></div>
            <div class="flex items-center justify-between gap-5">
                <span class="text-[16px] font-semibold text-[#34405F]">Sub Total</span>
                <span class="text-[26px] sm:text-[30px] font-semibold leading-none text-navy">&#8377;{{ number_format((float) $summary->total_amount) }}</span>
            </div>
            <div class="mt-6 sm:mt-7 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-1">
                <a href="{{ url('/company/booth-booking/slots?' . http_build_query(array_filter(['hall' => $booking->hall_id, 'booth' => $booking->booth_id, 'size' => $booking->booth_size_id, 'exhibition' => session('company_booth_booking.exhibition_slug')]))) }}" class="inline-flex h-[52px] sm:h-[58px] xl:h-[52px] w-full items-center justify-center rounded-md border border-[#B9A7FF] px-6 text-[16px] font-semibold text-purple">
                    Edit Days
                </a>
                <a href="{{ url('/company/booth-booking/services?' . http_build_query(array_filter(['exhibition' => session('company_booth_booking.exhibition_slug')]))) }}" class="inline-flex h-[58px] w-full items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                    Add Services
                    <i class="fa-solid fa-arrow-right text-[15px]"></i>
                </a>
            </div>
        </aside>
    </div>
</section>
@endsection
