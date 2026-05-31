@extends('layouts.frontend')

@section('title', 'Live Chat - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
    $company = str($companySlug ?? 'technova-solutions')->replace('-', ' ')->title();
@endphp

<section class="max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="grid overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm lg:grid-cols-[330px_minmax(0,1fr)]">
        <aside class="border-b border-borderColor bg-[#FBFAFF] p-6 lg:border-b-0 lg:border-r">
            <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Live chat</p>
            <h1 class="mt-3 text-[28px] font-semibold tracking-[-0.6px] text-navy">{{ $company }}</h1>
            <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">Ask about products, demos, brochures and meeting availability.</p>
            <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="mt-6 inline-flex h-11 items-center justify-center rounded-md border border-borderColor bg-white px-5 text-[13px] font-semibold text-purple">Open Booth</a>
        </aside>

        <div class="p-6">
            <div class="space-y-4">
                <div class="max-w-[76%] rounded-xl bg-[#F4F0FF] p-4 text-[14px] font-medium leading-6 text-navy">Hi, I want to know more about your demo schedule.</div>
                <div class="ml-auto max-w-[76%] rounded-xl bg-[#5b2eff] p-4 text-[14px] font-medium leading-6 text-white">Sure. We have live demos at 2 PM and 5 PM today.</div>
                <div class="max-w-[76%] rounded-xl bg-[#F4F0FF] p-4 text-[14px] font-medium leading-6 text-navy">Can I book a short meeting after the demo?</div>
            </div>
            <div class="mt-6 flex gap-3">
                <input type="text" placeholder="Type your message..." class="h-12 min-w-0 flex-1 rounded-md border border-borderColor px-4 text-[14px] font-medium outline-none focus:border-purple">
                <button class="h-12 rounded-md bg-[#5b2eff] px-6 text-[14px] font-semibold text-white">Send</button>
            </div>
        </div>
    </div>
</section>
@endsection
