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

<nav class="booth-section-tabs w-full" aria-label="Booth sections">
    @foreach ($boothNavItems as $item)
        <a href="{{ $item['href'] }}" @class(['is-active' => $item['active'] ?? false])>
            <i class="{{ $item['icon'] }} text-[18px]"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
