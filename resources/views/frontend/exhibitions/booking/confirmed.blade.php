@extends('layouts.exhibition')

@section('title', 'EproExpo Booking Confirmed')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="rounded-xl border border-borderColor bg-white px-6 py-7 shadow-sm sm:px-8">
        <h1 class="mb-6 text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">
            Booking Confirmed
        </h1>

        <div class="mb-8 flex items-center justify-between gap-8 overflow-x-auto rounded-xl border border-borderColor bg-white px-6 py-5 text-[16px] font-medium text-[#34405F]">
            @foreach ([
                'Pavilions',
                'Halls',
                'Booth',
                'Booth Size',
                'Services',
                'Payment',
            ] as $label)
                <div class="flex shrink-0 items-center gap-4">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                        <i class="fa-solid fa-check text-[12px]"></i>
                    </span>
                    <span>{{ $label }}</span>
                </div>
            @endforeach

            <div class="flex shrink-0 items-center gap-4 text-purple">
                <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-purple bg-white text-[15px] font-semibold text-purple">6</span>
                <span class="font-semibold">Confirmed</span>
            </div>
        </div>

        <div class="rounded-xl border border-borderColor bg-white px-6 py-10 text-center shadow-sm">
            <div class="relative mx-auto mb-7 h-[82px] max-w-[560px]">
                @foreach ([
                    ['left-[8%]', 'top-[28px]', 'bg-[#33C78A]'],
                    ['left-[18%]', 'top-[55px]', 'bg-[#5AB9F7]'],
                    ['left-[28%]', 'top-[10px]', 'bg-[#FF8FA3]'],
                    ['left-[38%]', 'top-[40px]', 'bg-[#41CFA2]'],
                    ['left-[48%]', 'top-[8px]', 'bg-[#4299E1]'],
                    ['right-[34%]', 'top-[10px]', 'bg-[#F59E0B]'],
                    ['right-[25%]', 'top-[42px]', 'bg-[#7C5CE6]'],
                    ['right-[15%]', 'top-[24px]', 'bg-[#38BDF8]'],
                    ['right-[6%]', 'top-[12px]', 'bg-[#F87171]'],
                ] as [$x, $y, $color])
                    <span class="absolute {{ $x }} {{ $y }} h-2.5 w-2.5 rotate-45 rounded-sm {{ $color }}"></span>
                @endforeach

                <div class="absolute left-1/2 top-6 flex h-[70px] w-[70px] -translate-x-1/2 items-center justify-center rounded-full bg-gradient-to-br from-[#34C36B] to-[#14924A] text-white shadow-sm">
                    <i class="fa-solid fa-check text-[30px]"></i>
                </div>
            </div>

            <h2 class="text-[40px] font-semibold leading-[48px] tracking-[-0.9px] text-navy">
                Booking Confirmed!
            </h2>
            <p class="mt-4 text-[22px] leading-8 text-[#5A6480]">
                Your booth has been successfully booked.
            </p>

            <div class="mx-auto mt-8 max-w-[460px]">
                <p class="mb-4 text-[18px] font-semibold text-[#34405F]">Booking ID</p>
                <div class="rounded-lg border border-borderColor bg-[#FBFCFF] px-6 py-5 text-[30px] font-semibold leading-none text-purple">
                    EXPO2024-INV-12A-001
                </div>
            </div>
        </div>

        <div class="-mt-px mx-auto max-w-[1380px] rounded-xl border border-borderColor bg-white px-6 py-8 shadow-sm">
            <div class="grid grid-cols-1 gap-8 text-center sm:grid-cols-2 lg:grid-cols-5">
                <div class="lg:border-r lg:border-borderColor">
                    <i class="fa-regular fa-building mb-4 text-[36px] text-purple"></i>
                    <h3 class="mb-3 text-[16px] font-semibold text-navy">Pavilion</h3>
                    <p class="text-[16px] text-[#34405F]">Innovation Pavilion</p>
                </div>
                <div class="lg:border-r lg:border-borderColor">
                    <i class="fa-solid fa-torii-gate mb-4 text-[36px] text-purple"></i>
                    <h3 class="mb-3 text-[16px] font-semibold text-navy">Hall</h3>
                    <p class="text-[16px] text-[#34405F]">Hall 1 - Tech &amp; Innovation</p>
                </div>
                <div class="lg:border-r lg:border-borderColor">
                    <i class="fa-solid fa-shop mb-4 text-[36px] text-purple"></i>
                    <h3 class="mb-3 text-[16px] font-semibold text-navy">Booth</h3>
                    <p class="text-[16px] text-[#34405F]">Booth 12A (10m &times; 3m)</p>
                </div>
                <div class="lg:border-r lg:border-borderColor">
                    <i class="fa-regular fa-calendar-days mb-4 text-[36px] text-purple"></i>
                    <h3 class="mb-3 text-[16px] font-semibold text-navy">Dates</h3>
                    <p class="text-[16px] text-[#34405F]">May 16 &ndash; May 19, 2024</p>
                </div>
                <div>
                    <i class="fa-regular fa-clock mb-4 text-[36px] text-purple"></i>
                    <h3 class="mb-3 text-[16px] font-semibold text-navy">Time Slot</h3>
                    <p class="text-[16px] text-[#34405F]">May 16, 11 AM - 12 PM</p>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-0 xl:grid-cols-[minmax(0,1.7fr)_minmax(360px,1fr)]">
            <div class="rounded-t-xl xl:rounded-l-xl xl:rounded-tr-none border border-borderColor bg-white p-5 shadow-sm">
                <div class="rounded-xl border border-borderColor bg-[#FBFCFF] p-6">
                    <div class="flex gap-5">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#F4F0FF] text-[26px] font-semibold text-purple">
                            i
                        </span>
                        <div>
                            <h2 class="text-[20px] font-semibold text-navy">What&rsquo;s Next?</h2>
                            <p class="mt-2 text-[16px] leading-6 text-[#34405F]">
                                A confirmation email has been sent to johndoe@email.com
                            </p>
                            <p class="mt-1 text-[16px] leading-6 text-[#34405F]">
                                You can view your booking details and download invoice from your dashboard.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">
                    <a href="{{ url('/exhibitions/booking/my-bookings') }}"
                        class="inline-flex h-[62px] items-center justify-center gap-4 rounded-md border border-purple px-6 text-[20px] font-semibold text-purple">
                        <i class="fa-regular fa-clipboard text-[24px]"></i>
                        View Booking Details
                    </a>
                    <a href="{{ url('/exhibitions/dashboard') }}"
                        class="inline-flex h-[62px] items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[20px] font-semibold text-white">
                        <i class="fa-solid fa-table-cells-large text-[24px]"></i>
                        Go to Dashboard
                    </a>
                </div>
            </div>

            <div class="rounded-b-xl xl:rounded-r-xl xl:rounded-bl-none border xl:border-l-0 border-borderColor bg-white p-5 shadow-sm">
                <div class="h-full rounded-xl border border-[#DCEFE6] bg-[#F6FFFA] p-6">
                    <div class="flex gap-5">
                        <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full border border-[#BFE8CF] bg-[#EAF9F0] text-[#16A34A]">
                            <i class="fa-solid fa-envelope text-[32px]"></i>
                        </span>
                        <div>
                            <h2 class="text-[22px] font-semibold text-[#16A34A]">Confirmation Email Sent!</h2>
                            <p class="mt-5 text-[16px] leading-7 text-[#34405F]">
                                We&rsquo;ve sent all the details to
                            </p>
                            <p class="mt-1 text-[16px] font-semibold text-navy">johndoe@email.com</p>
                            <p class="mt-5 text-[16px] leading-7 text-[#34405F]">
                                Please check your inbox (and spam folder) if you don&rsquo;t see it.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
