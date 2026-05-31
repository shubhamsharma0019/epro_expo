@extends('layouts.frontend')

@section('title', 'Saved Booths - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7 rounded-xl border border-borderColor bg-white p-6 shadow-sm lg:p-8">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor workspace</p>
        <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">Saved Booths</h1>
        <p class="mt-3 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">Your shortlisted companies, product demos, brochures and meeting notes in one place.</p>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        @foreach ([['technova-solutions', 'TechNova Solutions', 'Hall A / A12', 'AI demo, analytics brochure, meeting follow-up'], ['greenloop-energy', 'GreenLoop Energy', 'Hall B / B04', 'Clean energy catalogue and product launch'], ['mednext', 'MedNext Systems', 'Hall C / C09', 'Healthcare workflow demo and session reminder']] as [$companySlug, $company, $location, $note])
            <article class="rounded-xl border border-borderColor bg-white p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="grid h-14 w-14 shrink-0 place-items-center rounded-xl bg-[#F4F0FF] text-[20px] font-semibold text-purple">{{ substr($company, 0, 1) }}</div>
                    <div>
                        <h2 class="text-[20px] font-semibold text-navy">{{ $company }}</h2>
                        <p class="mt-1 text-[13px] font-semibold text-purple">{{ $location }}</p>
                    </div>
                </div>
                <p class="mt-5 min-h-[54px] text-[14px] font-medium leading-6 text-[#5A6480]">{{ $note }}</p>
                <div class="mt-5 flex gap-3">
                    <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="inline-flex h-11 flex-1 items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-4 text-[13px] font-semibold text-white">Open Booth</a>
                    <a href="{{ route('exhibitions.visitor.meetings', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-md border border-borderColor px-4 text-[13px] font-semibold text-purple">Meeting</a>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
