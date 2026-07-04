@php
    $firstTabId = $visibleTabs[0]['id'] ?? 'overview';
    $description = $exhibition->description ?: 'Explore the latest technologies, interact with global business leaders, and discover innovative solutions.';
@endphp

<div id="panel-overview" class="ex-tab-panel {{ $firstTabId === 'overview' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <span class="ex-eyebrow-sm">Overview</span>
        <h3 style="margin-top:2px;">What to Expect</h3>
        <ul class="ex-check-list">
            @foreach ($expectations as [, $label])
                <li><span class="chk"><i class="fas fa-check"></i></span>{{ $label }}</li>
            @endforeach
        </ul>
    </div>

    <div class="ex-icard ex-about-card">
        <h3>About This Exhibition</h3>
        <p>{{ $description }}</p>
    </div>
</div>

<div id="panel-agenda" class="ex-tab-panel {{ $firstTabId === 'agenda' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <h3>Conference Agenda / Schedule</h3>
        @forelse ($agenda as $session)
            <div class="ex-session-row">
                <div class="shrink-0 text-[13px] font-semibold text-[#6D28D9] sm:w-28">
                    {{ $session->start_time ?: 'Time TBD' }}<br>
                    <span class="font-medium text-[#6B6884]">{{ $session->end_time ?: 'Session' }}</span>
                    @if ($session->date)
                        <div class="mt-1 text-[10px] font-semibold text-[#6B6884]">{{ $session->date }}</div>
                    @endif
                </div>
                <div class="min-w-0">
                    <h4 class="text-[15px] font-bold text-[#171522]">{{ $session->title }}</h4>
                    @if ($session->description)
                        <p class="mt-1 text-[14px] leading-[1.6] text-[#6B6884]">{{ $session->description }}</p>
                    @endif
                    @if ($session->speaker_name)
                        <p class="mt-2 text-[13px] font-medium text-[#171522]">{{ $session->speaker_name }}</p>
                    @endif
                    @if ($session->hall_name)
                        <p class="mt-1 text-[13px] text-[#6B6884]">{{ $session->hall_name }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="ex-empty-state">No agenda sessions listed for this event.</div>
        @endforelse
    </div>
</div>

<div id="panel-speakers" class="ex-tab-panel {{ $firstTabId === 'speakers' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <h3>Keynote Speakers</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @forelse ($speakerCards as $sp)
                <div class="ex-speaker-card">
                    @if ($sp->avatar_url)
                        <img src="{{ $sp->avatar_url }}" alt="{{ $sp->name }}" class="mx-auto mb-3 h-16 w-16 rounded-full object-cover">
                    @else
                        <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-[#EFE9FE] text-xl font-bold text-[#6D28D9]">
                            {{ substr($sp->name, 0, 1) }}
                        </div>
                    @endif
                    <h4 class="text-[15px] font-bold text-[#171522]">{{ $sp->name }}</h4>
                    <div class="mb-2 text-[11px] font-bold text-[#6D28D9]">
                        {{ $sp->title }}@if ($sp->company) · {{ $sp->company }}@endif
                    </div>
                    <p class="text-[12px] leading-relaxed text-[#6B6884]">{{ $sp->bio }}</p>
                </div>
            @empty
                <div class="ex-empty-state col-span-full">No keynote speakers listed.</div>
            @endforelse
        </div>
    </div>
</div>

<div id="panel-companies" class="ex-tab-panel {{ $firstTabId === 'companies' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <h3>Participating Companies</h3>
        @forelse ($participatingCompanies as $company)
            <div class="ex-company-card">
                <h4 class="font-bold text-[#171522]">{{ $company['name'] }}</h4>
            </div>
        @empty
            <div class="ex-empty-state">No exhibitors registered yet</div>
        @endforelse
    </div>
</div>

<div id="panel-sponsors" class="ex-tab-panel {{ $firstTabId === 'sponsors' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <h3>Event Sponsors &amp; Partners</h3>
        @php
            $platinumSponsors = $sponsors->where('level', 'Platinum');
            $goldSponsors = $sponsors->where('level', 'Gold');
            $silverSponsors = $sponsors->where('level', 'Silver');
        @endphp
        @foreach ([['Platinum Sponsors', $platinumSponsors], ['Gold Sponsors', $goldSponsors], ['Silver Sponsors', $silverSponsors]] as [$levelLabel, $levelSponsors])
            <div class="mb-6">
                <p class="mb-3 text-[11px] font-bold uppercase tracking-wider text-[#6D28D9]">{{ $levelLabel }}</p>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @forelse ($levelSponsors as $sp)
                        <div class="flex h-[90px] flex-col items-center justify-center rounded-xl border border-[#F1EFF7] bg-white p-4">
                            @if ($sp->logo_url)
                                <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="mb-1 h-7 max-w-full object-contain">
                            @endif
                            <span class="text-[9px] font-bold uppercase tracking-wide text-[#6B6884]">{{ $sp->name }}</span>
                        </div>
                    @empty
                        <div class="col-span-full ex-empty-state" style="padding:16px;">No {{ $levelLabel }}.</div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="panel-floorplan" class="ex-tab-panel {{ $firstTabId === 'floorplan' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h3>Exhibition Halls Floor Plan</h3>
            <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="ex-btn-white" style="padding:10px 18px;font-size:12px;">Full Floor Map</a>
        </div>
        <p class="mb-6 text-[13px] leading-relaxed text-[#6B6884]">Select any hall below to explore interactive booths, find registered exhibitors, or book B2B meeting slots.</p>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($halls as $hall)
                @php
                    $hallLogo = $hall->image
                        ? (str_starts_with($hall->image, 'http') ? $hall->image : (str_starts_with($hall->image, 'storage/') ? asset($hall->image) : asset('storage/' . $hall->image)))
                        : asset('images/exhibitions/hall-fallback.jpg');
                    $badge = $hall->pavilion?->title ?: 'Hall';
                    $exhibitorsCount = $hall->boothBookings()->where('payment_status', 'paid')->whereIn('booking_status', ['confirmed', 'active'])->where('admin_status', 'approved')->count();
                @endphp
                <a href="{{ route('exhibitions.visitor.floor-map', [$slug, 'hall' => $hall->id]) }}" class="overflow-hidden rounded-2xl border border-[#F1EFF7] bg-white shadow-sm transition hover:-translate-y-0.5">
                    <div class="relative h-28">
                        <img src="{{ $hallLogo }}" alt="{{ $hall->title }}" class="h-full w-full object-cover">
                        <div class="absolute left-2 top-2 rounded bg-[#6D28D9] px-2 py-0.5 text-[10px] font-bold text-white">{{ $badge }}</div>
                    </div>
                    <div class="p-4">
                        <h4 class="mb-1 truncate text-[13px] font-bold text-[#171522]">{{ $hall->title }}</h4>
                        <p class="mb-2 line-clamp-2 text-[11px] text-[#6B6884]">{{ $hall->description }}</p>
                        <span class="text-[11px] font-bold text-[#6D28D9]">{{ $exhibitorsCount }} Exhibitors</span>
                    </div>
                </a>
            @empty
                <div class="ex-empty-state col-span-full">No halls active in this exhibition.</div>
            @endforelse
        </div>
    </div>
</div>

<div id="panel-faqs" class="ex-tab-panel {{ $firstTabId === 'faqs' ? '' : 'hidden' }}">
    <div class="ex-icard">
        <h3>Frequently Asked Questions</h3>
        @forelse ($faqs as $idx => $faq)
            <div class="mb-3 overflow-hidden rounded-xl border border-[#F1EFF7]">
                <button type="button" onclick="toggleExhibitionFaq({{ $idx }})" class="flex w-full items-center justify-between p-4 text-left text-[13px] font-bold text-[#171522]">
                    <span>{{ $faq->question }}</span>
                    <i id="faq-chevron-{{ $idx }}" class="fas fa-chevron-down text-[#6B6884] transition-transform"></i>
                </button>
                <div id="faq-answer-{{ $idx }}" class="hidden border-t border-[#F1EFF7] p-4 text-[12px] leading-relaxed text-[#6B6884]">
                    {{ $faq->answer }}
                </div>
            </div>
        @empty
            <div class="ex-empty-state">No FAQs available.</div>
        @endforelse
    </div>
</div>
