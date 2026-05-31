@extends('layouts.frontend')

@section('title', 'Visitor Halls - EproExpo')

@section('content')
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <div class="rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] lg:p-8">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Exhibition map</p>
            <h1 class="mt-3 text-[34px] font-bold text-[#071044]">Exhibition halls</h1>
            <p class="mt-3 max-w-[720px] text-[15px] font-medium leading-7 text-[#5A6480]">Each hall contains exhibitor booths, product demos, downloadable documents and live activity.</p>
        </div>

        <div class="mt-7 grid gap-5 md:grid-cols-3">
            @foreach ([['hall-1', 'Tech & Innovation Hall', 'Live product demos and startup showcases.', '96 booths'], ['hall-2', 'Business Solutions Hall', 'B2B services, SaaS and enterprise tools.', '74 booths'], ['hall-3', 'Conference Hall', 'Talks, panels and live sessions.', '28 sessions']] as [$hallSlug, $title, $copy, $meta])
                <article class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                    <div class="grid h-14 w-14 place-items-center rounded-xl bg-[#F4F0FF] text-[18px] font-bold text-[#5b2eff]">{{ strtoupper(substr($title, 0, 1)) }}</div>
                    <h2 class="mt-5 text-[20px] font-bold text-[#071044]">{{ $title }}</h2>
                    <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $copy }}</p>
                    <p class="mt-4 rounded-lg bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#34405F]">{{ $meta }}</p>
                    <a href="{{ route('exhibitions.visitor-halls.show', [$slug, $hallSlug]) }}" class="mt-5 inline-flex h-10 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-4 text-[13px] font-bold text-white">View Hall</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
