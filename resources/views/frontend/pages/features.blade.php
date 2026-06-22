@extends('frontend.pages.layout', [
    'pageTitle' => 'Features',
    'activeNav' => 'features',
])

@php
    $features = \App\Support\WebsiteContent::sectionOrDefaults('home', 'feature', \App\Support\WebsiteContent::defaultFeatures());
    $featurePills = \App\Support\WebsiteContent::sectionOrDefaults('home', 'feature_pill', \App\Support\WebsiteContent::defaultFeaturePills());
    $steps = \App\Support\WebsiteContent::sectionOrDefaults('home', 'step', \App\Support\WebsiteContent::defaultSteps());
    $flowCards = \App\Support\WebsiteContent::sectionOrDefaults('home', 'flow_card', \App\Support\WebsiteContent::defaultFlowCards());
    $resolveFlowUrl = function (array $card) {
        if (! empty($card['link_url'])) {
            return $card['link_url'];
        }
        if (! empty($card['route'])) {
            try {
                return route($card['route']);
            } catch (\Throwable) {
                return url('/');
            }
        }

        return url('/');
    };
@endphp

@section('content')
    <section class="relative overflow-hidden rounded-[20px] border border-[#E7EAF3] bg-white px-5 py-10 shadow-[0_16px_38px_rgba(31,42,106,0.08)] sm:px-8 sm:py-12 lg:px-12">
        <div class="max-w-[760px]">
            <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">Platform Features</p>
            <h1 class="mt-3 text-[34px] font-black leading-[1.05] tracking-[-0.04em] text-[#071044] sm:text-[48px] lg:text-[56px]">
                Everything you need to run
                <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">events & exhibitions.</span>
            </h1>
            <p class="mt-5 max-w-[620px] text-[15px] font-medium leading-[1.65] text-[#1F2B55] sm:text-[17px]">
                From small community meetups to large virtual expos, eproexpo gives organizers, exhibitors, and visitors one connected platform for ticketing, booths, networking, and live engagement.
            </p>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-2 rounded-2xl bg-[#F8F9FD] p-3 sm:grid-cols-3 lg:grid-cols-6 lg:p-4">
            @foreach ($featurePills as $pill)
                <div class="rounded-xl bg-white px-3 py-4 text-center text-[12px] font-semibold text-[#25305B] shadow-sm">
                    <div class="mb-2 text-[20px] text-[#6D28D9]"><i class="{{ $pill['icon'] ?? 'far fa-circle' }}"></i></div>
                    {{ $pill['title'] ?? '' }}
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-[20px] bg-[#F8F8FC] px-5 py-8 sm:px-8 lg:px-10">
        <div class="text-center">
            <h2 class="text-[22px] font-extrabold tracking-[-0.02em] text-[#071044] sm:text-[28px]">Built for every audience</h2>
            <div class="mx-auto mt-3 h-[2px] w-[58px] rounded-full bg-gradient-to-r from-[#6D28D9] via-[#C640CF] to-[#FF9B41]"></div>
            <p class="mx-auto mt-4 max-w-[720px] text-[14px] font-medium leading-7 text-[#4E567A] sm:text-[15px]">
                Powerful tools for event organizers, exhibition companies, and visitors — all in one seamless experience.
            </p>
        </div>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($features as $feature)
                <article class="min-h-[248px] rounded-[14px] border border-[#E7EAF3] bg-white px-5 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1">
                    <span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full text-[22px] text-white" style="background-color: {{ $feature['color'] ?? '#8B2DE8' }}">
                        <i class="{{ $feature['icon'] ?? 'far fa-circle' }}"></i>
                    </span>
                    <h3 class="mt-5 text-[16px] font-extrabold leading-snug text-[#071044]">{!! nl2br(e($feature['title'] ?? '')) !!}</h3>
                    <p class="mt-4 text-[13px] font-medium leading-[1.75] text-[#25305B]">{{ $feature['body'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-[320px_1fr]">
        <aside class="overflow-hidden rounded-[18px] bg-[#071A55] px-5 py-7 text-white shadow-[0_14px_34px_rgba(7,16,68,0.18)]">
            <h2 class="text-center text-[22px] font-extrabold leading-none">How It Works</h2>
            <div class="relative mt-8 space-y-7">
                <div class="absolute bottom-10 left-[31px] top-9 border-l-2 border-dashed border-white/22"></div>
                @foreach ($steps as $index => $step)
                    <div class="relative grid grid-cols-[64px_1fr] gap-5">
                        <span class="relative z-10 grid h-[62px] w-[62px] place-items-center rounded-full text-[24px] text-white shadow-[0_8px_20px_rgba(0,0,0,0.15)]" style="background-color: {{ $step['color'] ?? '#8B2DE8' }}">
                            <i class="{{ $step['icon'] ?? 'fas fa-circle' }}"></i>
                        </span>
                        <div class="pt-1">
                            <div class="flex items-center gap-3">
                                <span class="grid h-7 w-7 place-items-center rounded-full bg-white text-[14px] font-extrabold text-[#6D28D9]">{{ $step['step'] ?? ($index + 1) }}</span>
                                <h3 class="text-[15px] font-extrabold">{{ $step['title'] ?? '' }}</h3>
                            </div>
                            <p class="mt-2 text-[12px] font-medium leading-[1.55] text-white/88">{{ $step['body'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>

        <div class="grid gap-5 sm:grid-cols-2">
            @foreach ($flowCards as $card)
                <article class="flex h-full flex-col rounded-[18px] border bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)]" style="border-color: {{ $card['border'] ?? '#E7EAF3' }};">
                    <span class="grid h-12 w-12 place-items-center rounded-full text-[20px] text-white" style="background-color: {{ $card['color'] ?? '#6D28D9' }}">
                        <i class="{{ $card['icon'] ?? 'far fa-circle' }}"></i>
                    </span>
                    <h3 class="mt-5 text-[18px] font-extrabold text-[#071044]">{{ $card['title'] ?? '' }}</h3>
                    <p class="mt-3 flex-1 text-[14px] font-medium leading-7 text-[#4E567A]">{{ $card['body'] ?? '' }}</p>
                    <a href="{{ $resolveFlowUrl($card) }}" class="mt-6 inline-flex items-center gap-2 text-[14px] font-bold text-[#5726E8] hover:text-[#6D28D9]">
                        {{ $card['link_label'] ?? 'Learn more' }}
                        <i class="fas fa-arrow-right text-[12px]"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-8 overflow-hidden rounded-[20px] bg-gradient-to-r from-[#5522E6] via-[#9A31D5] to-[#FF4D3D] px-5 py-10 text-white sm:px-8 lg:px-12">
        <div class="grid items-center gap-6 lg:grid-cols-[1fr_auto]">
            <div>
                <h2 class="text-[24px] font-extrabold leading-tight sm:text-[32px]">Ready to explore the platform?</h2>
                <p class="mt-4 max-w-[560px] text-[15px] font-medium leading-7 text-white/90">Start with events, exhibitions, or create your own company event in minutes.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('events.home') }}" class="rounded-xl bg-white px-7 py-4 text-center text-[15px] font-extrabold text-[#5726E8] shadow-xl transition-colors hover:bg-gray-50">Explore Events</a>
                <a href="{{ route('exhibitions.index') }}" class="rounded-xl border border-white/55 px-7 py-4 text-center text-[15px] font-extrabold transition-colors hover:bg-white/10">Browse Exhibitions</a>
            </div>
        </div>
    </section>
@endsection
