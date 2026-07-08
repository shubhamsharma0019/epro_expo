@once
  @include('frontend.shared.partials.site-footer-styles')
@endonce

@php
    $footerPage = $footerPage ?? 'home';
    $footer = $footer ?? \App\Support\WebsiteContent::footer($footerPage);
@endphp

<footer class="home-footer-wrap">
  <div class="home-footer-wrap__inner">
    <div class="home-footer-wrap__brand">
      <a href="{{ route('home') }}" class="home-footer-logo" aria-label="eproexpo home">
        <span class="home-footer-logo__mark">e</span>
        <span class="home-footer-logo__text">
          <span class="home-footer-logo__title">epro<span>expo</span></span>
          <span class="home-footer-logo__subtitle">EXHIBITOR SUITE</span>
        </span>
      </a>
    </div>
    <p class="home-footer-wrap__copyright">{{ $footer['copyright'] ?? ('© ' . date('Y') . ' eproexpo. All rights reserved.') }}</p>
    <div class="home-footer-wrap__links">
      @foreach (($footer['links'] ?? []) as $link)
        <a href="{{ $link['link_url'] ?? '#' }}">{{ $link['title'] ?? '' }}</a>
      @endforeach
      @if (! empty($footer['contact_email']))
        <a href="mailto:{{ $footer['contact_email'] }}">{{ $footer['contact_email'] }}</a>
      @endif
    </div>
    <div class="home-footer-wrap__social">
      @foreach (($footer['social'] ?? []) as $social)
        <a href="{{ $social['link_url'] ?? '#' }}" aria-label="Social link">
          <i class="{{ $social['icon'] ?? 'fab fa-linkedin-in' }}"></i>
        </a>
      @endforeach
    </div>
  </div>
</footer>

