@extends('layouts.frontend')

@section('title', 'Select Exhibition Ticket - EproExpo')

@section('content')
@php
    $tickets = [
        ['name' => 'Visitor Pass', 'price' => 'Free', 'tag' => 'For quick discovery', 'benefits' => ['Lobby access', 'Companies and halls', 'Public booth visits', 'Live session reminders']],
        ['name' => 'Business Pass', 'price' => '₹29', 'tag' => 'Most popular', 'benefits' => ['Everything in Visitor', 'Download catalogues', 'Send priority enquiries', 'Business card exchange']],
        ['name' => 'VIP Pass', 'price' => '₹99', 'tag' => 'For serious buyers', 'benefits' => ['Everything in Business', 'Conference access', 'VIP networking queue', 'Priority booth meetings']],
    ];
@endphp

<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1300px]">
        <div class="rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] lg:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="min-w-0">
                    <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Ticket selection</p>
                    <h1 class="mt-3 text-[34px] font-bold tracking-[-0.03em] text-[#071044]">Choose your visitor pass</h1>
                    <p class="mt-3 max-w-[680px] text-[15px] font-medium leading-7 text-[#5A6480]">Pick a pass based on how deeply you want to explore booths, download resources, and connect with exhibitors.</p>
                </div>
                <div class="rounded-[12px] bg-[#F4F0FF] px-4 py-3 text-[13px] font-bold text-[#5b2eff]">Global Tech Expo 2026</div>
            </div>
            <div class="mt-6 grid gap-3 rounded-[14px] bg-[#FBFAFF] p-4 sm:grid-cols-4">
                @foreach ([['1', 'Select pass'], ['2', 'Visitor details'], ['3', 'Payment'], ['4', 'QR entry']] as [$step, $label])
                    <div class="flex items-center gap-3">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full {{ $step === '1' ? 'bg-[#5b2eff] text-white' : 'bg-white text-[#5b2eff]' }} text-[13px] font-bold">{{ $step }}</span>
                        <span class="text-[13px] font-bold text-[#34405F]">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-7 grid gap-5 md:grid-cols-3">
                @foreach ($tickets as $ticket)
                    <article class="flex min-w-0 flex-col rounded-[16px] border {{ $ticket['name'] === 'Business Pass' ? 'border-[#5b2eff] shadow-[0_14px_30px_rgba(91,46,255,0.12)]' : 'border-[#E7EAF3]' }} bg-white p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-[20px] font-bold text-[#071044]">{{ $ticket['name'] }}</h2>
                                <p class="mt-1 text-[13px] font-bold text-[#5b2eff]">{{ $ticket['tag'] }}</p>
                            </div>
                            <span class="rounded-full bg-[#F4F0FF] px-3 py-1 text-[12px] font-bold text-[#5b2eff]">{{ $ticket['price'] }}</span>
                        </div>
                        <p class="mt-5 text-[34px] font-bold text-[#071044]">{{ $ticket['price'] }}</p>
                        <ul class="mt-5 flex-1 space-y-3 text-[14px] font-medium text-[#5A6480]">
                            @foreach ($ticket['benefits'] as $benefit)
                                <li class="flex gap-3"><span class="text-[#5b2eff]">✓</span><span>{{ $benefit }}</span></li>
                            @endforeach
                        </ul>
                        <a href="{{ route('exhibitions.tickets.visitor-details', $slug) }}" class="mt-6 inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-bold text-white">Select Pass</a>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
