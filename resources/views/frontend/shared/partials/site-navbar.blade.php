@php
    $activeNav = $activeNav ?? null;
    $menuId = $menuId ?? 'siteNav';
    $navActiveClass = fn (string $key): string => $activeNav === $key ? 'is-active' : '';
    $bookBoothLabel = $bookBoothLabel ?? 'Book a Booth';
    $bookBoothUrl = $bookBoothUrl ?? null;
    $createEventLabel = $createEventLabel ?? 'Create Company Event';
    $createEventUrl = $createEventUrl ?? null;
@endphp

<header class="site-navbar">
  <div class="site-navbar__inner">
    <x-shared.home-brand-logo size="header" />

    <nav class="site-navbar__links" aria-label="Primary">
      <a href="{{ route('events.home') }}" @class([$navActiveClass('events')])>Explore Events</a>
      <a href="{{ route('exhibitions.index') }}" @class([$navActiveClass('exhibitions')])>Exhibitions</a>
      <a href="{{ route('frontend.features') }}" @class([$navActiveClass('features')])>Features</a>
      <a href="{{ route('frontend.pricing') }}" @class([$navActiveClass('pricing')])>Pricing</a>
      <a href="{{ route('frontend.about') }}" @class([$navActiveClass('about')])>About Us</a>
    </nav>

    <div class="site-navbar__actions">
      @auth
        <a href="{{ route('frontend.user.dashboard') }}" class="site-navbar__login">My Dashboard</a>
      @else
        <a href="{{ route('frontend.user.login') }}" class="site-navbar__login">Log In</a>
      @endauth
      <div class="site-navbar__get-started">
        <x-frontend.get-started-menu
          :menu-id="$menuId"
          :book-booth-label="$bookBoothLabel"
          :book-booth-url="$bookBoothUrl"
          :create-event-label="$createEventLabel"
          :create-event-url="$createEventUrl"
        />
      </div>
      <button
        type="button"
        class="site-navbar__menu-btn"
        data-site-nav-toggle="{{ $menuId }}"
        aria-label="Open menu"
        aria-expanded="false"
        aria-controls="site-nav-mobile-{{ $menuId }}"
      >
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>

  <div
    id="site-nav-mobile-{{ $menuId }}"
    class="site-navbar__mobile"
    data-site-nav-menu="{{ $menuId }}"
  >
    <a href="{{ route('events.home') }}" @class([$navActiveClass('events')])>Explore Events</a>
    <a href="{{ route('exhibitions.index') }}" @class([$navActiveClass('exhibitions')])>Exhibitions</a>
    <a href="{{ route('frontend.features') }}" @class([$navActiveClass('features')])>Features</a>
    <a href="{{ route('frontend.pricing') }}" @class([$navActiveClass('pricing')])>Pricing</a>
    <a href="{{ route('frontend.about') }}" @class([$navActiveClass('about')])>About Us</a>
    @auth
      <a href="{{ route('frontend.user.dashboard') }}">My Dashboard</a>
    @else
      <a href="{{ route('frontend.user.login') }}">Log In</a>
      <a href="{{ route('frontend.user.register') }}">Sign Up</a>
    @endauth
    <div class="site-navbar__get-started-mobile">
      <x-frontend.get-started-menu
        variant="mobile"
        :menu-id="$menuId . 'Mobile'"
        :book-booth-label="$bookBoothLabel"
        :book-booth-url="$bookBoothUrl"
        :create-event-label="$createEventLabel"
        :create-event-url="$createEventUrl"
      />
    </div>
  </div>
</header>

@once
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('[data-site-nav-toggle]').forEach((button) => {
        const menuId = button.getAttribute('data-site-nav-toggle');
        const menu = document.querySelector(`[data-site-nav-menu="${menuId}"]`);

        if (!menu) {
          return;
        }

        const closeMenu = () => {
          menu.classList.remove('open');
          button.setAttribute('aria-expanded', 'false');
        };

        button.addEventListener('click', () => {
          const isOpen = menu.classList.toggle('open');
          button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        menu.querySelectorAll('a').forEach((link) => {
          link.addEventListener('click', closeMenu);
        });
      });
    });
  </script>
@endonce
