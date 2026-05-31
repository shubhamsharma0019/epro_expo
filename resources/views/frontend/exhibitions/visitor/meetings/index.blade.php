@extends('layouts.frontend')

@section('title', 'My Meetings - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7 rounded-xl border border-borderColor bg-white p-6 shadow-sm lg:p-8">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor schedule</p>
        <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">My Meetings</h1>
        <p class="mt-3 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">Track booked meetings with participating companies and jump back into their booth pages.</p>
    </div>

    <div class="space-y-4">
        @if(isset($meetings) && $meetings->count() > 0)
            @foreach ($meetings as $meeting)
                <article class="flex flex-col gap-4 rounded-xl border border-borderColor bg-white p-5 shadow-sm lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex min-w-0 gap-4">
                        <div class="grid h-14 w-20 shrink-0 place-items-center rounded-lg bg-[#F4F0FF] text-[14px] font-semibold text-purple">
                            {{ $meeting->companyMeeting ? \Carbon\Carbon::parse($meeting->companyMeeting->start_time)->format('h:i A') : 'TBD' }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-[19px] font-semibold text-navy">{{ $meeting->company->name ?? 'Company Name' }}</h2>
                            <p class="mt-1 text-[14px] font-medium text-[#5A6480]">{{ $meeting->companyMeeting->title ?? 'Meeting' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 items-center">
                        <span class="inline-flex h-10 items-center rounded-md px-4 text-[13px] font-semibold 
                            {{ $meeting->status === 'confirmed' ? 'bg-[#EEFDF3] text-[#16A34A]' : ($meeting->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700') }}">
                            {{ ucfirst($meeting->status) }}
                        </span>
                        
                        @if ($meeting->status === 'confirmed' && $meeting->companyMeeting && $meeting->companyMeeting->meeting_link)
                            <a href="{{ $meeting->companyMeeting->meeting_link }}" target="_blank" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-[#2D8CFF] px-4 text-[13px] font-semibold text-white hover:bg-[#1A73E8]">
                                <i class="fa-solid fa-video"></i> Join Zoom
                            </a>
                        @endif

                        <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $meeting->company->slug ?? 'company-slug']) }}" class="inline-flex h-10 items-center justify-center rounded-md border border-borderColor px-4 text-[13px] font-semibold text-purple">Open Booth</a>
                    </div>
                </article>
            @endforeach
        @else
            <!-- Fallback if no real DB data -->
            @foreach ([['10:30 AM', 'TechNova Solutions', 'Product discovery call', 'Confirmed', 'technova-solutions'], ['01:15 PM', 'CloudBridge', 'SaaS migration discussion', 'Pending', 'cloudbridge'], ['04:00 PM', 'GreenLoop Energy', 'Sustainability partnership', 'Confirmed', 'greenloop-energy']] as [$time, $company, $topic, $status, $companySlug])
                <article class="flex flex-col gap-4 rounded-xl border border-borderColor bg-white p-5 shadow-sm lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex min-w-0 gap-4">
                        <div class="grid h-14 w-20 shrink-0 place-items-center rounded-lg bg-[#F4F0FF] text-[14px] font-semibold text-purple">{{ $time }}</div>
                        <div class="min-w-0">
                            <h2 class="text-[19px] font-semibold text-navy">{{ $company }}</h2>
                            <p class="mt-1 text-[14px] font-medium text-[#5A6480]">{{ $topic }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 items-center">
                        <span class="inline-flex h-10 items-center rounded-md {{ $status === 'Confirmed' ? 'bg-[#EEFDF3] text-[#16A34A]' : 'bg-yellow-50 text-yellow-700' }} px-4 text-[13px] font-semibold">{{ $status }}</span>
                        
                        @if ($status === 'Confirmed')
                            <a href="https://zoom.us/j/1234567890" target="_blank" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-[#2D8CFF] px-4 text-[13px] font-semibold text-white hover:bg-[#1A73E8]">
                                <i class="fa-solid fa-video"></i> Join Zoom
                            </a>
                        @endif

                        <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="inline-flex h-10 items-center justify-center rounded-md border border-borderColor px-4 text-[13px] font-semibold text-purple">Open Booth</a>
                    </div>
                </article>
            @endforeach
        @endif
    </div>
</section>
@endsection
