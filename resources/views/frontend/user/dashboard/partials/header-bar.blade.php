@php
    $userName = $user->name ?? 'Visitor';
@endphp

<div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <nav class="flex min-w-0 flex-wrap items-center gap-2 text-[13px] font-semibold text-[#5A6480]" aria-label="Breadcrumb">
        <a href="{{ route('frontend.user.dashboard') }}" class="text-[#5B32F6] hover:underline">Home</a>
        <span class="text-[#C4CAD9]">/</span>
        <span class="truncate text-[#071044]">Visitor Dashboard</span>
    </nav>

    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
        <a href="{{ route('frontend.user.tickets.index') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#E7EAF3] bg-white px-4 text-[13px] font-bold text-[#071044] hover:bg-[#F8F7FF]">
            <i class="ph ph-ticket"></i>
            <span class="hidden sm:inline">My Passes</span>
        </a>
        @if (! empty($activeSlug))
            <a href="{{ route('exhibitions.visit', $activeSlug) }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#E7EAF3] bg-white px-4 text-[13px] font-bold text-[#071044] hover:bg-[#F8F7FF]">
                <i class="ph ph-door-open"></i>
                <span class="hidden sm:inline">Exhibition Lobby</span>
            </a>
        @endif
        <a href="{{ route('exhibitions.index') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#5B32F6] px-4 text-[13px] font-bold text-white hover:bg-[#4C10D0]">
            <i class="ph ph-buildings"></i>
            <span class="hidden sm:inline">Browse Exhibitions</span>
        </a>
    </div>
</div>
