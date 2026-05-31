@extends('layouts.company-flow')

@section('title', 'EproExpo Book Slots')

@section('content')
@php
    $firstSlotGroup = collect($slotGroups)->first();
    $lastSlotGroup = collect($slotGroups)->last();
    $boothPrice = $selectedSize?->price ?? $booth->price ?? 0;
    $amountToPay = (float) $boothPrice + (float) $slotsSubtotal;
    $bookingDaysCount = $bookingDaysCount ?? max($selectedSlots->count(), 1);
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7">
        <h1 class="text-[32px] font-semibold leading-[40px] tracking-[-0.8px] text-navy">
            Book Slots as Booths
        </h1>
    </div>

    <div class="mb-6">
        <h2 class="text-[25px] font-semibold leading-[32px] tracking-[-0.5px] text-navy">
            Select Booth Days (Activate Your Booth)
        </h2>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">
            Choose one or more exhibition days when you want your booth to be active.
            <span class="block text-[14px] text-[#5A6480]">
                {{ optional($hall->pavilion)->title ?? 'Pavilion' }} / {{ $hall->title }} / Booth {{ $booth->booth_number }}
                @if ($selectedSize)
                    / {{ $selectedSize->title }}
                @endif
            </span>
        </p>
    </div>

    <div class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ([
            ['Pavilion', optional($hall->pavilion)->title ?? 'Pavilion', 'fa-layer-group'],
            ['Hall', $hall->title, 'fa-building'],
            ['Booth', 'Booth ' . $booth->booth_number, 'fa-shop'],
            ['Size', $selectedSize ? $selectedSize->title . ' (' . number_format((float) $selectedSize->area, 0) . ' sq.m)' : 'Custom Size', 'fa-vector-square'],
            ['Booth Price', '&#8377;' . number_format((float) $boothPrice), 'fa-indian-rupee-sign'],
        ] as [$label, $value, $icon])
            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm">
                <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-md bg-[#F4F0FF] text-purple">
                    <i class="fa-solid {{ $icon }} text-[14px]"></i>
                </div>
                <p class="text-[13px] font-semibold text-[#5A6480]">{{ $label }}</p>
                <p class="mt-2 break-words text-[15px] font-semibold text-navy">{!! $value !!}</p>
            </div>
        @endforeach
    </div>

    <div class="mb-7 rounded-xl border border-[#DCD3FF] bg-white px-5 py-5 shadow-sm sm:px-6">
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
            <div>
                <h2 class="text-[20px] font-semibold text-navy">Manage Booking Days</h2>
                <p class="mt-2 text-[15px] font-medium leading-6 text-[#34405F]">
                    Increase total booth days here. The system auto-selects that many full days and recalculates payment.
                </p>
                <div class="mt-4 flex flex-wrap gap-3 text-[14px] font-semibold text-[#34405F]">
                    <span class="rounded-md bg-[#F4F0FF] px-3 py-2 text-purple">Per day: &#8377;{{ number_format((float) $slotPrice) }}</span>
                    <span class="rounded-md bg-[#FBFCFF] px-3 py-2">Selected: {{ $selectedSlots->count() }} {{ $selectedSlots->count() === 1 ? 'day' : 'days' }}</span>
                    <span class="rounded-md bg-[#FBFCFF] px-3 py-2">Days amount: &#8377;{{ number_format((float) $slotsSubtotal) }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('company.booth-booking.slots.days') }}" class="grid grid-cols-[130px_minmax(150px,1fr)] gap-3 sm:flex sm:items-end">
                @csrf
                <input type="hidden" name="hall_id" value="{{ $hall->id }}">
                <input type="hidden" name="booth_id" value="{{ $booth->id }}">
                <input type="hidden" name="size_id" value="{{ $selectedSize?->id }}">
                <label>
                    <span class="mb-2 block text-[13px] font-semibold text-[#5A6480]">Total Days</span>
                    <input id="booking-days-count" type="number" name="days_count" min="1" max="60" value="{{ $bookingDaysCount }}" class="h-[54px] w-full rounded-md border border-borderColor px-4 text-[18px] font-semibold text-navy outline-none focus:border-purple">
                </label>
                <button type="submit" class="h-[54px] rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[15px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                    Update Amount
                </button>
            </form>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-5 rounded-lg border border-[#DCD3FF] bg-[#F7F4FF] px-5 py-4 text-[15px] font-semibold text-purple">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-5 py-4 text-[15px] font-semibold text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-5 flex flex-col gap-3 text-[15px] font-semibold text-[#34405F] lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-3">
            <i class="fa-regular fa-calendar-days text-purple"></i>
            <span>
                {{ $firstSlotGroup['label'] ?? 'Select Date' }}
                @if (count($slotGroups) > 1)
                    - {{ $lastSlotGroup['label'] ?? '' }}
                @endif
                ({{ count($slotGroups) }} {{ count($slotGroups) === 1 ? 'Day' : 'Days' }})
            </span>
        </div>
        <div>Every selected day adds &#8377;{{ number_format((float) $slotPrice) }}</div>
    </div>

    <div class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-borderColor bg-[#FBFCFF] text-[16px] font-semibold text-navy">
                        <th class="w-[210px] px-10 py-5">Date</th>
                        @foreach (($firstSlotGroup['slots'] ?? []) as $slot)
                            <th class="px-8 py-5 text-center">Booth Day</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-[16px] font-semibold text-navy">
                    @forelse ($slotGroups as $group)
                        <tr class="border-b border-borderColor last:border-b-0">
                            <td class="px-10 py-5 text-[#34405F]">{{ $group['label'] }}</td>
                            @foreach ($group['slots'] as $slot)
                                @php
                                    $isSelected = in_array($slot['key'], $selectedSlotKeys, true);
                                    $isBooked = in_array($slot['key'], $bookedDayKeys ?? [], true);
                                @endphp
                                <td class="border-l border-borderColor px-8 py-4 text-center">
                                    <form method="POST" action="{{ route('company.booth-booking.slots.select') }}">
                                        @csrf
                                        <input type="hidden" name="hall_id" value="{{ $hall->id }}">
                                        <input type="hidden" name="booth_id" value="{{ $booth->id }}">
                                        <input type="hidden" name="size_id" value="{{ $selectedSize?->id }}">
                                        <input type="hidden" name="slot_key" value="{{ $slot['key'] }}">
                                        <button type="submit" class="{{ $isBooked ? 'inline-flex h-[44px] min-w-[130px] items-center justify-center rounded-md bg-[#E6E8EF] px-6 text-[#6B7280] transition hover:bg-[#D7DBE6]' : ($isSelected ? 'inline-flex h-[44px] min-w-[130px] items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-white' : 'inline-flex h-[44px] min-w-[90px] items-center justify-center rounded-md px-5 text-navy transition hover:bg-[#F4F0FF] hover:text-purple') }}">
                                            @if ($isSelected)
                                                <i class="fa-solid fa-check text-[13px]"></i>
                                            @endif
                                            {!! $isBooked ? 'Booked' : '&#8377;' . number_format((float) $slot['price']) !!}
                                        </button>
                                    </form>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-8 text-center text-[#5A6480]">
                                No days available for this exhibition yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-7 rounded-xl border border-[#DCD3FF] bg-white px-6 py-5 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-2 border-purple text-[18px] font-semibold text-purple">
                    i
                </span>
                <div>
                    <h2 class="text-[20px] font-semibold text-navy">Need Custom Days?</h2>
                    <p class="mt-2 text-[16px] font-medium text-[#34405F]">Request custom days or longer duration.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('company.booth-booking.slots.custom') }}">
                @csrf
                <input type="hidden" name="hall_id" value="{{ $hall->id }}">
                <input type="hidden" name="booth_id" value="{{ $booth->id }}">
                <input type="hidden" name="size_id" value="{{ $selectedSize?->id }}">
                <button type="submit" class="inline-flex h-[58px] min-w-[230px] items-center justify-center rounded-md border border-[#B9A7FF] px-7 text-[16px] font-semibold text-purple">
                    Request Custom Days
                </button>
            </form>
        </div>
    </div>

    <div class="mt-7 rounded-xl border border-borderColor bg-white px-6 py-5 shadow-sm">
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
            <div>
                <h2 class="text-[18px] font-semibold text-navy">Selected Days ({{ $selectedSlots->count() }})</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    @forelse ($selectedSlots as $slot)
                        <span class="rounded-md border border-[#DCD3FF] bg-white px-3 py-2 text-[13px] font-semibold text-navy">
                            {{ $slot['date_label'] ?? $slot['date'] }}
                        </span>
                    @empty
                        <span class="text-[14px] font-semibold text-[#5A6480]">No days selected yet.</span>
                    @endforelse
                </div>
                <div class="mt-4 grid grid-cols-1 gap-4 text-[15px] font-semibold text-[#34405F] sm:grid-cols-3">
                    <div class="rounded-lg bg-[#FBFCFF] px-4 py-3">
                        <p class="text-[13px] text-[#5A6480]">Booth Price</p>
                        <p class="mt-1 text-[20px] text-navy">&#8377;{{ number_format((float) $boothPrice) }}</p>
                    </div>
                    <div class="rounded-lg bg-[#FBFCFF] px-4 py-3">
                        <p class="text-[13px] text-[#5A6480]">Days Amount</p>
                        <p class="mt-1 text-[20px] text-navy">&#8377;{{ number_format((float) $slotsSubtotal) }}</p>
                    </div>
                    <div class="rounded-lg bg-[#F4F0FF] px-4 py-3">
                        <p class="text-[13px] text-purple">Amount to Pay</p>
                        <p class="mt-1 text-[24px] text-navy">&#8377;{{ number_format($amountToPay) }}</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('company.booth-booking.slots.continue') }}">
                @csrf
                <input type="hidden" name="hall_id" value="{{ $hall->id }}">
                <input type="hidden" name="booth_id" value="{{ $booth->id }}">
                <input type="hidden" name="size_id" value="{{ $selectedSize?->id }}">
                <input id="continue-days-count" type="hidden" name="days_count" value="{{ $bookingDaysCount }}">
                <button type="submit"
                    class="inline-flex h-[58px] w-full items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)] disabled:cursor-not-allowed disabled:opacity-60 lg:min-w-[220px]"
                >
                    Continue
                    <i class="fa-solid fa-arrow-right text-[15px]"></i>
                </button>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (() => {
        const daysInput = document.getElementById('booking-days-count');
        const continueDaysInput = document.getElementById('continue-days-count');

        if (!daysInput || !continueDaysInput) {
            return;
        }

        const syncDays = () => {
            continueDaysInput.value = daysInput.value || '1';
        };

        daysInput.addEventListener('input', syncDays);
        daysInput.addEventListener('change', syncDays);
        syncDays();
    })();
</script>
@endpush

@endsection
