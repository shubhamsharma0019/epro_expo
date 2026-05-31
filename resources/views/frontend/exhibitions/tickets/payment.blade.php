@extends('layouts.frontend')

@section('title', 'Payment - EproExpo')

@section('content')
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto grid max-w-[1200px] gap-6 lg:grid-cols-[1fr_370px]">
        <div class="rounded-[18px] border border-[#E7EAF3] bg-white p-6 shadow-[0_12px_30px_rgba(7,16,68,0.06)] lg:p-8">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Secure checkout</p>
            <h1 class="mt-3 text-[34px] font-bold text-[#071044]">Choose payment method</h1>
            <p class="mt-3 text-[15px] font-medium leading-7 text-[#5A6480]">Your payment is encrypted. Select a method to confirm your exhibition visitor pass.</p>
            <div class="mt-6 grid gap-3 rounded-[14px] bg-[#FBFAFF] p-4 sm:grid-cols-4">
                @foreach ([['1', 'Pass'], ['2', 'Details'], ['3', 'Payment'], ['4', 'QR pass']] as [$step, $label])
                    <div class="flex items-center gap-3">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full {{ $step === '3' ? 'bg-[#5b2eff] text-white' : 'bg-white text-[#5b2eff]' }} text-[13px] font-bold">{{ $step }}</span>
                        <span class="text-[13px] font-bold text-[#34405F]">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2">
                @foreach ([['Credit/Debit Card', 'Visa, Mastercard, Rupay'], ['UPI', 'Pay with any UPI app'], ['Net Banking', 'All major banks'], ['Wallet', 'Fast wallet checkout']] as [$method, $copy])
                    <button type="button" class="group flex min-h-[92px] items-start justify-between rounded-[14px] border border-[#E7EAF3] bg-white p-5 text-left hover:border-[#5b2eff] hover:bg-[#F8F7FF]">
                        <span>
                            <span class="block text-[16px] font-bold text-[#071044]">{{ $method }}</span>
                            <span class="mt-2 block text-[13px] font-medium text-[#5A6480]">{{ $copy }}</span>
                        </span>
                        <span class="mt-1 h-5 w-5 rounded-full border-2 border-[#B9A8F3] group-hover:border-[#5b2eff]"></span>
                    </button>
                @endforeach
            </div>

            <div class="mt-7 rounded-[14px] border border-[#E7EAF3] bg-[#FBFAFF] p-5">
                <h2 class="text-[18px] font-bold text-[#071044]">Card details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <input type="text" placeholder="Card number" class="h-12 rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff] md:col-span-2">
                    <input type="text" placeholder="MM / YY" class="h-12 rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]">
                    <input type="text" placeholder="CVV" class="h-12 rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]">
                </div>
            </div>

            <a href="{{ route('exhibitions.tickets.confirmed', $slug) }}" class="mt-7 inline-flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.22)]">Pay Now</a>
        </div>

        <aside class="h-fit rounded-[18px] border border-[#E7EAF3] bg-white p-6">
            <h2 class="text-[20px] font-bold text-[#071044]">Order</h2>
            <div class="mt-5 rounded-[14px] bg-[#F4F0FF] p-5">
                <p class="text-[14px] font-bold text-[#071044]">Global Tech Expo 2026</p>
                <p class="mt-2 text-[13px] font-medium leading-5 text-[#5A6480]">Business Pass for John Doe</p>
            </div>
            <div class="mt-5 space-y-1">
                @foreach ([['Pass', '₹29.00'], ['Tax', '₹2.90'], ['Total', '₹31.90']] as [$label, $value])
                    <div class="flex justify-between border-b border-[#E7EAF3] py-3 last:border-0">
                        <span class="text-[14px] font-medium text-[#5A6480]">{{ $label }}</span>
                        <span class="text-[15px] font-bold text-[#071044]">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
            <p class="mt-5 rounded-lg bg-[#FBFAFF] p-4 text-[13px] font-medium leading-6 text-[#5A6480]">After payment, your QR visitor pass will be available instantly.</p>
        </aside>
    </div>
</section>
@endsection
