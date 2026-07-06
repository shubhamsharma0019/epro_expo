@php
    $pricingHero = $pricingHero ?? \App\Support\WebsiteContent::pricingHero();
    $sectionHeadings = $sectionHeadings ?? \App\Support\WebsiteContent::pricingSectionHeadings();
    $plans = $plans ?? \App\Support\WebsiteContent::pricingPlans();
    $benefits = $benefits ?? \App\Support\WebsiteContent::pricingBenefits();
    $faqs = $faqs ?? \App\Support\WebsiteContent::pricingFaqs();
    $contactEmail = $pricingHero['contact_email'] ?? \App\Support\WebsiteContent::footer()['contact_email'] ?? 'hello@eproexpo.com';
@endphp

<div class="pp-hero">
  <div class="pp-hero-inner pp-container">
    <div class="pp-hero-copy">
      <span class="pp-eyebrow-hero"><span class="dot"></span>{{ $pricingHero['eyebrow'] ?? 'Simple pricing' }}</span>
      <h1>{{ $pricingHero['title'] ?? 'Flexible Pricing Plans' }}</h1>
      <p>{{ $pricingHero['subtitle'] ?? '' }}</p>
    </div>
    <div class="pp-toggle-wrap">
      <div class="pp-toggle-pill" role="tablist" aria-label="Pricing period">
        <button type="button" class="active" id="pp-tgl-event" role="tab" aria-selected="true">{{ $pricingHero['toggle_1_label'] ?? 'Per Event' }}</button>
        <button type="button" id="pp-tgl-annual" role="tab" aria-selected="false">{{ $pricingHero['toggle_2_label'] ?? 'Annual' }}</button>
      </div>
    </div>
  </div>
</div>

<div class="pp-container pp-lift">
  <div class="pp-cards-row">
    @foreach ($plans as $plan)
      <div @class(['pp-pcard', 'mid' => $plan['highlight']])>
        <div class="pp-icn"><i class="{{ $plan['icon'] ?? 'far fa-circle' }}"></i></div>
        <h3>{{ $plan['name'] ?? '' }}</h3>
        <p class="pp-pdesc">{{ $plan['description'] ?? '' }}</p>
        <div
          class="pp-price"
          data-event-price="{{ $plan['price'] ?? 'Custom' }}"
          data-event-period="{{ $plan['period'] ?? '/event' }}"
          data-annual-price="{{ $plan['annual_price'] ?? ($plan['price'] ?? 'Custom') }}"
          data-annual-period="{{ $plan['annual_period'] ?? '/year' }}"
        >
          <span class="pp-price-value">{{ $plan['price'] ?? 'Custom' }}</span><small class="pp-price-period"> {{ $plan['period'] ?? '/event' }}</small>
        </div>
        <ul>
          @foreach (($plan['features'] ?? []) as $feature)
            <li><span class="chk">✓</span>{{ $feature }}</li>
          @endforeach
        </ul>
        <span class="pp-pbtn">{{ $plan['button'] ?? 'Get Started' }}</span>
      </div>
    @endforeach
  </div>
</div>

<div class="pp-section">
  <div class="pp-container">
    <div class="pp-sec-head">
      <span class="pp-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['why_eyebrow'] ?? 'Why eproexpo' }}</span>
      <h2>{{ $sectionHeadings['why_title'] ?? 'Why teams choose eproexpo' }}</h2>
    </div>
    <div class="pp-grid-4">
      @foreach ($benefits as $benefit)
        <div class="pp-icard">
          <div class="pp-icn"><i class="{{ $benefit['icon'] ?? 'far fa-check-circle' }}"></i></div>
          <h4>{{ $benefit['title'] ?? '' }}</h4>
          <p>{{ $benefit['body'] ?? ($benefit['subtitle'] ?? '') }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="pp-section tint">
  <div class="pp-container pp-faq-wrap">
    <div class="pp-faq-left">
      <span class="pp-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['faq_eyebrow'] ?? 'Integrated functionality' }}</span>
      <h2>{{ $sectionHeadings['faq_title'] ?? 'Frequently asked questions' }}</h2>
      <div class="pp-still-card">
        <h4>{{ $sectionHeadings['faq_card_title'] ?? 'Still have a question?' }}</h4>
        <p>{{ $sectionHeadings['faq_card_body'] ?? '' }}</p>
        <form class="pp-row" id="pp-contact-form">
          <input type="email" id="pp-contact-email" placeholder="Enter your email" required>
          <button type="submit">Send email</button>
        </form>
      </div>
    </div>
    <div class="pp-faq-list">
      @foreach ($faqs as $index => $faq)
        <div @class(['pp-faq-item', 'open' => $index === 0])>
          <div class="pp-faq-q" role="button" tabindex="0" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
            {{ $faq['q'] ?? '' }}
            <span class="chev">▾</span>
          </div>
          <div class="pp-faq-a">
            <p>{{ $faq['a'] ?? '' }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="pp-bottom-cta">
  <span class="pp-eyebrow-sm"><span class="dot"></span>{{ $sectionHeadings['cta_eyebrow'] ?? 'Start today' }}</span>
  <h2>{{ $pricingHero['cta_title'] ?? 'Any event. Every audience. Everywhere.' }}</h2>
  <p>{{ $pricingHero['cta_subtitle'] ?? '' }}</p>
  <div class="pp-hero-cta">
    <span class="pp-btn-white">{{ $pricingHero['button_1_label'] ?? 'Create Event' }}</span>
    <span class="pp-btn-outline">{{ $pricingHero['button_2_label'] ?? 'Book a Demo' }}</span>
  </div>
</div>
