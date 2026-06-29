@php
    $quickLinks = $quickLinks ?? \App\Support\ExhibitionQuickLinks::boothLinks();
    $quickLinksSectionClass = $quickLinksSectionClass ?? '';
@endphp

<section @class(['booth-quick-links-section', $quickLinksSectionClass])>
    <div class="booth-quick-links-grid">
        @foreach ($quickLinks as $link)
            <a href="{{ $link['href'] }}" class="booth-quick-link transition-shadow hover:shadow-md">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B32F6]">
                    <i class="{{ $link['icon'] }} text-[20px]"></i>
                </div>
                <h3 class="text-[14px] font-bold text-[#071044]">{{ $link['title'] }}</h3>
                <p class="mt-1 flex-1 text-[12px] font-medium leading-5 text-[#5A6480]">{{ $link['desc'] }}</p>
                <span class="mt-3 text-[12px] font-bold text-[#5B32F6]">{{ $link['action'] }} →</span>
            </a>
        @endforeach
    </div>
</section>
