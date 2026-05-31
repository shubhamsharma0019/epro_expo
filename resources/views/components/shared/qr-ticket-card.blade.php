@props([
    'src',
    'alt' => 'Ticket QR code',
    'label' => 'SCAN AT ENTRY',
    'sizeClass' => 'h-[236px] w-[236px]',
    'cardClass' => '',
])

<div {{ $attributes->merge(['class' => 'inline-flex flex-col items-center rounded-[32px] border border-[#DDE3F1] bg-white px-6 pb-7 pt-6 text-center shadow-[0_18px_48px_rgba(7,16,68,0.08)] ' . $cardClass]) }}>
    <div class="rounded-[26px] bg-[#F8FAFF] p-4 shadow-inner">
        <img src="{{ $src }}" alt="{{ $alt }}" class="{{ $sizeClass }} rounded-[14px] bg-white object-contain">
    </div>
    <p class="mt-6 text-[13px] font-extrabold uppercase tracking-[0.32em] text-[#4E567A]">{{ $label }}</p>
</div>
