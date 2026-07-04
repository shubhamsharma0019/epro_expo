@props([
    'href' => route('home'),
    'subtitle' => 'EXHIBITOR SUITE',
    'size' => 'header',
])

@php
    $sizes = [
        'header' => [
            'mark' => 'h-11 w-11 rounded-[16px] text-[20px] sm:h-[54px] sm:w-[54px] sm:rounded-[18px] sm:text-[24px]',
            'title' => 'text-[24px] text-[#071044] sm:text-[30px]',
            'subtitle' => 'text-[10px] text-[#8A94AD] sm:text-[12px]',
        ],
        'footer' => [
            'mark' => 'h-10 w-10 rounded-[14px] text-[19px]',
            'title' => 'text-[23px] text-[#071044]',
            'subtitle' => 'text-[10px] text-[#8A94AD]',
        ],
        'compact' => [
            'mark' => 'h-10 w-10 rounded-[14px] text-[18px]',
            'title' => 'text-[20px] text-[#071044]',
            'subtitle' => 'text-[9px] text-[#8A94AD]',
        ],
    ];

    $logoSize = $sizes[$size] ?? $sizes['header'];
@endphp

<x-shared.brand-logo
    :href="$href"
    :subtitle="$subtitle"
    :mark-class="$logoSize['mark']"
    :title-class="$logoSize['title']"
    :subtitle-class="$logoSize['subtitle']"
    {{ $attributes }}
/>
