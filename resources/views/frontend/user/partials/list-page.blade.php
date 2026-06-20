@extends('layouts.user')

@section('title', $title)
@section('page-title', $title)

@section('content')
@php
    $variant = $variant ?? 'cards';
    $heroImage = $heroImage ?? asset('images/exhibitions/hero-pavilion-scene.png');
    $items = $items ?? [];
    $accent = $accent ?? '#5b2eff';
@endphp

<main class="px-5 py-6 sm:px-8 lg:px-8">
    <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
        <div class="overflow-hidden rounded-[28px] border border-[#E7EAF3] bg-white shadow-[0_18px_50px_rgba(7,16,68,0.07)]">
            <div class="grid min-h-[250px] lg:grid-cols-[1fr_340px]">
                <div class="p-6 sm:p-8">
                    <span class="inline-flex rounded-full bg-[#F4F0FF] px-4 py-2 text-[11px] font-medium uppercase tracking-[0.14em] text-[#5b2eff]">{{ $eyebrow ?? 'Visitor Workspace' }}</span>
                    <h1 class="mt-5 max-w-[680px] text-[34px] font-medium leading-tight text-[#071044] sm:text-[46px]">{{ $title }}</h1>
                    <p class="mt-4 max-w-[620px] text-[15px] font-medium leading-7 text-[#5A6480]">{{ $description }}</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <button class="h-11 rounded-2xl bg-[#071044] px-5 text-[13px] font-medium text-white">All Items</button>
                        <button class="h-11 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[13px] font-medium text-[#071044]">Active</button>
                    </div>
                </div>
                <div class="relative min-h-[220px] overflow-hidden bg-[#071044]">
                    <img src="{{ $heroImage }}" class="absolute inset-0 h-full w-full object-cover opacity-60" alt="{{ $title }}">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#071044] via-[#071044]/65 to-[#5b2eff]/50"></div>
                </div>
            </div>
        </div>

        <aside class="rounded-[28px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_50px_rgba(7,16,68,0.07)]">
            <p class="text-[13px] font-medium text-[#5A6480]">Quick search</p>
            <label class="relative mt-4 block">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#8A94AD]"></i>
                <input placeholder="Search here..." class="h-12 w-full rounded-2xl border border-[#E7EAF3] bg-[#F8F9FD] pl-11 pr-4 text-[14px] font-medium outline-none focus:border-[#5b2eff]">
            </label>
            <div class="mt-5 rounded-2xl bg-[#F8FAFF] p-4">
                <p class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#8A94AD]">Total</p>
                <p class="mt-2 text-[34px] font-medium text-[#071044]">{{ count($items) }}</p>
                <p class="mt-1 text-[13px] font-medium text-[#5A6480]">records in this section</p>
            </div>
        </aside>
    </section>

    @if ($variant === 'ticket')
        <section class="mt-6 grid gap-5 xl:grid-cols-2">
            @foreach ($items as $item)
                @php
                    [$name, $meta, $status, $href] = array_pad($item, 4, '');
                    $itemImage = $item[4] ?? $heroImage;
                @endphp
                <article class="grid overflow-hidden rounded-[26px] border border-[#E7EAF3] bg-white shadow-[0_14px_38px_rgba(7,16,68,0.07)] md:grid-cols-[1fr_190px]">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[#5b2eff]"><i class="{{ $icon ?? 'fa-solid fa-ticket' }}"></i></span>
                            <div class="min-w-0">
                                <h2 class="text-[21px] font-medium text-[#071044]">{{ $name }}</h2>
                                <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $meta }}</p>
                            </div>
                        </div>
                        <div class="mt-7 flex flex-wrap items-center gap-3">
                            <span class="rounded-full bg-[#ECFDF5] px-3 py-1.5 text-[12px] font-medium text-[#047857]">{{ $status }}</span>
                            <a href="{{ url($href) }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-[#E7EAF3] px-4 text-[13px] font-medium text-[#071044]">Details</a>
                            <a href="{{ url($href . '/e-ticket') }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-[#071044] px-4 text-[13px] font-medium text-white">E-ticket</a>
                        </div>
                    </div>
                    <div class="flex items-center justify-center border-t border-dashed border-[#D8DDF0] bg-[#F8FAFF] p-6 md:border-l md:border-t-0">
                        <img src="{{ $itemImage }}" alt="{{ $name }}" class="h-full max-h-[128px] w-full rounded-[18px] object-cover shadow-sm">
                    </div>
                </article>
            @endforeach
        </section>
    @elseif ($variant === 'visit')
        <section class="mt-6 rounded-[28px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_38px_rgba(7,16,68,0.07)]">
            <div class="space-y-4">
                @foreach ($items as [$name, $meta, $status, $href])
                    <article class="grid gap-4 rounded-[22px] border border-[#E7EAF3] bg-[#FBFCFF] p-5 md:grid-cols-[auto_1fr_auto] md:items-center">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[#5b2eff]"><i class="fa-regular fa-clock"></i></span>
                        <div class="min-w-0">
                            <h2 class="text-[19px] font-medium text-[#071044]">{{ $name }}</h2>
                            <p class="mt-1 text-[14px] font-medium text-[#5A6480]">{{ $meta }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-white px-3 py-1.5 text-[12px] font-medium text-[#34405F]">{{ $status }}</span>
                            <a href="{{ url($href) }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#071044] text-white"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @elseif ($variant === 'inbox')
        <section class="mt-6 grid gap-5 lg:grid-cols-[320px_1fr]">
            <aside class="rounded-[28px] border border-[#E7EAF3] bg-white p-4 shadow-[0_14px_38px_rgba(7,16,68,0.07)]">
                @foreach ($items as [$name, $meta, $status, $href])
                    <a href="{{ url($href) }}" class="mb-3 block rounded-2xl border border-[#E7EAF3] bg-[#FBFCFF] p-4 transition hover:border-[#5b2eff]">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="truncate text-[15px] font-medium text-[#071044]">{{ $name }}</h2>
                            <span class="rounded-full bg-[#F4F0FF] px-2.5 py-1 text-[11px] font-medium text-[#5b2eff]">{{ $status }}</span>
                        </div>
                        <p class="mt-2 truncate text-[13px] font-medium text-[#5A6480]">{{ $meta }}</p>
                    </a>
                @endforeach
            </aside>
            <article class="rounded-[28px] border border-[#E7EAF3] bg-white p-7 shadow-[0_14px_38px_rgba(7,16,68,0.07)]">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[#5b2eff]"><i class="fa-regular fa-message"></i></span>
                <h2 class="mt-5 text-[28px] font-medium text-[#071044]">Latest enquiry thread</h2>
                <p class="mt-3 max-w-[640px] text-[15px] font-medium leading-7 text-[#5A6480]">Your latest exhibitor conversation appears here with status, reply tracking, and quick action controls.</p>
                <div class="mt-7 rounded-2xl bg-[#F8FAFF] p-5 text-[14px] font-medium leading-7 text-[#34405F]">Thanks for your interest. Our sales team has shared the requested catalogue and meeting slots.</div>
            </article>
        </section>
    @else
        <section class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($items as [$name, $meta, $status, $href])
                <article class="overflow-hidden rounded-[26px] border border-[#E7EAF3] bg-white shadow-[0_14px_38px_rgba(7,16,68,0.07)]">
                    <div class="relative h-[170px] bg-[#071044]">
                        <img src="{{ $heroImage }}" class="absolute inset-0 h-full w-full object-cover opacity-70" alt="{{ $name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#071044]/78 to-transparent"></div>
                        <span class="absolute left-5 top-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/16 text-white backdrop-blur"><i class="{{ $icon ?? 'fa-regular fa-bookmark' }}"></i></span>
                    </div>
                    <div class="p-5">
                        <h2 class="text-[20px] font-medium text-[#071044]">{{ $name }}</h2>
                        <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $meta }}</p>
                        <div class="mt-5 flex items-center justify-between gap-3">
                            <span class="rounded-full bg-[#F4F0FF] px-3 py-1 text-[12px] font-medium text-[#5b2eff]">{{ $status }}</span>
                            <a href="{{ url($href) }}" class="text-[13px] font-medium text-[#5b2eff]">Open</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
</main>
@endsection
