@props([
    'href' => route('home'),
    'subtitle' => 'EXHIBITOR SUITE',
    'markClass' => 'h-11 w-11 rounded-[16px] text-[20px]',
    'titleClass' => 'text-[23px] text-[#071044]',
    'subtitleClass' => 'text-[11px] text-[#8A94AD]',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex min-w-0 items-center gap-3']) }}>
    <span class="flex shrink-0 items-center justify-center bg-gradient-to-br from-[#071044] to-[#5b2eff] font-bold leading-none text-white shadow-[0_14px_30px_rgba(7,16,68,0.18)] {{ $markClass }}">
        e
    </span>
    <span class="min-w-0 leading-none">
        <span class="block truncate font-extrabold tracking-[-0.035em] {{ $titleClass }}">
            epro<span class="text-[#246BFF]">expo</span>
        </span>
        <span class="mt-1 block truncate font-extrabold uppercase tracking-[0.16em] {{ $subtitleClass }}">
            {{ $subtitle }}
        </span>
    </span>
</a>
