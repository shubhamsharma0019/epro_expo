@extends('layouts.user')

@section('title', $title)
@section('page-title', $title)

@section('content')
<section class="space-y-6 px-4 py-6 sm:px-8">
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="grid lg:grid-cols-[1fr_380px]">
            <div class="p-5 sm:p-6 lg:p-8">
                <span class="inline-flex rounded-full bg-[#F4F2FF] px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#3723db]">{{ $eyebrow ?? 'Visitor Detail' }}</span>
                <h1 class="mt-5 text-[28px] font-bold leading-tight text-[#0B132C] sm:text-[40px]">{{ $heading }}</h1>
                <p class="mt-4 max-w-[650px] text-[15px] leading-7 text-gray-500">{{ $description }}</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    @isset($primaryUrl)
                        <a href="{{ url($primaryUrl) }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-[#3723db] px-6 text-[14px] font-bold text-white transition hover:bg-[#2b1bb8]">{{ $primaryLabel ?? 'Open' }}</a>
                    @endisset
                    <a href="{{ url($backUrl ?? '/user/dashboard') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 px-6 text-[14px] font-bold text-[#0B132C] transition hover:bg-gray-50">Back</a>
                </div>
            </div>
            <aside class="relative min-h-[220px] overflow-hidden bg-[#0B132C] p-5 text-white sm:min-h-[280px] sm:p-6">
                <img src="{{ $heroImage ?? asset('images/exhibitions/hero-pavilion-scene.png') }}" class="absolute inset-0 h-full w-full object-cover opacity-45" alt="{{ $heading }}">
                <div class="absolute inset-0 bg-gradient-to-br from-[#0B132C] via-[#0B132C]/75 to-[#3723db]/50"></div>
                <div class="relative z-10 rounded-2xl bg-white/12 p-5 ring-1 ring-white/15">
                    @foreach ($meta ?? [['Status','Confirmed'],['Type','Visitor'],['Updated','Today']] as [$label, $value])
                        <div class="border-b border-white/10 py-3 last:border-b-0">
                            <p class="text-[12px] font-bold uppercase tracking-[0.12em] text-white/50">{{ $label }}</p>
                            <p class="mt-1 break-words text-[17px] font-semibold text-white">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
