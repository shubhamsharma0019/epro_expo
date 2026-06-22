@extends('frontend.pages.layout', [
    'pageTitle' => 'Pricing',
    'activeNav' => 'pricing',
])

@php
    $ctaBenefits = \App\Support\WebsiteContent::sectionOrDefaults('home', 'cta_benefit', \App\Support\WebsiteContent::defaultCtaBenefits());
    $plans = [
        [
            'name' => 'Starter',
            'price' => 'Free',
            'period' => 'to get started',
            'description' => 'Perfect for small events, community meetups, and first-time organizers.',
            'highlight' => false,
            'features' => [
                'Create and publish events',
                'Basic ticketing & registrations',
                'Event page with branding',
                'Email ticket delivery',
                'Visitor dashboard access',
            ],
            'button' => 'Get Started Free',
            'url' => route('company.event-company.login'),
        ],
        [
            'name' => 'Professional',
            'price' => 'Custom',
            'period' => 'per event or exhibition',
            'description' => 'For growing organizers and exhibitors who need advanced tools and analytics.',
            'highlight' => true,
            'features' => [
                'Everything in Starter',
                'Virtual exhibition booths',
                'Live chat & video meetings',
                'Brochures & lead capture',
                'Analytics & performance reports',
                'Priority support',
            ],
            'button' => 'Talk to Sales',
            'url' => route('events.home'),
        ],
        [
            'name' => 'Enterprise',
            'price' => 'Custom',
            'period' => 'tailored packages',
            'description' => 'For large organizations running multiple events and exhibitions globally.',
            'highlight' => false,
            'features' => [
                'Everything in Professional',
                'Multi-pavilion exhibitions',
                'Custom branding & domains',
                'Dedicated account manager',
                'Advanced security & compliance',
                'SLA-backed 24/7 support',
            ],
            'button' => 'Contact Us',
            'url' => route('frontend.about') . '#contact',
        ],
    ];
    $faqs = [
        ['q' => 'Can I start for free?', 'a' => 'Yes. You can create and publish events with our Starter plan at no upfront cost.'],
        ['q' => 'Do you support virtual exhibitions?', 'a' => 'Absolutely. Our platform supports pavilions, halls, booths, visitor passes, and live engagement tools.'],
        ['q' => 'Is ticketing secure?', 'a' => 'Yes. All payments and ticket delivery are handled through secure, encrypted flows.'],
        ['q' => 'Can companies book booths online?', 'a' => 'Yes. Exhibitors can browse exhibitions, book booth space, and manage their booth setup from one dashboard.'],
    ];
@endphp

@section('content')
    <section class="relative overflow-hidden rounded-[20px] border border-[#E7EAF3] bg-white px-5 py-10 shadow-[0_16px_38px_rgba(31,42,106,0.08)] sm:px-8 sm:py-12 lg:px-12">
        <div class="max-w-[760px]">
            <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">Simple Pricing</p>
            <h1 class="mt-3 text-[34px] font-black leading-[1.05] tracking-[-0.04em] text-[#071044] sm:text-[48px] lg:text-[56px]">
                Plans that scale with
                <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">your ambitions.</span>
            </h1>
            <p class="mt-5 max-w-[620px] text-[15px] font-medium leading-[1.65] text-[#1F2B55] sm:text-[17px]">
                Start free for events, then upgrade as you grow. Flexible packages for exhibitions, booths, and enterprise teams.
            </p>
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-3">
        @foreach ($plans as $plan)
            <article @class([
                'flex h-full flex-col rounded-[20px] border bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)] sm:p-7',
                'border-[#6D28D9] ring-2 ring-[#6D28D9]/15' => $plan['highlight'],
                'border-[#E7EAF3]' => ! $plan['highlight'],
            ])>
                @if ($plan['highlight'])
                    <span class="mb-4 inline-flex w-fit rounded-full bg-[#F4F0FF] px-3 py-1 text-[11px] font-extrabold uppercase tracking-[0.08em] text-[#6D28D9]">Most Popular</span>
                @endif
                <h2 class="text-[22px] font-extrabold text-[#071044]">{{ $plan['name'] }}</h2>
                <div class="mt-4">
                    <span class="text-[34px] font-black tracking-[-0.03em] text-[#071044]">{{ $plan['price'] }}</span>
                    <span class="mt-1 block text-[13px] font-medium text-[#6B7280]">{{ $plan['period'] }}</span>
                </div>
                <p class="mt-4 text-[14px] font-medium leading-7 text-[#4E567A]">{{ $plan['description'] }}</p>
                <ul class="mt-6 space-y-3">
                    @foreach ($plan['features'] as $feature)
                        <li class="flex items-start gap-3 text-[14px] font-medium text-[#25305B]">
                            <span class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full bg-[#EEF2FF] text-[10px] text-[#5726E8]"><i class="fas fa-check"></i></span>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ $plan['url'] }}" @class([
                    'mt-8 block rounded-xl px-6 py-4 text-center text-[15px] font-bold transition-colors',
                    'bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] text-white shadow-[0_12px_24px_rgba(91,46,255,0.26)] hover:opacity-95' => $plan['highlight'],
                    'border border-[#D8DCEB] bg-white text-[#071044] hover:bg-[#F8F7FF]' => ! $plan['highlight'],
                ])>{{ $plan['button'] }}</a>
            </article>
        @endforeach
    </section>

    <section class="mt-8 rounded-[20px] border border-[#E7EAF3] bg-white px-5 py-8 sm:px-8 lg:px-10">
        <div class="text-center">
            <h2 class="text-[22px] font-extrabold text-[#071044] sm:text-[28px]">Why teams choose eproexpo</h2>
            <div class="mx-auto mt-3 h-[2px] w-[58px] rounded-full bg-gradient-to-r from-[#6D28D9] via-[#C640CF] to-[#FF9B41]"></div>
        </div>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($ctaBenefits as $benefit)
                <div class="rounded-[14px] border border-[#E7EAF3] bg-[#F8F9FD] px-5 py-6 text-center">
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-[#6D28D9] text-[20px] text-white"><i class="{{ $benefit['icon'] ?? 'far fa-check-square' }}"></i></span>
                    <p class="mt-4 text-[15px] font-extrabold text-[#071044]">{{ $benefit['title'] ?? '' }}</p>
                    <p class="mt-2 text-[13px] font-medium text-[#6B7280]">{{ $benefit['subtitle'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-[20px] bg-[#F8F8FC] px-5 py-8 sm:px-8 lg:px-10">
        <div class="text-center">
            <h2 class="text-[22px] font-extrabold text-[#071044] sm:text-[28px]">Frequently asked questions</h2>
        </div>
        <div class="mx-auto mt-8 grid max-w-[920px] gap-4">
            @foreach ($faqs as $faq)
                <article class="rounded-[14px] border border-[#E7EAF3] bg-white px-5 py-5 sm:px-6">
                    <h3 class="text-[15px] font-extrabold text-[#071044]">{{ $faq['q'] }}</h3>
                    <p class="mt-2 text-[14px] font-medium leading-7 text-[#4E567A]">{{ $faq['a'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-8 overflow-hidden rounded-[20px] bg-gradient-to-r from-[#5522E6] via-[#9A31D5] to-[#FF4D3D] px-5 py-10 text-white sm:px-8 lg:px-12">
        <div class="grid items-center gap-6 lg:grid-cols-[1fr_auto]">
            <div>
                <h2 class="text-[24px] font-extrabold leading-tight sm:text-[32px]">Any event. Every audience. Everywhere.</h2>
                <p class="mt-4 max-w-[560px] text-[15px] font-medium leading-7 text-white/90">Join thousands of organizers and exhibitors building meaningful connections on eproexpo.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('company.event-company.login') }}" class="rounded-xl bg-white px-7 py-4 text-center text-[15px] font-extrabold text-[#5726E8] shadow-xl transition-colors hover:bg-gray-50">Create Event</a>
                <a href="{{ route('company.home') }}" class="rounded-xl border border-white/55 px-7 py-4 text-center text-[15px] font-extrabold transition-colors hover:bg-white/10">Book a Booth</a>
            </div>
        </div>
    </section>
@endsection
