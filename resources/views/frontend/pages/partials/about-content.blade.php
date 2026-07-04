@php
    $aboutHero = $aboutHero ?? \App\Support\WebsiteContent::aboutHero();
    $sectionHeadings = $sectionHeadings ?? \App\Support\WebsiteContent::aboutSectionHeadings();
    $values = $values ?? \App\Support\WebsiteContent::aboutValues();
    $stats = $stats ?? \App\Support\WebsiteContent::aboutStats();
    $milestones = $milestones ?? \App\Support\WebsiteContent::aboutMilestones();
    $partners = $partners ?? \App\Support\WebsiteContent::aboutPartners();
@endphp

<div class="ap-hero">
  <div class="ap-hero-inner ap-container">
    <div class="ap-hero-copy">
      <span class="ap-eyebrow-hero"><span class="dot"></span>{{ $aboutHero['eyebrow'] ?? 'About eproexpo' }}</span>
      <h1>{{ $aboutHero['title'] ?? 'Connecting the world through events & exhibitions' }}</h1>
      <p>{{ $aboutHero['subtitle'] ?? '' }}</p>
    </div>
    <div class="ap-hero-cta">
      <a href="{{ $aboutHero['button_1_url'] ?? route('events.home') }}" class="ap-btn-white">{{ $aboutHero['button_1_label'] ?? 'Explore Events' }}</a>
      <a href="{{ $aboutHero['button_2_url'] ?? route('frontend.features') }}" class="ap-btn-outline">{{ $aboutHero['button_2_label'] ?? 'View Features' }}</a>
    </div>
    <div class="ap-hero-stats">
      @foreach ($stats as $stat)
        <div class="ap-hero-stat">
          <strong>{{ $stat['title'] ?? '' }}</strong>
          <span>{{ $stat['subtitle'] ?? '' }}</span>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="ap-container ap-lift">
  <div class="ap-cards-row">
    @foreach ($values as $value)
      <div class="ap-icard">
        <div class="ap-icn" style="color: {{ $value['color'] ?? '#6D28D9' }}; background: {{ ($value['color'] ?? '#6D28D9') }}18;">
          <i class="{{ $value['icon'] ?? 'far fa-circle' }}"></i>
        </div>
        <h3>{{ $value['title'] ?? '' }}</h3>
        <p>{{ $value['body'] ?? '' }}</p>
      </div>
    @endforeach
  </div>
</div>

<div class="ap-section">
  <div class="ap-container">
    <div class="ap-sec-head">
      <span class="ap-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['stats_eyebrow'] ?? 'By the Numbers' }}</span>
      <h2>{{ $sectionHeadings['stats_title'] ?? 'Platform at a glance' }}</h2>
    </div>
    <div class="ap-stat-strip">
      @foreach ($stats as $stat)
        <div class="ap-stat-cell">
          <strong>{{ $stat['title'] ?? '' }}</strong>
          <span>{{ $stat['subtitle'] ?? '' }}</span>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="ap-section tint">
  <div class="ap-container">
    <div class="ap-sec-head">
      <span class="ap-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['journey_eyebrow'] ?? 'Our Journey' }}</span>
      <h2>{{ $sectionHeadings['journey_title'] ?? 'Building the future of connected events' }}</h2>
    </div>
    <div class="ap-journey">
      @foreach ($milestones as $milestone)
        <div class="ap-jrow">
          <div class="yr">{{ $milestone['year'] ?? '' }}</div>
          <div>
            <h4>{{ $milestone['title'] ?? '' }}</h4>
            <p>{{ $milestone['body'] ?? '' }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="ap-section">
  <div class="ap-container">
    <div class="ap-sec-head ap-sec-head-compact">
      <h2>{{ $sectionHeadings['partners_title'] ?? 'Trusted by organisations worldwide' }}</h2>
    </div>
    <div class="ap-trust-strip">
      @foreach ($partners as $partner)
        <span>{{ $partner['title'] ?? '' }}</span>
      @endforeach
    </div>
  </div>
</div>

<div id="contact" class="ap-bottom-cta">
  <span class="ap-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['cta_eyebrow'] ?? 'Get connected' }}</span>
  <h2>{{ $aboutHero['cta_title'] ?? 'Connect. Explore. Engage.' }}</h2>
  <p>{{ $aboutHero['cta_subtitle'] ?? '' }}</p>
  <div class="ap-hero-cta">
    <a href="{{ $aboutHero['cta_button_1_url'] ?? $aboutHero['button_1_url'] ?? route('events.home') }}" class="ap-btn-white">{{ $aboutHero['cta_button_1_label'] ?? $aboutHero['button_1_label'] ?? 'Explore Events' }}</a>
    <a href="{{ $aboutHero['cta_button_2_url'] ?? $aboutHero['button_2_url'] ?? route('frontend.features') }}" class="ap-btn-outline">{{ $aboutHero['cta_button_2_label'] ?? $aboutHero['button_2_label'] ?? 'View Features' }}</a>
  </div>
</div>
