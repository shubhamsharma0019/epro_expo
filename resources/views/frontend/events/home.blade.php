@php
    $pageHero = \App\Support\WebsiteContent::hero('events');
    $pageSections = \App\Support\WebsiteContent::eventsSections();
    $footer = \App\Support\WebsiteContent::footer('events');
    $events = $events ?? [];
    $categories = $categories ?? [];
    $countries = $countries ?? [];
    $heroSlides = $heroSlides ?? [];
    $heroMeta = $heroMeta ?? ['event_count' => 0, 'category_count' => 0, 'country_count' => 0];
    $slots = $slots ?? [];
    $featuredEvent = $featuredEvent ?? ($events[0] ?? null);
    $carouselId = 'events-hero-carousel';

    $visitorSteps = \App\Support\WebsiteContent::sectionOrDefaults(
        'events',
        'step',
        \App\Support\WebsiteContent::defaultEventsSteps()
    );

    $heroSubtitle = ($heroMeta['event_count'] ?? 0) > 0
        ? str_replace(
            ['{event_count}', '{category_count}', '{country_count}'],
            [
                number_format($heroMeta['event_count']),
                (string) max(1, $heroMeta['category_count'] ?? 0),
                (string) max(1, $heroMeta['country_count'] ?? 0),
            ],
            $pageHero['subtitle_template'] ?? $pageHero['subtitle']
        )
        : ($pageHero['subtitle'] ?? '');

    $pageTitle = $pageSections['page_title'] ?? ($pageHero['page_title'] ?? 'eproexpo — Discover Events. Book Tickets. Join Live.');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  @include('frontend.shared.partials.home-brand-styles')
  @include('frontend.shared.partials.site-navbar-styles')
  <style>
    #event-home-page {
      --events-hero-gradient: {{ $pageHero['hero_gradient'] ?? 'linear-gradient(135deg, #F6F3FF 0%, #EFE9FE 30%, #F8FAFF 68%, #FFFFFF 100%)' }};
      --events-page-font: {{ $pageHero['page_font_family'] ?? 'Inter, sans-serif' }};
      --events-heading-font: {{ $pageHero['heading_font_family'] ?? 'Inter, sans-serif' }};
      --events-nav-font: {{ $pageHero['nav_font_family'] ?? 'Inter, sans-serif' }};
      --events-nav-size: {{ $pageHero['nav_font_size'] ?? '14px' }};
      --events-nav-weight: {{ $pageHero['nav_font_weight'] ?? '600' }};
      --events-hero-heading: {{ $pageHero['hero_heading_color'] ?? '#071044' }};
      --events-hero-accent: {{ $pageHero['hero_accent_color'] ?? '#6D28D9' }};
      --events-hero-body: {{ $pageHero['hero_body_color'] ?? '#1F2B55' }};
      --events-hero-eyebrow-bg: {{ $pageHero['hero_eyebrow_bg'] ?? 'rgba(109, 40, 217, 0.08)' }};
      --events-hero-eyebrow-color: {{ $pageHero['hero_eyebrow_color'] ?? '#6D28D9' }};
      --events-hero-eyebrow-border: {{ $pageHero['hero_eyebrow_border'] ?? 'rgba(109, 40, 217, 0.18)' }};
    }
  </style>
  @include('frontend.events.partials.home.events-home-styles')
  @include('frontend.events.partials.home.mobile-styles')
  @include('frontend.shared.partials.responsive-fixes')
</head>
<body id="event-home-page">

@include('frontend.shared.partials.site-navbar', [
    'activeNav' => 'events',
    'menuId' => 'eventsNav',
])

<div class="hero">
  <div class="hero-inner">
    <div class="hero-grid">
      <div class="hero-copy">
        <span class="hero-eyebrow"><span class="dot"></span>{{ $pageHero['eyebrow'] ?? 'Live events, near you' }}</span>
        <h1>
          {{ $pageHero['title_line_1'] ?? 'Discover' }} <span class="accent">{{ $pageHero['title_accent_1'] ?? 'Events.' }}</span><br>
          {{ $pageHero['title_line_2'] ?? 'Book' }} <span class="accent">{{ $pageHero['title_accent_2'] ?? 'Tickets.' }}</span><br>
          {{ $pageHero['title_line_3'] ?? 'Join Live.' }}
        </h1>
        <p>{{ $heroSubtitle }}</p>
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
      <span class="active">{{ $pageSections['search_tab_events'] ?? 'Events' }}</span>
      <a href="{{ route('exhibitions.index') }}">{{ $pageSections['search_tab_exhibitions'] ?? 'Exhibitions' }}</a>
    </div>
    <form action="{{ route('events.listings.index') }}" method="GET" class="search-fields">
      <div class="field">
        <label for="events-search">{{ $pageSections['search_label'] ?? 'Search Events' }}</label>
        <input id="events-search" type="text" name="search" value="{{ request('search') }}" placeholder="{{ $pageSections['search_placeholder'] ?? 'Search events, organisers...' }}">
      </div>
      <div class="field">
        <label for="events-category">{{ $pageSections['category_label'] ?? 'Category' }}</label>
        <select id="events-category" name="category">
          <option value="">{{ $pageSections['category_all'] ?? 'All Categories' }}</option>
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
        <label for="events-country">{{ $pageSections['country_label'] ?? 'Country' }}</label>
        <select id="events-country" name="country">
          <option value="">{{ $pageSections['country_all'] ?? 'All Countries' }}</option>
          @foreach ($countries as $country)
            @php $countryName = is_array($country) ? ($country['name'] ?? '') : $country; @endphp
            @if ($countryName)
              <option value="{{ $countryName }}">{{ $countryName }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="events-date">{{ $pageSections['date_label'] ?? 'Date' }}</label>
        <input id="events-date" type="text" name="date" value="{{ request('date') }}" placeholder="{{ $pageSections['date_placeholder'] ?? 'mm/dd/yyyy' }}">
      </div>
      <button type="submit" class="search-btn">{{ $pageSections['search_button'] ?? 'Search Events' }}</button>
    </form>
  </div>

  <div class="section">
    <div class="sec-headrow">
      <h2>{{ $pageSections['categories_title'] ?? 'Browse Events by Category' }}</h2>
      <a href="{{ url($pageSections['categories_link_url'] ?? '/events/listings/categories') }}">{{ $pageSections['categories_link'] ?? 'View All Categories →' }}</a>
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
        <p>{{ $pageSections['empty_categories_title'] ?? 'No categories yet' }}</p>
        <span>{{ $pageSections['empty_categories_body'] ?? 'Published events will populate categories automatically.' }}</span>
      </div>
    @endif
  </div>

  <div class="section" style="padding-top:0;">
    <div class="sec-headrow">
      <h2>{{ $pageSections['trending_title'] ?? 'Trending Events' }}</h2>
      <a href="{{ route('events.listings.index') }}">{{ $pageSections['trending_link'] ?? 'View All Events →' }}</a>
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
        <p>{{ $pageSections['empty_events_title'] ?? 'No published events yet' }}</p>
        <span>{{ $pageSections['empty_events_body'] ?? 'Published company events will appear here automatically.' }}</span>
      </div>
    @endif
  </div>

  <div class="section" style="padding-top:0; padding-bottom:80px;">
    <div class="split-grid">
      <div>
        <div class="sec-headrow" style="margin-bottom:22px;"><h2>{{ $pageSections['how_it_works_title'] ?? 'How It Works' }}</h2></div>
        <div class="steps">
          @foreach ($visitorSteps as $index => $step)
            <div class="step-row">
              <div class="num">{{ $index + 1 }}</div>
              <div>
                <h5>{{ $step['title'] ?? '' }}</h5>
                <p>{{ $step['body'] ?? '' }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="icard">
        <h3>{{ $pageSections['slots_title'] ?? 'Ticket Booking & Slots' }}</h3>
        <div class="ticket-event">{{ $featuredEvent['title'] ?? ($pageSections['slots_fallback_event'] ?? 'Upcoming Events') }}</div>
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
              <p>{{ $pageSections['empty_slots_title'] ?? 'No ticket slots available yet' }}</p>
              <span>{{ $pageSections['empty_slots_body'] ?? 'Published events with dates will appear here.' }}</span>
            </div>
          @endforelse
        </div>
        <a href="{{ route('events.listings.index') }}" class="book-btn">{{ $pageSections['slots_cta'] ?? 'View More Slots' }}</a>
      </div>
    </div>
  </div>
</div>

    @include('frontend.shared.partials.marketing-footer-shell', ['footerPage' => 'events'])

<script>
  (() => {
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
