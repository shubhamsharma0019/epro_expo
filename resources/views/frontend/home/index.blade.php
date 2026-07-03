@php
    $home = $home ?? [];
    $hero = $home['hero'] ?? \App\Support\WebsiteContent::defaultHero();
    $footer = $home['footer'] ?? \App\Support\WebsiteContent::defaultFooter();
    $events = $events ?? [];
    $categories = $categories ?? [];
    $countries = $countries ?? [];
    $heroSlides = $heroSlides ?? [];
    $heroMeta = $heroMeta ?? ['event_count' => 0, 'category_count' => 0, 'country_count' => 0];
    $slots = $slots ?? [];
    $featuredEvent = $events[0] ?? null;
    $carouselId = 'home-hero-carousel';

    $visitorSteps = [
        ['Find Your Event', 'Browse events by category, location, or specific topics.'],
        ['Choose Your Slot', 'Select your preferred time slot for available dates.'],
        ['Book & Pay', 'Secure your spot with a quick and safe checkout.'],
        ['Get Your Ticket', 'Receive your e-ticket instantly and enjoy the show.'],
    ];

    if (empty($heroSlides)) {
        $heroSlides = [
            ['image' => asset('images/events-home/hero-slider/event-hero-tech.png'), 'alt' => 'Technology event hero', 'href' => route('events.listings.index')],
            ['image' => asset('images/events-home/hero-slider/event-hero-ai.png'), 'alt' => 'AI conference hero', 'href' => route('events.listings.index')],
            ['image' => asset('images/events-home/hero-slider/event-hero-education.png'), 'alt' => 'Education summit hero', 'href' => route('events.listings.index')],
        ];
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eproexpo — Discover Events. Book Tickets. Join Live.</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  @include('frontend.home.partials.home-styles')
  @include('frontend.home.partials.mobile-styles')
  @include('frontend.shared.partials.responsive-fixes')
</head>
<body id="home-page">

<div class="topbar">
  <div class="container nav-pill">
    <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-8 w-8 rounded-full text-[14px]" title-class="text-[19px] text-[#171522]" subtitle-class="text-[9px] text-[#6B6884]" />

    <div class="nav-links">
      <a href="{{ route('events.home') }}">Explore Events</a>
      <a href="{{ route('exhibitions.index') }}">Exhibitions</a>
      <a href="{{ route('frontend.features') }}">Features</a>
      <a href="{{ route('frontend.pricing') }}">Pricing</a>
      <a href="{{ route('frontend.about') }}">About Us</a>
    </div>

    <div class="nav-actions">
      <div class="get-started-desktop">
        <x-frontend.get-started-menu
          menu-id="homeGetStarted"
          :book-booth-label="$hero['button_3_label'] ?? 'Book a Booth'"
          :book-booth-url="$hero['button_3_url'] ?? null"
          :create-event-label="$hero['button_4_label'] ?? 'Create Company Event'"
          :create-event-url="$hero['button_4_url'] ?? null"
        />
      </div>
      <button type="button" class="menu-btn" id="menuBtn" aria-label="Open menu">&#9776;</button>
    </div>
  </div>

  <div class="container mobile-menu" id="mobileMenu">
    <a href="{{ route('events.home') }}">Explore Events</a>
    <a href="{{ route('exhibitions.index') }}">Exhibitions</a>
    <a href="{{ route('frontend.features') }}">Features</a>
    <a href="{{ route('frontend.pricing') }}">Pricing</a>
    <a href="{{ route('frontend.about') }}">About Us</a>
    <div class="get-started-mobile">
      <x-frontend.get-started-menu
        variant="mobile"
        :book-booth-label="$hero['button_3_label'] ?? 'Book a Booth'"
        :book-booth-url="$hero['button_3_url'] ?? null"
        :create-event-label="$hero['button_4_label'] ?? 'Create Company Event'"
        :create-event-url="$hero['button_4_url'] ?? null"
      />
    </div>
  </div>
</div>

<div class="hero">
  <div class="hero-inner">
    <div class="hero-grid">
      <div class="hero-copy">
        <span class="hero-eyebrow"><span class="dot"></span>Live events, near you</span>
        <h1>Discover <span class="accent">Events.</span><br>Book <span class="accent">Tickets.</span><br>Join Live.</h1>
        <p>
          @if (($heroMeta['event_count'] ?? 0) > 0)
            Explore {{ number_format($heroMeta['event_count']) }} live events across {{ max(1, $heroMeta['category_count'] ?? 0) }} categories and {{ max(1, $heroMeta['country_count'] ?? 0) }} countries. Book your tickets and get access to live sessions as per available slots.
          @else
            Explore events across categories and countries. Book your tickets and get access to live sessions as per available slots.
          @endif
        </p>
      </div>

      <div class="hero-visual">
        <div class="visual-card" id="{{ $carouselId }}">
          @foreach ($heroSlides as $index => $slide)
            <a href="{{ $slide['href'] ?? route('events.listings.index') }}" class="visual-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
              <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] ?? 'Featured event' }}">
            </a>
          @endforeach
          @if (count($heroSlides) === 0)
            <div class="visual-slide-fallback"></div>
          @endif
          <div class="visual-glow"></div>
        </div>
        @if (count($heroSlides) > 1)
          <button type="button" class="visual-arrow left" data-carousel-prev="{{ $carouselId }}" aria-label="Previous slide">&#8249;</button>
          <button type="button" class="visual-arrow right" data-carousel-next="{{ $carouselId }}" aria-label="Next slide">&#8250;</button>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="container lift">
  <div class="search-card">
    <div class="search-tabs">
      <span class="active">Events</span>
      <a href="{{ route('exhibitions.index') }}">Virtual Exhibitions</a>
    </div>
    <form action="{{ route('events.listings.index') }}" method="GET" class="search-fields">
      <div class="field">
        <label for="home-search">Search Events</label>
        <input id="home-search" type="text" name="search" placeholder="Event name, speaker, topic...">
      </div>
      <div class="field">
        <label for="home-category">Category</label>
        <select id="home-category" name="category">
          <option value="">All Categories</option>
          @foreach ($categories as $category)
            @php
              $categoryName = is_array($category) ? ($category['name'] ?? '') : $category;
              $categoryValue = is_array($category) ? ($category['value'] ?? $categoryName) : $category;
            @endphp
            @if ($categoryName)
              <option value="{{ $categoryValue }}">{{ $categoryName }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="home-country">Country</label>
        <select id="home-country" name="country">
          <option value="">All Countries</option>
          @foreach ($countries as $country)
            @php $countryName = is_array($country) ? ($country['name'] ?? '') : $country; @endphp
            @if ($countryName)
              <option value="{{ $countryName }}">{{ $countryName }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="home-date">Date</label>
        <input id="home-date" type="date" name="date">
      </div>
      <button type="submit" class="search-btn">Search Events</button>
    </form>
  </div>

  <div class="section">
    <div class="sec-headrow">
      <h2>Browse Events by Category</h2>
      <a href="{{ url('/events/listings/categories') }}">View All Categories &rarr;</a>
    </div>
    @if (count($categories) > 0)
      <div class="cat-grid">
        @foreach ($categories as $category)
          <a href="{{ route('events.listings.index', ['category' => $category['value'] ?? $category['name']]) }}" class="cat-tile">
            <div class="icn">
              <img src="{{ asset('images/events-home/categories/' . ($category['icon'] ?? 'business.svg')) }}" alt="{{ $category['name'] }}">
            </div>
            <span>{{ $category['name'] }}</span>
          </a>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <p>No categories yet</p>
        <span>Published events will populate categories automatically.</span>
      </div>
    @endif
  </div>

  <div class="section" style="padding-top:0;">
    <div class="sec-headrow">
      <h2>Trending Events</h2>
      <a href="{{ route('events.listings.index') }}">View All Events &rarr;</a>
    </div>
    @if (count($events) > 0)
      <div class="trend-grid">
        @foreach ($events as $event)
          @php
            $eventSlug = $event['slug'] ?? \Illuminate\Support\Str::slug($event['title'] ?? 'event');
            $isLive = in_array($event['badge'] ?? '', ['Live Now', 'LIVE', 'Live'], true);
            $eventImage = $event['imageUrl'] ?? null;
            $eventUrl = url('/events/listings/' . $eventSlug);
          @endphp
          <article class="event-card">
            <a href="{{ $eventUrl }}" class="event-img">
              @if ($eventImage)
                <img src="{{ $eventImage }}" alt="{{ $event['title'] }}">
              @else
                <div class="event-img-fallback"></div>
              @endif
              @if ($isLive)
                <span class="live-badge"><span class="dot"></span>LIVE</span>
              @endif
            </a>
            <div class="event-body">
              <h3>{{ $event['title'] }}</h3>
              <div class="meta">
                <span>&#128197; {{ $event['date'] }}</span>
                <span>&#128205; {{ $event['country'] }}</span>
              </div>
              <div class="price-row">
                <div class="price">{{ $event['price'] }}<small> / ticket</small></div>
                <a href="{{ $eventUrl }}" class="view-btn">View Event &rarr;</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <p>No published events yet</p>
        <span>Published company events will appear here automatically.</span>
      </div>
    @endif
  </div>

  <div class="section" style="padding-top:0; padding-bottom:80px;">
    <div class="split-grid">
      <div>
        <div class="sec-headrow" style="margin-bottom:22px;"><h2>How It Works</h2></div>
        <div class="steps">
          @foreach ($visitorSteps as $index => $step)
            <div class="step-row">
              <div class="num">{{ $index + 1 }}</div>
              <div>
                <h5>{{ $step[0] }}</h5>
                <p>{{ $step[1] }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="icard">
        <h3>Ticket Booking &amp; Slots</h3>
        <div class="ticket-event">{{ $featuredEvent['title'] ?? 'Upcoming Events' }}</div>
        <div class="slot-list">
          @forelse ($slots as $slot)
            <a href="{{ $slot['href'] ?? route('events.listings.index') }}" class="slot-row">
              <div>
                <div class="l">{{ $slot['time'] }}</div>
                <div class="p">{{ $slot['price'] }}</div>
              </div>
              <span class="tag">{{ $slot['seats'] }}</span>
            </a>
          @empty
            <div class="empty-state" style="padding:20px 16px;">
              <p>No ticket slots available yet</p>
              <span>Published events with dates will appear here.</span>
            </div>
          @endforelse
        </div>
        <a href="{{ route('events.listings.index') }}" class="book-btn">View More Slots</a>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container footer-inner">
    <div class="footer-brand">
      <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-8 w-8 rounded-full text-[14px]" title-class="text-[19px] brand-title" subtitle-class="text-[9px] brand-subtitle" />
    </div>
    <div class="foot-links">
      <a href="{{ route('events.home') }}">Explore Events</a>
      <a href="{{ route('exhibitions.index') }}">Exhibitions</a>
      <a href="{{ route('frontend.features') }}">Features</a>
      <a href="{{ route('frontend.pricing') }}">Pricing</a>
      <a href="{{ route('frontend.about') }}">About Us</a>
      @foreach (($footer['links'] ?? []) as $link)
        <a href="{{ $link['link_url'] ?? '#' }}">{{ $link['title'] ?? '' }}</a>
      @endforeach
    </div>
    <span style="font-size:12px;">{{ $footer['copyright'] ?? '© ' . date('Y') . ' eproexpo. All rights reserved.' }}</span>
  </div>
</footer>

<script>
  (() => {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    menuBtn?.addEventListener('click', () => {
      mobileMenu?.classList.toggle('open');
    });

    mobileMenu?.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => mobileMenu.classList.remove('open'));
    });

    const carouselId = @json($carouselId);
    const carousel = document.getElementById(carouselId);
    if (!carousel) return;

    const slides = Array.from(carousel.querySelectorAll('.visual-slide'));
    if (slides.length <= 1) return;

    let current = 0;

    const showSlide = (index) => {
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => slide.classList.toggle('active', i === current));
    };

    document.querySelectorAll(`[data-carousel-prev="${carouselId}"]`).forEach((button) => {
      button.addEventListener('click', (event) => {
        event.preventDefault();
        showSlide(current - 1);
      });
    });

    document.querySelectorAll(`[data-carousel-next="${carouselId}"]`).forEach((button) => {
      button.addEventListener('click', (event) => {
        event.preventDefault();
        showSlide(current + 1);
      });
    });

    let autoSlide = window.setInterval(() => showSlide(current + 1), 3200);
    carousel.addEventListener('mouseenter', () => window.clearInterval(autoSlide));
    carousel.addEventListener('mouseleave', () => {
      autoSlide = window.setInterval(() => showSlide(current + 1), 3200);
    });
  })();
</script>
</body>
</html>
