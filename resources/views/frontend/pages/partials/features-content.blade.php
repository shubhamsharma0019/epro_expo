@php
    $featuresHero = $featuresHero ?? \App\Support\WebsiteContent::featuresHero();
    $sectionHeadings = $sectionHeadings ?? \App\Support\WebsiteContent::featuresSectionHeadings();
    $features = $features ?? \App\Support\WebsiteContent::sectionOrDefaults('home', 'feature', \App\Support\WebsiteContent::defaultFeatures());
    $featurePills = $featurePills ?? \App\Support\WebsiteContent::sectionOrDefaults('home', 'feature_pill', \App\Support\WebsiteContent::defaultFeaturePills());
    $steps = $steps ?? \App\Support\WebsiteContent::sectionOrDefaults('home', 'step', \App\Support\WebsiteContent::defaultSteps());
    $flowCards = $flowCards ?? \App\Support\WebsiteContent::sectionOrDefaults('home', 'flow_card', \App\Support\WebsiteContent::defaultFlowCards());
    $primaryFeatures = array_slice($features, 0, 3);
    $audienceFeatures = array_slice($features, 3);
    $resolveFlowUrl = function (array $card) {
        if (! empty($card['link_url'])) {
            return $card['link_url'];
        }

        $route = $card['route'] ?? ($card['meta']['route'] ?? null);
        if ($route) {
            try {
                return route($route);
            } catch (\Throwable) {
                return url('/');
            }
        }

        return url('/');
    };
@endphp

<div class="hf-hero">
  <div class="hf-hero-inner hf-container">
    <div class="hf-hero-copy">
      <span class="hf-eyebrow-hero"><span class="dot"></span>{{ $featuresHero['eyebrow'] ?? 'Platform features' }}</span>
      <h1>{{ $featuresHero['title'] ?? 'Everything you need to run events & exhibitions' }}</h1>
      <p>{{ $featuresHero['subtitle'] ?? '' }}</p>
    </div>
    <div class="hf-hero-cta">
      <a href="{{ $featuresHero['button_1_url'] ?? route('events.home') }}" class="hf-btn-white">{{ $featuresHero['button_1_label'] ?? 'Explore Events' }}</a>
      <a href="{{ $featuresHero['button_2_url'] ?? route('exhibitions.index') }}" class="hf-btn-outline">{{ $featuresHero['button_2_label'] ?? 'Browse Exhibitions' }}</a>
    </div>
    <div class="hf-hero-stats">
      @foreach ($featurePills as $pill)
        <a href="{{ $pill['link_url'] ?? route('exhibitions.index') }}" class="hf-hero-stat">
          <strong><i class="{{ $pill['icon'] ?? 'far fa-circle' }}"></i></strong>
          <span>{{ $pill['title'] ?? '' }}</span>
        </a>
      @endforeach
    </div>
  </div>
</div>

<div class="hf-container hf-lift">
  <div class="hf-cards-row">
    @foreach ($primaryFeatures as $feature)
      <div class="hf-icard">
        <div class="hf-icn" style="color: {{ $feature['color'] ?? '#6D28D9' }}; background: {{ ($feature['color'] ?? '#6D28D9') }}18;">
          <i class="{{ $feature['icon'] ?? 'far fa-circle' }}"></i>
        </div>
        <h4>{!! nl2br(e($feature['title'] ?? '')) !!}</h4>
        <p>{{ $feature['body'] ?? '' }}</p>
      </div>
    @endforeach
  </div>
</div>

<div class="hf-section">
  <div class="hf-container">
    <div class="hf-sec-head">
      <span class="hf-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['audience_eyebrow'] ?? 'Built for every audience' }}</span>
      <h2>{{ $sectionHeadings['audience_title'] ?? 'Tools tuned to real event experiences' }}</h2>
      <p>{{ $sectionHeadings['audience_subtitle'] ?? '' }}</p>
    </div>
    <div class="hf-grid-3">
      @foreach ($audienceFeatures as $feature)
        <div class="hf-icard">
          <div class="hf-icn" style="color: {{ $feature['color'] ?? '#6D28D9' }}; background: {{ ($feature['color'] ?? '#6D28D9') }}18;">
            <i class="{{ $feature['icon'] ?? 'far fa-circle' }}"></i>
          </div>
          <h4>{!! nl2br(e($feature['title'] ?? '')) !!}</h4>
          <p>{{ $feature['body'] ?? '' }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="hf-section tint">
  <div class="hf-container">
    <div class="hf-sec-head">
      <span class="hf-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['steps_eyebrow'] ?? 'How it works' }}</span>
      <h2>{{ $sectionHeadings['steps_title'] ?? 'From setup to a live event, in four steps' }}</h2>
    </div>
    <div class="hf-steps-row">
      @foreach ($steps as $index => $step)
        <div class="hf-step-card">
          <div class="num">{{ str_pad((string) ($step['meta']['step'] ?? $step['step'] ?? ($index + 1)), 2, '0', STR_PAD_LEFT) }}</div>
          <h5>{{ $step['title'] ?? '' }}</h5>
          <p>{{ $step['body'] ?? '' }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="hf-section">
  <div class="hf-container">
    <div class="hf-sec-head">
      <span class="hf-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['flows_eyebrow'] ?? 'User flows' }}</span>
      <h2>{{ $sectionHeadings['flows_title'] ?? 'Built for every role in the room' }}</h2>
    </div>
    <div class="hf-flow-grid">
      @foreach ($flowCards as $card)
        @php($flowHeadline = $card['meta']['headline'] ?? \Illuminate\Support\Str::before($card['body'] ?? '', '.'))
        <div class="hf-flow-card">
          <span class="tag">{{ $card['title'] ?? '' }}</span>
          <h4>{{ $flowHeadline }}</h4>
          <p>{{ $card['body'] ?? '' }}</p>
          <a href="{{ $resolveFlowUrl($card) }}">{{ $card['link_label'] ?? 'Learn more' }} →</a>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="hf-bottom-cta">
  <span class="hf-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['cta_eyebrow'] ?? 'Get started' }}</span>
  <h2>{{ $featuresHero['cta_title'] ?? 'Ready to explore the platform?' }}</h2>
  <p>{{ $featuresHero['cta_subtitle'] ?? '' }}</p>
  <div class="hf-hero-cta">
    <a href="{{ route('events.home') }}" class="hf-btn-white">Explore Events</a>
    <a href="{{ route('exhibitions.index') }}" class="hf-btn-outline">Browse Exhibitions</a>
  </div>
</div>
