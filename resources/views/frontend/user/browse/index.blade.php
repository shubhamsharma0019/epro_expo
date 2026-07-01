@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Events & Exhibitions')
@section('shell-class', 'shell--passes')

@section('page-styles')
<style>
.browse-row{
  display:flex; align-items:center; gap:16px;
  background:var(--card); border:1px solid var(--line); border-radius:14px;
  padding:16px 18px; margin-bottom:12px; transition:.15s;
}
.browse-row:last-child{margin-bottom:0;}
.browse-row:hover{box-shadow:var(--shadow); border-color:transparent;}
.browse-row .ic{
  width:44px; height:44px; border-radius:12px; flex-shrink:0;
  background:var(--grad-soft); color:var(--violet);
  display:flex; align-items:center; justify-content:center;
  position:relative;
}
.browse-row .body{flex:1; min-width:0;}
.browse-row .body .top-line{display:flex; align-items:center; gap:9px; margin-bottom:4px; flex-wrap:wrap;}
.browse-row .body h4{font-size:14px; font-weight:700; color:var(--ink);}
.browse-row .body .meta-line{font-size:12px; color:var(--muted); display:flex; gap:14px; flex-wrap:wrap;}
.browse-row .right{display:flex; align-items:center; gap:10px; flex-shrink:0;}
.list-empty{padding:40px 20px; text-align:center; color:var(--muted); font-size:13px;}
.list-empty h4{font-size:14px; font-weight:700; color:var(--ink-soft); margin-bottom:4px;}
@media(max-width:768px){
  .browse-row{flex-direction:column; align-items:stretch; gap:12px; padding:14px;}
  .browse-row .right{width:100%;}
  .browse-row .explore-btn{width:100%; justify-content:center;}
}
</style>
@endsection

@section('portal-content')
<main class="main">
    <div class="welcome-banner">
        <div>
            <h1>Events & Exhibitions</h1>
            <p id="banner-sub">Browse upcoming exhibitions you can register for.</p>
        </div>
        <div class="pill" id="banner-pill" @if ($upcomingExhibitionsCount === 0) style="display:none;" @endif>
            <span class="dot"></span><span id="banner-pill-text">{{ $upcomingExhibitionsCount }} upcoming exhibition{{ $upcomingExhibitionsCount === 1 ? '' : 's' }}</span>
        </div>
    </div>

    <div class="action-bar">
        <a href="{{ route('exhibitions.index') }}" class="book-btn" id="book-btn"
           data-events-href="{{ route('events.listings.index') }}"
           data-exh-href="{{ route('exhibitions.index') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
            <span id="book-btn-label">Book Exhibition</span>
        </a>
        <div class="toggle-row">
            <button type="button" onclick="toggleBrowseType('events', this)">Events</button>
            <button class="active" type="button" onclick="toggleBrowseType('exh', this)">Exhibitions</button>
        </div>
    </div>

    <div class="listing-card">
        <div class="sub-toggle-row">
            <button type="button" onclick="toggleBrowseStatus('all', this)">All</button>
            <button class="active" type="button" onclick="toggleBrowseStatus('upcoming', this)">Upcoming</button>
            <button type="button" onclick="toggleBrowseStatus('live', this)">Live</button>
        </div>

        <div id="list-events" style="display:none;">
            @forelse ($events as $event)
                @include('frontend.user.browse.partials.browse-row', ['item' => $event])
            @empty
                <div class="list-empty">No events found in the database yet.</div>
            @endforelse
        </div>

        <div id="list-exh">
            @forelse ($exhibitions as $exhibition)
                @include('frontend.user.browse.partials.browse-row', ['item' => $exhibition])
            @empty
                <div class="list-empty">No exhibitions found in the database yet.</div>
            @endforelse
        </div>

        <div id="browse-empty" class="list-empty" style="display:none;">
            <h4 id="empty-title">No upcoming exhibitions</h4>
            <p id="empty-copy">Switch to another filter to see more listings.</p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
let browseType = 'exh';
let browseStatus = 'upcoming';

const browseBanner = {
  events: {
    sub: 'Browse upcoming events and book your pass.',
    pill: @json($upcomingEventsCount > 0 ? $upcomingEventsCount . ' upcoming event' . ($upcomingEventsCount === 1 ? '' : 's') : ''),
    emptyTitle: 'No upcoming events',
  },
  exh: {
    sub: 'Browse upcoming exhibitions you can register for.',
    pill: @json($upcomingExhibitionsCount > 0 ? $upcomingExhibitionsCount . ' upcoming exhibition' . ($upcomingExhibitionsCount === 1 ? '' : 's') : ''),
    emptyTitle: 'No upcoming exhibitions',
  },
};

function updateBrowseBanner(){
  const copy = browseBanner[browseType];
  document.getElementById('banner-sub').textContent = copy.sub;
  const pill = document.getElementById('banner-pill');
  const pillText = document.getElementById('banner-pill-text');
  if (copy.pill) {
    pill.style.display = 'flex';
    if (pillText) pillText.textContent = copy.pill;
  } else {
    pill.style.display = 'none';
  }
  document.getElementById('empty-title').textContent = copy.emptyTitle;

  const bookBtn = document.getElementById('book-btn');
  const bookLabel = document.getElementById('book-btn-label');
  if (browseType === 'events') {
    bookBtn.href = bookBtn.dataset.eventsHref;
    bookLabel.textContent = 'Book Event';
  } else {
    bookBtn.href = bookBtn.dataset.exhHref;
    bookLabel.textContent = 'Book Exhibition';
  }
}

function toggleBrowseType(which, btn){
  browseType = which;
  document.querySelectorAll('.action-bar .toggle-row button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  updateBrowseBanner();
  applyBrowseFilters();
}

function toggleBrowseStatus(which, btn){
  browseStatus = which;
  document.querySelectorAll('.sub-toggle-row button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  applyBrowseFilters();
}

function applyBrowseFilters(){
  document.getElementById('list-events').style.display = browseType === 'events' ? 'block' : 'none';
  document.getElementById('list-exh').style.display = browseType === 'exh' ? 'block' : 'none';

  const activeListId = browseType === 'events' ? 'list-events' : 'list-exh';
  const rows = document.querySelectorAll('#' + activeListId + ' .browse-row');
  let visibleCount = 0;

  rows.forEach(row => {
    const status = row.getAttribute('data-status');
    const show = browseStatus === 'all' || status === browseStatus;
    row.style.display = show ? 'flex' : 'none';
    if (show) visibleCount++;
  });

  const empty = document.getElementById('browse-empty');
  const hasRows = rows.length > 0;
  empty.style.display = hasRows && visibleCount === 0 ? 'block' : 'none';
}

updateBrowseBanner();
applyBrowseFilters();
</script>
@endpush
