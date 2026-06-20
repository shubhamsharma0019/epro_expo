@extends('layouts.user')

@section('title', $title)
@section('page-title', $title)

@section('content')
<main class="px-5 py-6 sm:px-8 lg:px-8">
    <section class="overflow-hidden rounded-[26px] border border-[#E7EAF3] bg-white shadow-[0_18px_50px_rgba(7,16,68,0.08)]">
        <div class="grid lg:grid-cols-[1fr_380px]">
            <div class="p-6 sm:p-8">
                <span class="inline-flex rounded-full bg-[#F4F0FF] px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#5b2eff]">{{ $eyebrow ?? 'Visitor Detail' }}</span>
                <h1 class="mt-5 text-[34px] font-semibold leading-tight tracking-[-0.04em] text-[#071044] sm:text-[48px]">{{ $heading }}</h1>
                <p class="mt-4 max-w-[650px] text-[15px] font-medium leading-7 text-[#5A6480]">{{ $description }}</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    @isset($primaryUrl)
                        <a href="{{ url($primaryUrl) }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[14px] font-bold text-white shadow-lg shadow-purple-200">{{ $primaryLabel ?? 'Open' }}</a>
                    @endisset
                    <a href="{{ url($backUrl ?? '/user/dashboard') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-[#E7EAF3] px-6 text-[14px] font-bold text-[#071044] hover:bg-[#F4F0FF]">Back</a>
                </div>
            </div>
            <aside class="relative min-h-[280px] overflow-hidden bg-[#071044] p-6 text-white">
                <img src="{{ $heroImage ?? asset('images/exhibitions/hero-pavilion-scene.png') }}" class="absolute inset-0 h-full w-full object-cover opacity-45" alt="{{ $heading }}">
                <div class="absolute inset-0 bg-gradient-to-br from-[#071044] via-[#071044]/75 to-[#5b2eff]/50"></div>
                <div class="relative z-10 rounded-2xl bg-white/12 p-5 ring-1 ring-white/15">
                    @foreach ($meta ?? [['Status','Confirmed'],['Type','Visitor'],['Updated','Today']] as [$label, $value])
                        <div class="border-b border-white/10 py-3 last:border-b-0">
                            <p class="text-[12px] font-bold uppercase tracking-[0.12em] text-white/50">{{ $label }}</p>
                            <p class="mt-1 text-[17px] font-semibold text-white">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>
</main>
@endsection
