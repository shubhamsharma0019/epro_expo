@php
    $boothNavItems = [
        ['label' => 'Booth Home', 'icon' => 'ph ph-house', 'href' => '#booth-home', 'active' => true],
        ['label' => 'Company Details', 'icon' => 'ph ph-buildings', 'href' => '#company-details'],
        ['label' => 'Products & Services', 'icon' => 'ph ph-package', 'href' => '#products'],
        ['label' => 'Brochures', 'icon' => 'ph ph-file-text', 'href' => '#brochures'],
        ['label' => 'Company Video', 'icon' => 'ph ph-play-circle', 'href' => '#company-video'],
        ['label' => 'Live Session (1 to 1)', 'icon' => 'ph ph-video-camera', 'href' => '#meeting'],
        ['label' => 'Conference / Webinars', 'icon' => 'ph ph-presentation', 'href' => '#sessions'],
        ['label' => 'Photo Gallery', 'icon' => 'ph ph-images', 'href' => '#photo-gallery'],
    ];
@endphp

<nav class="booth-home-nav" aria-label="Booth sections">
    @foreach ($boothNavItems as $item)
        <a href="{{ $item['href'] }}" @class(['is-active' => $item['active'] ?? false])>
            <i class="{{ $item['icon'] }} text-[18px]"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach

    <div class="hidden xl:block mt-4 rounded-xl border border-[#E7EAF3] bg-white p-4">
        <p class="text-[13px] font-bold text-[#071044]">Need Help?</p>
        <p class="mt-1 text-[12px] font-medium leading-5 text-[#5A6480]">Chat with the exhibition support team anytime.</p>
        <a href="{{ route('exhibitions.visitor.chat', [$slug, $companySlug]) }}" class="mt-3 inline-flex h-9 w-full items-center justify-center rounded-lg bg-[#5B32F6] text-[12px] font-bold text-white hover:bg-[#4C10D0]">
            Chat Now
        </a>
    </div>
</nav>
