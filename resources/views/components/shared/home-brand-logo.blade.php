@props([
    'href' => route('home'),
    'subtitle' => 'EXHIBITOR SUITE',
    'size' => 'header',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "home-brand home-brand--{$size}"]) }}>
    <span class="home-brand__mark" aria-hidden="true">e</span>
    <span class="home-brand__copy">
        <span class="home-brand__title">epro<span class="home-brand__accent">expo</span></span>
        @if ($subtitle !== '')
            <span class="home-brand__subtitle">{{ $subtitle }}</span>
        @endif
    </span>
</a>
