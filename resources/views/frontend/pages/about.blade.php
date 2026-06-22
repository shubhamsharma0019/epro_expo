@extends('frontend.pages.layout', [
    'pageTitle' => 'About Us',
    'activeNav' => 'about',
])

@php
    $stats = \App\Support\WebsiteContent::defaultStats();
    $partners = \App\Support\WebsiteContent::sectionOrDefaults('home', 'partner', \App\Support\WebsiteContent::defaultPartners());
    $values = [
        ['icon' => 'fas fa-bullseye', 'color' => '#6D28D9', 'title' => 'Our Mission', 'body' => 'To connect people, companies, and communities through seamless virtual events and exhibitions that feel as engaging as in-person experiences.'],
        ['icon' => 'fas fa-eye', 'color' => '#FF9B41', 'title' => 'Our Vision', 'body' => 'A world where every event — big or small — has the tools to reach global audiences, generate meaningful leads, and create lasting impact.'],
        ['icon' => 'fas fa-heart', 'color' => '#48C4AE', 'title' => 'Our Values', 'body' => 'Innovation, accessibility, trust, and customer success drive everything we build — from ticketing to booth engagement.'],
    ];
    $milestones = [
        ['year' => '2020', 'title' => 'Platform Launch', 'body' => 'eproexpo launched with a vision to democratize event hosting for organizers of all sizes.'],
        ['year' => '2022', 'title' => 'Virtual Exhibitions', 'body' => 'Introduced pavilions, halls, and interactive booths for global exhibition experiences.'],
        ['year' => '2024', 'title' => 'Global Growth', 'body' => 'Expanded to serve organizers, exhibitors, and visitors across multiple countries and industries.'],
        ['year' => '2026', 'title' => 'All-in-One Platform', 'body' => 'Unified events, exhibitions, ticketing, networking, and analytics into one connected ecosystem.'],
    ];
@endphp

@section('content')
    <section class="relative overflow-hidden rounded-[20px] border border-[#E7EAF3] bg-white px-5 py-10 shadow-[0_16px_38px_rgba(31,42,106,0.08)] sm:px-8 sm:py-12 lg:px-12">
        <div class="grid items-center gap-8 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="max-w-[760px]">
                <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">About EproExpo</p>
                <h1 class="mt-3 text-[34px] font-black leading-[1.05] tracking-[-0.04em] text-[#071044] sm:text-[48px] lg:text-[56px]">
                    Connecting the world through
                    <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">events & exhibitions.</span>
                </h1>
                <p class="mt-5 max-w-[620px] text-[15px] font-medium leading-[1.65] text-[#1F2B55] sm:text-[17px]">
                    eproexpo is an all-in-one platform for virtual events and exhibitions. We help organizers publish events, sell tickets, and engage audiences — while enabling companies to showcase products in immersive booth experiences.
                </p>
                <p class="mt-4 max-w-[620px] text-[15px] font-medium leading-[1.65] text-[#4E567A]">
                    Whether you are hosting a workshop, running a trade show, or visiting an expo as a buyer, eproexpo brings every step together in one secure, scalable platform.
                </p>
            </div>
            <div class="overflow-hidden rounded-[18px] border border-[#DCE1EE] bg-[#F8F9FD] shadow-[0_16px_40px_rgba(7,16,68,0.08)]">
                <img src="{{ asset('images/home/hero-expo-new-clear.png') }}" alt="EproExpo virtual exhibition platform" class="h-[240px] w-full object-cover object-center sm:h-[320px] lg:h-[360px]">
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-5 lg:grid-cols-3">
        @foreach ($values as $value)
            <article class="rounded-[18px] border border-[#E7EAF3] bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
                <span class="grid h-12 w-12 place-items-center rounded-full text-[20px] text-white" style="background-color: {{ $value['color'] }}">
                    <i class="{{ $value['icon'] }}"></i>
                </span>
                <h2 class="mt-5 text-[20px] font-extrabold text-[#071044]">{{ $value['title'] }}</h2>
                <p class="mt-3 text-[14px] font-medium leading-7 text-[#4E567A]">{{ $value['body'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-8 rounded-[20px] bg-[#F8F8FC] px-5 py-8 sm:px-8 lg:px-10">
        <div class="text-center">
            <h2 class="text-[22px] font-extrabold text-[#071044] sm:text-[28px]">Platform at a glance</h2>
            <div class="mx-auto mt-3 h-[2px] w-[58px] rounded-full bg-gradient-to-r from-[#6D28D9] via-[#C640CF] to-[#FF9B41]"></div>
        </div>
        <div class="mt-8 grid grid-cols-1 gap-4 min-[420px]:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="flex items-center gap-4 rounded-[14px] border border-[#E7EAF3] bg-white p-5 shadow-sm">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full text-white" style="background-color: {{ $stat['color'] ?? '#6325E6' }}">
                        <i class="{{ $stat['icon'] ?? 'fa-solid fa-store' }} text-lg"></i>
                    </span>
                    <div>
                        <p class="text-[18px] font-extrabold text-[#071044]">{{ $stat['title'] ?? '' }}</p>
                        <p class="text-[13px] font-medium text-[#6B7280]">{{ $stat['subtitle'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-[320px_1fr]">
        <aside class="rounded-[18px] bg-[#071A55] px-5 py-7 text-white shadow-[0_14px_34px_rgba(7,16,68,0.18)]">
            <h2 class="text-[22px] font-extrabold">Our Journey</h2>
            <p class="mt-3 text-[14px] font-medium leading-7 text-white/85">Building the future of connected events, one milestone at a time.</p>
        </aside>
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($milestones as $milestone)
                <article class="rounded-[16px] border border-[#E7EAF3] bg-white p-5 shadow-sm">
                    <span class="inline-flex rounded-full bg-[#F4F0FF] px-3 py-1 text-[12px] font-extrabold text-[#6D28D9]">{{ $milestone['year'] }}</span>
                    <h3 class="mt-4 text-[16px] font-extrabold text-[#071044]">{{ $milestone['title'] }}</h3>
                    <p class="mt-2 text-[14px] font-medium leading-7 text-[#4E567A]">{{ $milestone['body'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-[20px] border border-[#E7EAF3] bg-white px-5 py-8 sm:px-8 lg:px-10">
        <div class="text-center">
            <h2 class="text-[22px] font-extrabold text-[#071044] sm:text-[28px]">Trusted by organizations worldwide</h2>
        </div>
        <div class="mt-6 flex flex-wrap items-center justify-center gap-x-7 gap-y-4 text-[17px] font-bold text-[#8C91A0] sm:gap-x-12 sm:text-[23px]">
            @foreach ($partners as $partner)
                @php($style = $partner['meta']['style'] ?? null)
                @if ($style === 'unilever')
                    <span class="flex flex-col items-center leading-none"><span class="text-[26px] font-black sm:text-[32px]">U</span><span class="mt-0.5 text-[8px] uppercase tracking-widest sm:text-[9px]">{{ $partner['title'] ?? 'Unilever' }}</span></span>
                @elseif ($style === 'serif')
                    <span class="font-serif italic text-[24px] sm:text-[30px]">{{ $partner['title'] ?? '' }}</span>
                @elseif ($style === 'serif-lg')
                    <span class="font-serif text-[23px] font-medium sm:text-[29px]">{{ $partner['title'] ?? '' }}</span>
                @elseif ($style === 'tracking' || $style === 'tracking-sm')
                    <span class="{{ $style === 'tracking-sm' ? 'text-[17px] tracking-widest sm:text-[20px]' : 'tracking-widest' }}">{{ $partner['title'] ?? '' }}</span>
                @elseif (! empty($partner['icon']))
                    <span class="flex items-center gap-2"><i class="{{ $partner['icon'] }} text-[20px]"></i> {{ $partner['title'] ?? '' }}</span>
                @else
                    <span class="font-medium">{{ $partner['title'] ?? '' }}</span>
                @endif
            @endforeach
        </div>
    </section>

    <section id="contact" class="mt-8 overflow-hidden rounded-[20px] bg-gradient-to-r from-[#5522E6] via-[#9A31D5] to-[#FF4D3D] px-5 py-10 text-white sm:px-8 lg:px-12">
        <div class="grid items-center gap-6 lg:grid-cols-[1fr_auto]">
            <div>
                <h2 class="text-[24px] font-extrabold leading-tight sm:text-[32px]">Connect. Explore. Engage.</h2>
                <p class="mt-4 max-w-[560px] text-[15px] font-medium leading-7 text-white/90">Ready to learn more or partner with us? Start exploring events and exhibitions today.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('events.home') }}" class="rounded-xl bg-white px-7 py-4 text-center text-[15px] font-extrabold text-[#5726E8] shadow-xl transition-colors hover:bg-gray-50">Explore Events</a>
                <a href="{{ route('frontend.features') }}" class="rounded-xl border border-white/55 px-7 py-4 text-center text-[15px] font-extrabold transition-colors hover:bg-white/10">View Features</a>
            </div>
        </div>
    </section>
@endsection
