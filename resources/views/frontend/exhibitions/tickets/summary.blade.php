@extends('layouts.frontend')

@section('title', 'Ticket Summary - EproExpo')

@section('content')
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1300px]">
        <div class="rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] lg:p-8">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Review pass</p>
            <h1 class="mt-3 text-[34px] font-bold tracking-[-0.03em] text-[#071044]">Visitor pass summary</h1>
            <p class="mt-3 max-w-[680px] text-[15px] font-medium leading-7 text-[#5A6480]">Confirm your visitor information and pass details before making the payment or activating a free pass.</p>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_390px]">
            <div class="space-y-6">
                <section class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.04)]">
                    <h2 class="text-[20px] font-bold text-[#071044]">Exhibition</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-[220px_1fr]">
                        <img src="{{ asset('images/exhibitions/hero-pavilion-scene.png') }}" alt="Global Tech Expo 2026" class="h-[150px] w-full rounded-[12px] object-cover">
                        <div class="min-w-0">
                            <h3 class="text-[22px] font-bold text-[#071044]">Global Tech Expo 2026</h3>
                            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">June 12 - 14, 2026 | Virtual + New Delhi partner venue</p>
                            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                @foreach (['14 halls', '420 booths', '80+ sessions'] as $item)
                                    <div class="rounded-lg bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#34405F]">{{ $item }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <h2 class="text-[20px] font-bold text-[#071044]">Visitor details</h2>
                    <div class="mt-5 grid gap-4 text-[14px] font-medium text-[#34405F] sm:grid-cols-2">
                        @foreach ([['Full name', 'John Doe'], ['Email', 'john@example.com'], ['Phone', '+91 98765 43210'], ['Company', 'Acme Global'], ['Designation', 'Business Manager'], ['Location', 'New Delhi, India']] as [$label, $value])
                            <div class="rounded-[12px] bg-[#FBFAFF] p-4">
                                <span class="block text-[12px] font-bold uppercase tracking-[0.08em] text-[#5A6480]">{{ $label }}</span>
                                <span class="mt-1 block text-[14px] font-bold text-[#071044]">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside class="h-fit rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                <h2 class="text-[20px] font-bold text-[#071044]">Pass summary</h2>
                <div class="mt-5 rounded-[14px] bg-[#F4F0FF] p-5">
                    <p class="text-[14px] font-bold text-[#071044]">Business Pass</p>
                    <p class="mt-2 text-[30px] font-bold text-[#5b2eff]">₹29.00</p>
                    <p class="mt-2 text-[13px] font-medium leading-5 text-[#5A6480]">Includes catalogues, priority enquiries and business card exchange.</p>
                </div>
                <div class="mt-5 space-y-1">
                    @foreach ([['Pass price', '₹29.00'], ['Tax', '₹2.90'], ['Platform fee', '₹0.00'], ['Total', '₹31.90']] as [$label, $value])
                        <div class="flex items-center justify-between border-b border-[#E7EAF3] py-3 last:border-0">
                            <span class="text-[14px] font-medium text-[#5A6480]">{{ $label }}</span>
                            <span class="text-[15px] font-bold text-[#071044]">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('exhibitions.tickets.payment', $slug) }}" class="mt-5 flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.22)]">Proceed to Payment</a>
                <a href="{{ route('exhibitions.tickets.visitor-details', $slug) }}" class="mt-3 flex h-11 items-center justify-center rounded-lg border border-[#E7EAF3] text-[13px] font-bold text-[#34405F]">Edit Details</a>
            </aside>
        </div>
    </div>
</section>
@endsection
