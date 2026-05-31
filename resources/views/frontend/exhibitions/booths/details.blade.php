@extends('layouts.exhibition')

@section('title', 'EproExpo Book Slots')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="mb-10 flex items-center gap-5 overflow-x-auto pb-1 text-[15px] font-medium text-[#34405F]">
        <a href="{{ url('/exhibitions/pavilions/innovation-pavilion') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[12px]"></i>
            </span>
            <span>Pavilion</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/halls/hall-1') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[12px]"></i>
            </span>
            <span>Hall</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/booths/sizes') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[12px]"></i>
            </span>
            <span>Booth Size</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/booking/services') }}" class="flex shrink-0 items-center gap-3 rounded-full bg-[#F4F0FF] px-4 py-2 text-purple">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-semibold text-white">4</span>
            <span class="font-semibold">Services</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/booking/review') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#8FA0C7] bg-white text-[14px] font-semibold text-navy">5</span>
            <span>Review</span>
        </a>
    </div>

    <div class="mb-7">
        <h1 class="text-[32px] font-semibold leading-[40px] tracking-[-0.8px] text-navy">
            Book Slots as Booths
        </h1>
    </div>

    <!-- Booth Layout Plan for Context -->
    <div class="mb-10 rounded-xl border border-borderColor bg-[#FBFCFF] p-6 shadow-sm">
        <h3 class="mb-4 text-[20px] font-semibold text-navy">Booth Placement Reference</h3>
        <div class="overflow-hidden rounded-xl border border-borderColor bg-white">
            @include('frontend.exhibitions.booths.partials.floor-diagram', ['hideDetailsPanel' => true])
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-[25px] font-semibold leading-[32px] tracking-[-0.5px] text-navy">
            Select Time Slots (Activate Your Booth)
        </h2>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">
            Choose one or more time slots when you want your booth to be active.
        </p>
    </div>

    <div class="mb-5 flex flex-col gap-3 text-[15px] font-semibold text-[#34405F] lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-3">
            <i class="fa-regular fa-calendar-days text-purple"></i>
            <span>May 11 &ndash; May 13, 2024 (3 Days)</span>
        </div>
        <div>Time Zone: (GMT +05:30) Asia/Kolkata</div>
    </div>

    <div class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-borderColor bg-[#FBFCFF] text-[16px] font-semibold text-navy">
                        <th class="w-[210px] px-10 py-5">Date</th>
                        <th class="px-8 py-5 text-center">9 AM - 12 PM</th>
                        <th class="px-8 py-5 text-center">12 PM - 3 PM</th>
                        <th class="px-8 py-5 text-center">3 PM - 6 PM</th>
                        <th class="px-8 py-5 text-center">6 PM - 9 PM</th>
                    </tr>
                </thead>
                <tbody class="text-[16px] font-semibold text-navy">
                    @foreach ([
                        'May 11, Sat',
                        'May 12, Sun',
                        'May 13, Mon',
                        'May 14, Tue',
                        'May 15, Wed',
                    ] as $date)
                        <tr class="border-b border-borderColor last:border-b-0">
                            <td class="px-10 py-5 text-[#34405F]">{{ $date }}</td>
                            <td class="border-l border-borderColor px-8 py-4 text-center">₹99</td>
                            <td class="border-l border-borderColor px-8 py-4 text-center">
                                @if ($loop->first)
                                    <button type="button" class="inline-flex h-[44px] min-w-[130px] items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-white">
                                        <i class="fa-solid fa-check text-[13px]"></i>
                                        ₹99
                                    </button>
                                @else
                                    ₹99
                                @endif
                            </td>
                            <td class="border-l border-borderColor px-8 py-4 text-center">₹99</td>
                            <td class="border-l border-borderColor px-8 py-4 text-center">₹99</td>
                        </tr>
                    @endforeach
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
                    <h2 class="text-[20px] font-semibold text-navy">Need Custom Slots?</h2>
                    <p class="mt-2 text-[16px] font-medium text-[#34405F]">
                        Request custom time slot or longer duration.
                    </p>
                </div>
            </div>

            <button type="button" class="inline-flex h-[58px] min-w-[230px] items-center justify-center rounded-md border border-[#B9A7FF] px-7 text-[16px] font-semibold text-purple">
                Request Custom Slot
            </button>
        </div>
    </div>

    <div class="mt-7 rounded-xl border border-borderColor bg-white px-6 py-5 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <h2 class="text-[18px] font-semibold text-navy">
                Selected Slots (1)
            </h2>

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <div class="flex items-center gap-5">
                    <span class="text-[16px] font-semibold text-[#34405F]">Sub Total:</span>
                    <span class="text-[30px] font-semibold leading-none text-navy">₹99</span>
                </div>

                <a href="{{ url('/exhibitions/booking/summary') }}"
                    class="inline-flex h-[58px] min-w-[220px] items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                    Continue
                    <i class="fa-solid fa-arrow-right text-[15px]"></i>
                </a>
            </div>
        </div>
    </div>

</section>

@endsection
