<div class="es-hero">
    @if (! empty($event['image']))
        <div class="es-hero-bg" style="background-image: url('{{ $event['image'] }}')"></div>
    @endif

    <div class="es-hero-inner es-container">
        <nav class="es-crumb" aria-label="Breadcrumb">
            <a href="{{ url('/events') }}">Home</a>
            <span class="sep">›</span>
            <a href="{{ url('/events/listings') }}">Events</a>
            <span class="sep">›</span>
            <span class="cur">{{ $event['title'] }}</span>
        </nav>

        <div class="es-hero-headrow">
            <span class="es-eyebrow-hero">
                <span class="dot"></span>
                {{ filled($event['tagline'] ?? null) ? $event['tagline'] : 'Welcome' }}
            </span>
            <button
                type="button"
                class="es-share-btn"
                onclick="navigator.share ? navigator.share({ title: @js($event['title']), url: window.location.href }) : navigator.clipboard?.writeText(window.location.href)"
            >
                <i class="fas fa-share"></i> Share
            </button>
        </div>

        <div class="es-hero-copy">
            <h1>{{ $event['title'] }}</h1>
            <div class="es-hero-meta">
                <span><i class="far fa-calendar-alt"></i> {{ $event['date'] }}</span>
                <span><i class="fas fa-map-marker-alt"></i> {{ $event['venue'] }}</span>
            </div>
            @if (! empty($event['tags']))
                <div class="es-hero-tags">
                    @foreach ($event['tags'] as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        @if (! empty($heroStats))
            <div class="es-hero-stats">
                @foreach ($heroStats as $stat)
                    <div class="es-hero-stat">
                        <div class="icn"><i class="{{ $stat['icon'] }}"></i></div>
                        <div>
                            <strong>{{ $stat['value'] }}</strong>
                            <span class="sub">{{ $stat['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="es-container es-lift">
    @if (($eventTabs ?? collect())->isNotEmpty())
        <div class="es-tab-strip">
            @foreach ($eventTabs as $tab)
                <a href="{{ $tab['href'] }}" class="tab {{ $loop->first ? 'active' : '' }}">{{ $tab['label'] }}</a>
            @endforeach
        </div>
    @endif

    <div class="es-body-grid">
        <div id="event-about" class="es-icard es-about-card">
            <h2>About This Event</h2>
            <p>{!! nl2br(e($event['description'])) !!}</p>

            @if (! empty($event['highlights']))
                <ul class="es-about-list">
                    @foreach ($event['highlights'] as $highlight)
                        <li><span class="chk"><i class="fas fa-check"></i></span>{{ $highlight }}</li>
                    @endforeach
                </ul>
            @endif

            @if (($sessions ?? collect())->isNotEmpty())
                <div id="event-agenda" class="es-subsection">
                    <h3>Schedule</h3>
                    @foreach ($sessions as $session)
                        <div class="es-session-row">
                            <div class="shrink-0 text-[13px] font-semibold text-[#6D28D9] sm:w-28">
                                {{ $session->starts_at?->format('M d') ?: 'Date TBD' }}<br>
                                <span class="font-medium text-[#6B6884]">{{ $session->starts_at?->format('h:i A') ?: 'Time TBD' }}</span>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-[15px] font-bold text-[#171522]">{{ $session->title }}</h4>
                                @if ($session->description)
                                    <p class="mt-1 text-[14px] leading-[1.6] text-[#6B6884]">{{ $session->description }}</p>
                                @endif
                                @if ($session->location)
                                    <p class="mt-2 text-[13px] font-medium text-[#171522]">{{ $session->location }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (($speakers ?? collect())->isNotEmpty())
                <div id="event-speakers" class="es-subsection">
                    <h3>Speakers</h3>
                    @foreach ($speakers as $speaker)
                        <div class="es-speaker-card">
                            <p class="text-[15px] font-bold text-[#171522]">{{ $speaker->name }}</p>
                            @if ($speaker->designation || $speaker->organization)
                                <p class="mt-1 text-[13px] text-[#6B6884]">
                                    {{ collect([$speaker->designation, $speaker->organization])->filter()->join(' · ') }}
                                </p>
                            @endif
                            @if ($speaker->bio)
                                <p class="mt-2 text-[13px] leading-[1.6] text-[#6B6884]">{{ $speaker->bio }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div id="event-tickets" class="es-price-row">
                <div>
                    <div class="lbl">Starts from</div>
                    <div class="amt">{{ $event['price'] }}</div>
                </div>
                <a href="{{ \App\Support\EventTicketFlow::visitorPassEntryUrl($eventSlug) }}" class="es-cta-btn">Get Visitor Pass</a>
            </div>
        </div>

        <div class="es-icard es-meta-card">
            <h3>Event Details</h3>
            <div class="es-meta-list">
                <div class="es-meta-row">
                    <div class="icn"><i class="far fa-calendar-alt"></i></div>
                    <div class="txt"><span>Date</span><strong>{{ $event['date'] }}</strong></div>
                </div>
                <div class="es-meta-row">
                    <div class="icn"><i class="far fa-clock"></i></div>
                    <div class="txt"><span>Time</span><strong>{{ $event['time'] }}</strong></div>
                </div>
                <div id="event-venue" class="es-meta-row">
                    <div class="icn"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="txt"><span>Venue</span><strong>{{ $event['venue'] }}</strong></div>
                </div>
                <div id="event-website" class="es-meta-row">
                    <div class="icn"><i class="fas fa-link"></i></div>
                    <div class="txt">
                        <span>Website</span>
                        @if (! empty($event['website_url']))
                            <a href="{{ $event['website_url'] }}" target="_blank" rel="noopener">{{ $event['website'] }}</a>
                        @else
                            <strong>{{ $event['website'] }}</strong>
                        @endif
                    </div>
                </div>
                <div class="es-meta-row">
                    <div class="icn"><i class="fas fa-building"></i></div>
                    <div class="txt"><span>Organized By</span><strong>{{ $event['organizer'] }}</strong></div>
                </div>
                <div class="es-meta-row">
                    <div class="icn"><i class="fas fa-tag"></i></div>
                    <div class="txt"><span>Category</span><strong>{{ $event['category'] }}</strong></div>
                </div>
                <div class="es-meta-row">
                    <div class="icn"><i class="fas fa-hashtag"></i></div>
                    <div class="txt"><span>Event ID</span><strong>{{ $event['event_id'] }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
