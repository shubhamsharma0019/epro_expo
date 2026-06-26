@php
    $segmentWidth = max((int) ($segment['width'] ?? 48), 48);
    $segmentHeight = max((int) ($segment['height'] ?? 44), 44);
    $companyName = (string) ($group['company_name'] ?? 'Booked Company');
    $companyInitial = strtoupper(substr($companyName, 0, 1));
    $labelClass = \App\Support\HallBookedBoothGroups::overlayLabelClass($segmentWidth, $segmentHeight);
    $logoClass = \App\Support\HallBookedBoothGroups::overlayLogoClass($segmentWidth, $segmentHeight);
    $boothNumbers = $group['booth_numbers'] ?? [];
    $overlayBg = $overlayBg ?? 'bg-[#777777] hover:bg-[#5f5f5f]';
    $selectedStyle = $selectedStyle ?? false;
@endphp

@if ($segmentIndex === 0)
    <span class="{{ $logoClass }}">
        @if (! empty($group['logo_url']))
            <img src="{{ $group['logo_url'] }}" alt="{{ $companyName }}" class="h-full w-full object-cover" onerror="this.remove(); this.parentElement.textContent='{{ $companyInitial }}';">
        @else
            {{ $companyInitial }}
        @endif
    </span>
    <span class="{{ $labelClass }}" title="{{ $companyName }}">{{ $companyName }}</span>
@endif
