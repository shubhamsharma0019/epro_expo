@php
    $homeUrl = $slug ? route('exhibitions.visitor.dashboard', $slug) : route('frontend.user.dashboard');
    $shareUrl = url()->current();
@endphp

<div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <nav class="flex min-w-0 flex-wrap items-center gap-2 text-[13px] font-semibold text-[#5A6480]" aria-label="Breadcrumb">
        <a href="{{ $homeUrl }}" class="text-[#5B32F6] hover:underline">Home</a>
        <span class="text-[#C4CAD9]">/</span>
        <a href="{{ $slug ? route('exhibitions.visitor.floor-map', $slug) : '#' }}" class="hover:text-[#071044]">{{ $hallName }}</a>
        <span class="text-[#C4CAD9]">/</span>
        <span class="truncate text-[#071044]">{{ $boothLabel }} - {{ $company }}</span>
    </nav>

    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
        <button type="button" id="share-booth-btn" data-share-url="{{ $shareUrl }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#E7EAF3] bg-white px-4 text-[13px] font-bold text-[#071044] hover:bg-[#F8F7FF]">
            <i class="ph ph-share-network"></i>
            <span class="hidden sm:inline">Share Booth</span>
        </button>
        @if ($isPassActive)
            <button type="button" id="save-booth-btn" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#E7EAF3] bg-white px-4 text-[13px] font-bold text-[#071044] hover:bg-[#F8F7FF]">
                <i class="ph ph-heart"></i>
                <span class="hidden sm:inline">Add to Favorite</span>
            </button>
        @else
            <a href="{{ $ticketUrl }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#EADCFD] bg-[#FBFAFF] px-4 text-[13px] font-bold text-[#5B32F6]">
                <i class="ph ph-ticket"></i>
                <span class="hidden sm:inline">Get Pass</span>
            </a>
        @endif
        <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#5B32F6] px-4 text-[13px] font-bold text-white hover:bg-[#4C10D0]">
            <i class="ph ph-arrow-left"></i>
            <span class="hidden sm:inline">All Companies</span>
        </a>
    </div>
</div>
