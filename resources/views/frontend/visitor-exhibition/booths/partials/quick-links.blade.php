@php
    $quickLinks = [
        ['title' => 'Company Details', 'desc' => 'About the exhibitor and booth overview.', 'href' => '#company-details', 'action' => 'View Details', 'icon' => 'ph ph-buildings'],
        ['title' => 'Brochures', 'desc' => 'Download product and company brochures.', 'href' => '#brochures', 'action' => 'Download', 'icon' => 'ph ph-file-text'],
        ['title' => 'Company Video', 'desc' => 'Watch the company overview video.', 'href' => '#company-video', 'action' => 'Watch Video', 'icon' => 'ph ph-play-circle'],
        ['title' => 'Live Session', 'desc' => 'Request a one-to-one meeting with the team.', 'href' => '#meeting', 'action' => 'Request Meeting', 'icon' => 'ph ph-video-camera'],
        ['title' => 'Conference', 'desc' => 'Join upcoming booth sessions and webinars.', 'href' => '#sessions', 'action' => 'Join Session', 'icon' => 'ph ph-presentation'],
        ['title' => 'Photo Gallery', 'desc' => 'Browse booth photos and media assets.', 'href' => '#photo-gallery', 'action' => 'View Gallery', 'icon' => 'ph ph-images'],
        ['title' => 'Products', 'desc' => 'Explore products and services on display.', 'href' => '#products', 'action' => 'View Products', 'icon' => 'ph ph-package'],
    ];
@endphp

<section class="mt-8">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-7">
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
