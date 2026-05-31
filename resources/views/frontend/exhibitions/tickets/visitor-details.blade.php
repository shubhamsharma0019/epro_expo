@extends('layouts.frontend')

@section('title', 'Visitor Details - EproExpo')

@section('content')
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto grid max-w-[1200px] gap-6 lg:grid-cols-[1fr_360px]">
        <div class="rounded-[18px] border border-[#E7EAF3] bg-white p-6 shadow-[0_10px_26px_rgba(7,16,68,0.06)] lg:p-8">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Visitor profile</p>
            <h1 class="mt-3 text-[32px] font-bold text-[#071044]">Add visitor details</h1>
            <p class="mt-2 text-[14px] font-medium text-[#5A6480]">These details will appear on the QR visitor pass and help exhibitors respond to your meeting requests.</p>
            <form class="mt-7 grid gap-5 md:grid-cols-2">
                @foreach (['Full Name', 'Email', 'Phone', 'Company Name', 'Designation', 'City', 'Country'] as $field)
                    <label class="block min-w-0 {{ $field === 'Country' ? 'md:col-span-2' : '' }}">
                        <span class="text-[13px] font-bold text-[#34405F]">{{ $field }}</span>
                        <input type="text" class="mt-2 h-12 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" placeholder="{{ $field }}">
                    </label>
                @endforeach
                <div class="md:col-span-2">
                    <a href="{{ route('exhibitions.tickets.summary', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[14px] font-bold text-white">Continue to Summary</a>
                </div>
            </form>
        </div>
        <aside class="rounded-[18px] border border-[#E7EAF3] bg-white p-6">
            <h2 class="text-[20px] font-bold text-[#071044]">Selected pass</h2>
            <div class="mt-5 rounded-[14px] bg-[#F4F0FF] p-5">
                <p class="text-[15px] font-bold text-[#071044]">Business Pass</p>
                <p class="mt-2 text-[28px] font-bold text-[#5b2eff]">₹29</p>
                <p class="mt-3 text-[13px] font-medium leading-6 text-[#5A6480]">Catalogues, priority enquiries, and business card exchange included.</p>
            </div>
            <div class="mt-5 space-y-3">
                @foreach (['Pass confirmed instantly', 'QR code entry', 'Access to lobby, companies and booths'] as $item)
                    <div class="rounded-lg border border-[#E7EAF3] p-3 text-[13px] font-bold text-[#34405F]">{{ $item }}</div>
                @endforeach
            </div>
        </aside>
    </div>
</section>
@endsection
