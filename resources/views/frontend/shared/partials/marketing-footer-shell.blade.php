@once
  @include('frontend.shared.partials.site-footer-styles')
@endonce

@php
    $footerPage = $footerPage ?? 'home';
    $footer = $footer ?? \App\Support\WebsiteContent::footer($footerPage);
@endphp

<section class="marketing-footer-shell {{ $footerPage !== 'home' ? 'marketing-footer-shell--edge-to-edge' : '' }}">
    @include('frontend.shared.partials.site-footer', [
        'footer' => $footer,
        'footerPage' => $footerPage,
    ])
</section>
