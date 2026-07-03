@php
    $description = $exhibition->description ?: 'Explore the latest technologies, interact with global business leaders, and discover innovative solutions.';
    $highlight = collect($tags)->first(fn ($tag) => stripos($tag, 'innov') !== false) ?: 'Innovation';
    $organizerName = $exhibition->organizer_name ?: $title;
    $organizerInitial = strtoupper(substr(trim($organizerName), 0, 1));
    $floorPlanUrl = route('exhibitions.visitor.floor-map', $slug);
    $firstTabId = $visibleTabs[0]['id'] ?? 'overview';
    $displayPavilions = ($halls ?? collect())->pluck('pavilion.title')->filter()->unique()->count();
    $displayHalls = ($halls ?? collect())->count();
@endphp

<div class="ex-hero">
    <div class="ex-hero-inner ex-container">
        <a class="ex-crumb" href="{{ route('exhibitions.index') }}">← Back to Exhibitions</a>

        <div class="ex-hero-split">
            <div class="ex-hero-copy">
                <div class="ex-hero-tags">
                    @foreach (collect($tags)->take(3) as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
                <h1>{{ $title }}</h1>
                <div class="subline">Where <b>{{ $highlight }}</b> Meets the Future</div>
                <div class="ex-hero-meta">
                    <span><i class="far fa-calendar-alt"></i> {{ $dateStr }}</span>
                    <span><i class="far fa-clock"></i> {{ $timeStr }}</span>
                </div>
                <div class="ex-hero-meta" style="margin-top:6px;">
                    <span><i class="fas fa-map-marker-alt"></i> {{ $location }}</span>
                </div>
                <p class="desc">{{ $description }}</p>
                <div class="ex-hero-cta-row">
                    <a href="{{ $ticketUrl }}" class="ex-btn-white">Get Visitor Pass <i class="fas fa-arrow-right"></i></a>
                    <a href="{{ $floorPlanUrl }}" class="ex-btn-outline-w">View Floor Plan</a>
                </div>
            </div>

            <div class="ex-promo">
                @if (! empty($bannerImage))
                    <div class="ex-promo-bg" style="background-image:url('{{ $bannerImage }}')"></div>
                @endif
                <div class="ex-promo-body">
                    <h3>Halls <b>&amp;</b> Booths</h3>
                    <p>Showcase your brand to the right audience in the right virtual space.</p>
                    <div class="ex-promo-icons">
                        <div><div class="ic"><i class="fas fa-star"></i></div><span>Premium</span></div>
                        <div><div class="ic"><i class="fas fa-puzzle-piece"></i></div><span>Flexible</span></div>
                        <div><div class="ic"><i class="fas fa-palette"></i></div><span>Custom</span></div>
                        <div><div class="ic"><i class="fas fa-globe"></i></div><span>Global</span></div>
                    </div>
                    <div class="ex-promo-info">
                        <div class="row"><span>Pavilion</span><strong>{{ $promoPanel['pavilion'] }}</strong></div>
                        <div class="row"><span>Hall</span><strong>{{ $promoPanel['hall'] }}</strong></div>
                        <div class="row"><span>Booth</span><strong>{{ $promoPanel['booth'] }}</strong></div>
                        <div class="row"><span>Duration</span><strong>{{ $promoPanel['duration'] }}</strong></div>
                        <div class="row"><span>Total Amount</span><strong>{{ $promoPanel['amount'] }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ex-stat-carousel">
            <button type="button" class="ex-car-arrow" data-stat-scroll="prev" aria-label="Previous stats">‹</button>
            <div class="ex-stat-row" id="ex-stat-row">
                @foreach ($heroStats as $stat)
                    <div class="ex-stat-card">
                        <div class="icn"><i class="{{ $stat['icon'] }}"></i></div>
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
            <button type="button" class="ex-car-arrow" data-stat-scroll="next" aria-label="Next stats">›</button>
        </div>
    </div>
</div>

<div class="ex-container ex-lift">
    <div class="ex-lift-space"></div>

    <nav class="ex-tab-strip" aria-label="Exhibition sections">
        @foreach ($visibleTabs as $tab)
            <button
                type="button"
                id="tab-{{ $tab['id'] }}"
                data-tab="{{ $tab['id'] }}"
                class="tab ex-tab-btn {{ $loop->first ? 'active' : '' }}"
                onclick="switchExhibitionTab('{{ $tab['id'] }}', this)"
            >{{ $tab['label'] }}</button>
        @endforeach
    </nav>

    <div class="ex-body-grid">
        <div class="ex-stack" id="ex-tab-panels">
            @include('frontend.exhibitions.partials.exhibition-show-panels')
        </div>

        <div class="ex-stack">
            <div class="ex-icard">
                <h3>Event Information</h3>
                <div class="ex-meta-list">
                    <div class="ex-meta-row"><span class="lbl">Date</span><span class="val">{{ $dateStr }}</span></div>
                    <div class="ex-meta-row"><span class="lbl">Time</span><span class="val">{{ $timeStr }}</span></div>
                    <div class="ex-meta-row"><span class="lbl">Venue</span><span class="val">{{ $location }}</span></div>
                    <div class="ex-meta-row"><span class="lbl">Event Type</span><span class="val">{{ $eventType }}</span></div>
                    @if ($displayPavilions > 0)
                        <div class="ex-meta-row"><span class="lbl">Pavilions</span><span class="val">{{ $displayPavilions }}</span></div>
                    @endif
                    @if ($displayHalls > 0)
                        <div class="ex-meta-row"><span class="lbl">Halls</span><span class="val">{{ $displayHalls }}</span></div>
                    @endif
                </div>
            </div>

            <div class="ex-icard">
                <h3>Organizer</h3>
                <div class="ex-org-row">
                    <div class="ex-org-avatar">
                        @if (! empty($exhibition->organizer_logo))
                            <img src="{{ str_starts_with($exhibition->organizer_logo, 'http') ? $exhibition->organizer_logo : asset('storage/' . $exhibition->organizer_logo) }}" alt="{{ $organizerName }}">
                        @else
                            {{ $organizerInitial }}
                        @endif
                    </div>
                    <div>
                        <strong>{{ $organizerName }}</strong>
                        <span>Exhibition organizer</span>
                    </div>
                </div>
            </div>

            <div class="ex-icard">
                <h3>Quick Actions</h3>
                <a href="{{ $ticketUrl }}" class="ex-qa-btn primary">Get Visitor Pass <i class="fas fa-arrow-right"></i></a>
                <a href="{{ $floorPlanUrl }}" class="ex-qa-btn outline"><i class="fas fa-map"></i> View Floor Plan</a>
                <button type="button" class="ex-qa-link" onclick="shareExhibition()">Share Event</button>
            </div>
        </div>
    </div>
</div>

<div class="ex-sticky-cta">
    <div class="ex-container">
        <div class="info">
            <strong>{{ $title }}</strong>
            <span>{{ $dateStr }} · {{ $location }}</span>
        </div>
        <a href="{{ $ticketUrl }}">Get Visitor Pass →</a>
    </div>
</div>
