@extends('layouts.frontend')

@section('title', ($exhibitionTitle ?? 'Exhibition') . ' — Registered Companies')

@section('content')
@php
    $companyNames = ($booths ?? collect())
        ->map(fn ($booking) => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
        ->filter()
        ->unique(fn ($name) => strtolower(trim((string) $name)))
        ->values();
@endphp
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1100px]">
        <a href="{{ route('exhibitions.index') }}" class="mb-5 inline-flex items-center gap-2 text-[14px] font-semibold text-[#5b2eff] hover:text-[#4310d8]">
            <i class="fa-solid fa-arrow-left"></i> Back to exhibitions
        </a>

        <div class="rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] sm:p-8">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Registered companies</p>
            <h1 class="mt-2 text-[30px] font-bold text-[#071044]">{{ $exhibitionTitle ?? 'Exhibition' }}</h1>
            <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $companyNames->count() }} {{ $companyNames->count() === 1 ? 'company' : 'companies' }} registered for this exhibition.</p>
        </div>

        @if ($companyNames->isEmpty())
            <div class="mt-6 rounded-[16px] border border-[#E7EAF3] bg-white p-10 text-center">
                <p class="text-[18px] font-bold text-[#071044]">No companies registered yet</p>
            </div>
        @else
            <div class="mt-6 overflow-hidden rounded-[16px] border border-[#E7EAF3] bg-white shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                <ul class="divide-y divide-[#E7EAF3]">
                    @foreach ($companyNames as $company)
                        <li class="px-5 py-4 text-[18px] font-bold text-[#071044] sm:px-6">{{ $company }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</section>
@endsection
