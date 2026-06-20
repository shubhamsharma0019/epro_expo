@props([
    'value',
    'label',
    'icon' => 'fa-solid fa-chart-simple',
    'iconBg' => 'bg-[#EFF2FF]',
    'iconColor' => 'text-[#3B66FF]',
])

<div {{ $attributes->merge(['class' => 'flex min-h-[210px] flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_1px_3px_rgba(15,23,42,0.08)] transition-shadow hover:shadow-md']) }}>
    <div class="mb-10 flex h-14 w-14 items-center justify-center rounded-2xl {{ $iconBg }} {{ $iconColor }}">
        <i class="{{ $icon }} text-[28px]"></i>
    </div>
    <div>
        <h3 class="mb-1 text-[26px] font-extrabold text-[#020A2D]">{{ $value }}</h3>
        <p class="text-[14px] font-medium text-[#52607A]">{{ $label }}</p>
    </div>
</div>
