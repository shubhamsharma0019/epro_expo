@extends('layouts.exhibition')

@section('title', 'EproExpo Payment')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="rounded-xl border border-borderColor bg-white px-6 py-7 shadow-sm sm:px-8">
        <h1 class="mb-6 text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">
            Payment
        </h1>

        <div class="mb-8 flex items-center justify-between gap-8 overflow-x-auto rounded-xl border border-borderColor bg-white px-6 py-5 text-[16px] font-medium text-[#34405F]">
            @foreach ([
                'Pavilions',
                'Halls',
                'Booth',
                'Booth Size',
                'Services',
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
                <span class="font-semibold">Payment</span>
            </div>
        </div>

        <p class="mb-8 text-[22px] leading-8 text-[#5A6480]">
            Choose a payment method and complete your booking.
        </p>

        <div class="grid grid-cols-1 gap-5 min-[1500px]:grid-cols-[minmax(0,1fr)_390px]">
            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
                <h2 class="mb-8 text-[25px] font-semibold text-navy">Payment Details</h2>

                <div class="grid grid-cols-1 gap-8 2xl:grid-cols-[minmax(0,1fr)_260px]">
                    <div>
                        <p class="mb-5 text-[16px] font-medium text-navy">Payment Method</p>

                        <div class="mb-8 grid grid-cols-2 gap-2 min-[1180px]:grid-cols-4 min-[1180px]:gap-0">
                            <button type="button" class="flex h-[62px] items-center justify-center gap-2 rounded-md min-[1180px]:rounded-r-none min-[1180px]:rounded-l-md border border-purple text-[15px] font-semibold text-purple">
                                <i class="fa-regular fa-credit-card text-[22px]"></i>
                                Card
                            </button>
                            <button type="button" class="flex h-[62px] items-center justify-center gap-2 rounded-md min-[1180px]:rounded-none border border-borderColor min-[1180px]:border-y min-[1180px]:border-r text-[15px] font-semibold text-navy">
                                <i class="fa-brands fa-google-play text-[22px] text-[#8A90A8]"></i>
                                UPI
                            </button>
                            <button type="button" class="flex h-[62px] items-center justify-center gap-2 rounded-md min-[1180px]:rounded-none border border-borderColor min-[1180px]:border-y min-[1180px]:border-r text-[15px] font-semibold text-navy">
                                <i class="fa-solid fa-building-columns text-[20px] text-[#8A90A8]"></i>
                                Net Banking
                            </button>
                            <button type="button" class="flex h-[62px] items-center justify-center gap-2 rounded-md min-[1180px]:rounded-l-none min-[1180px]:rounded-r-md border border-borderColor min-[1180px]:border-y min-[1180px]:border-r text-[15px] font-semibold text-navy">
                                <i class="fa-regular fa-wallet text-[22px] text-[#8A90A8]"></i>
                                Wallet
                            </button>
                        </div>

                        <label class="mb-8 block">
                            <span class="mb-3 block text-[16px] font-medium text-navy">Card Number</span>
                            <div class="flex h-[60px] items-center rounded-md border border-borderColor px-5">
                                <input type="text" value="4242 4242 4242 4242" class="min-w-0 flex-1 bg-transparent text-[20px] text-[#8A90A8] outline-none">
                                <span class="ml-4 flex shrink-0 items-center gap-1 text-[13px] font-black">
                                    <span class="rounded bg-white px-1 text-[#1A33D1] shadow-sm">VISA</span>
                                    <span class="h-6 w-9 rounded bg-gradient-to-r from-[#EB001B] to-[#F79E1B]"></span>
                                    <span class="rounded bg-[#006FCF] px-1 text-white">AMEX</span>
                                </span>
                            </div>
                        </label>

                        <div class="mb-8 grid grid-cols-1 gap-8 sm:grid-cols-2">
                            <label>
                                <span class="mb-3 block text-[16px] font-medium text-navy">Card Holder Name</span>
                                <input type="text" value="John Doe" class="h-[60px] w-full rounded-md border border-borderColor px-5 text-[18px] text-[#8A90A8] outline-none">
                            </label>

                            <label>
                                <span class="mb-3 block text-[16px] font-medium text-navy">Expiry Date</span>
                                <input type="text" placeholder="MM / YY" class="h-[60px] w-full rounded-md border border-borderColor px-5 text-[18px] text-[#8A90A8] outline-none">
                            </label>
                        </div>

                        <div class="grid grid-cols-1 gap-5 min-[1180px]:grid-cols-[260px_minmax(0,1fr)] min-[1180px]:items-end">
                            <label>
                                <span class="mb-3 block text-[16px] font-medium text-navy">CVV</span>
                                <div class="flex h-[60px] items-center rounded-md border border-borderColor px-5">
                                    <input type="text" value="123" class="min-w-0 flex-1 bg-transparent text-[18px] text-[#8A90A8] outline-none">
                                    <i class="fa-regular fa-circle-question text-[22px] text-[#8A90A8]"></i>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 pb-4 text-[15px] font-medium text-navy">
                                <input type="checkbox" checked class="h-6 w-6 rounded border-[#8FA0C7] text-purple">
                                Save card for future payments
                            </label>
                        </div>
                    </div>

                    <div class="rounded-xl border border-borderColor bg-[#FBFCFF] p-6 text-center">
                        <div class="mt-3 flex justify-center text-[#22B66E] 2xl:mt-8">
                            <i class="fa-solid fa-lock text-[54px]"></i>
                        </div>

                        <h3 class="mt-6 text-[20px] font-semibold text-navy 2xl:mt-9">Secure Payment</h3>
                        <p class="mt-5 text-[16px] leading-8 text-[#5A6480]">
                            Your payment information is secure and protected with 256-bit SSL encryption.
                        </p>

                        <div class="my-8 border-t border-borderColor"></div>

                        <div class="flex flex-wrap items-center justify-center gap-4">
                            <span class="rounded bg-[#EAF9F0] px-2 py-1 text-[16px] font-black text-[#4B8D89]">PCI</span>
                            <span class="rounded-full border border-[#78D59A] px-3 py-2 text-[14px] font-semibold text-[#16A34A]">
                                <i class="fa-solid fa-lock mr-1"></i> SSL
                            </span>
                            <span class="rounded-full border border-[#78D59A] px-3 py-2 text-[14px] font-semibold text-[#16A34A]">Secure</span>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm min-[1500px]:p-7">
                <div class="mb-8 flex items-center justify-between gap-5">
                    <h2 class="text-[24px] font-semibold text-navy">Booking Summary</h2>
                    <a href="{{ url('/exhibitions/booking/review') }}" class="text-[16px] font-semibold text-purple">Edit</a>
                </div>

                <div class="space-y-5 text-[15px] text-navy min-[1500px]:text-[16px]">
                    <div class="flex items-center justify-between gap-5"><span>Pavilion</span><span class="text-right">Innovation Pavilion</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Hall</span><span class="text-right">Hall 1 - Tech &amp; Innovation</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Booth</span><span class="text-right">Booth 12A (10m &times; 3m)</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Duration</span><span class="text-right">May 16 &ndash; May 19, 2024 (4 Days)</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Time Slots</span><span class="text-right">May 16, 11 AM - 12 PM</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Services</span><span class="text-right">Featured Listing</span></div>
                </div>

                <div class="my-7 border-t border-borderColor"></div>

                <div class="space-y-5 text-[16px] text-[#34405F]">
                    <div class="flex items-center justify-between gap-5"><span>Booth Price</span><span class="font-semibold text-navy">₹499</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Service Price</span><span class="font-semibold text-navy">₹99</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Slot Price</span><span class="font-semibold text-navy">₹59</span></div>
                    <div class="flex items-center justify-between gap-5"><span>Tax (10%)</span><span class="font-semibold text-navy">₹59.80</span></div>
                </div>

                <div class="my-7 border-t border-borderColor"></div>

                <div class="flex items-center justify-between gap-5">
                    <span class="text-[18px] font-semibold text-navy">Amount to Pay</span>
                    <span class="text-[30px] font-semibold leading-none text-navy">₹657.80</span>
                </div>
            </aside>
        </div>

        <div class="mt-8 rounded-xl border border-borderColor bg-white px-8 py-6 shadow-sm">
                <div class="flex flex-col gap-5 min-[1180px]:flex-row min-[1180px]:items-center min-[1180px]:justify-between">
                <div class="flex items-center justify-between gap-8 min-[1180px]:justify-start min-[1180px]:gap-12">
                    <h2 class="text-[20px] font-semibold text-navy">Amount to Pay</h2>
                    <span class="text-[30px] font-semibold leading-none text-navy">₹657.80</span>
                </div>

                <a href="{{ url('/exhibitions/booking/confirmed') }}"
                    class="inline-flex h-[62px] w-full items-center justify-center gap-5 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[20px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)] min-[1180px]:w-auto min-[1180px]:min-w-[340px]">
                    <i class="fa-solid fa-lock text-[18px]"></i>
                    Pay Securely
                </a>
            </div>
        </div>
    </div>

</section>

@endsection
