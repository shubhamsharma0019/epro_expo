@extends('layouts.visitor-portal')

@section('title', 'eproexpo — My Passes')
@section('shell-class', 'shell--passes')

@section('page-styles')
<style>
.empty-state{text-align:center; padding:50px 20px; color:var(--muted);}
.empty-state .ic-wrap{
  width:54px; height:54px; border-radius:50%; background:var(--grad-soft); color:var(--violet);
  display:flex; align-items:center; justify-content:center; margin:0 auto 14px;
}
.empty-state h4{font-size:14px; font-weight:700; color:var(--ink-soft); margin-bottom:4px;}
.empty-state p{font-size:12.5px;}
.list-empty{padding:28px 0; text-align:center; font-size:13px; color:var(--muted);}
</style>
@endsection

@section('portal-content')
@php
    $eventPasses = $passes->where('type', 'event')->values();
    $downloadUrl = fn (array $pass) => route('frontend.user.tickets.e-ticket', $pass['id']);
    $emailUrl = fn (array $pass) => route('frontend.user.tickets.email', $pass['id']);
@endphp
<main class="main">
    @if (session('success'))
        <div style="background:#E9FAF1;border:1px solid #B8EFD4;color:#1D9E75;padding:12px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:14px;">{{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div style="background:#FFF8E6;border:1px solid #F5DFA0;color:#9A6700;padding:12px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:14px;">{{ session('warning') }}</div>
    @endif
    <div class="welcome-banner">
        <div>
            <h1>My Passes</h1>
            <p id="banner-sub">Browse and explore exhibitions you can register for.</p>
        </div>
        <div class="pill" id="banner-pill" @if ($openExhibitionsCount === 0) style="display:none;" @endif>
            <span class="dot"></span><span id="banner-pill-text">{{ $openExhibitionsCount }} exhibition{{ $openExhibitionsCount === 1 ? '' : 's' }} open</span>
        </div>
    </div>

    <div class="action-bar">
        <a href="{{ route('exhibitions.index') }}" class="book-btn" id="book-btn" data-events-href="{{ url('/events/listings') }}" data-exh-href="{{ route('exhibitions.index') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
            <span id="book-btn-label">Book Exhibition</span>
        </a>
        <div class="toggle-row">
            <button type="button" onclick="toggleType('events', this)">Events</button>
            <button class="active" type="button" onclick="toggleType('exh', this)">Exhibitions</button>
        </div>
    </div>

    <div class="listing-card">
        <div class="sub-toggle-row">
            <button class="active" type="button" onclick="toggleStatus('all', this)">All Passes</button>
            <button type="button" onclick="toggleStatus('live', this)">Active / Live</button>
        </div>

        <div id="list-events" style="display:none;">
            @forelse ($eventPasses as $pass)
                @include('frontend.user.passes.partials.pass-row', [
                    'pass' => $pass,
                    'downloadUrl' => $downloadUrl($pass),
                    'emailUrl' => $emailUrl($pass),
                    'isEvent' => true,
                ])
            @empty
                <div class="list-empty">No event tickets yet.</div>
            @endforelse
        </div>

        <div id="list-exh">
            @if (($ownedExhibitionPasses ?? collect())->isNotEmpty())
                @foreach ($ownedExhibitionPasses as $pass)
                    @include('frontend.user.passes.partials.exhibition-pass-row', ['pass' => $pass])
                @endforeach
            @endif
            @forelse ($openExhibitions ?? $exhibitions as $exhibition)
                @include('frontend.user.passes.partials.exhibition-row', ['exhibition' => $exhibition])
            @empty
                @if (($ownedExhibitionPasses ?? collect())->isEmpty())
                    <div class="list-empty">No exhibitions available right now.</div>
                @endif
            @endforelse
        </div>

        <div id="empty" class="empty-state" style="display:none;">
            <div class="ic-wrap">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21v-7h6v7"/></svg>
            </div>
            <h4 id="empty-title">No active or live exhibitions</h4>
            <p id="empty-copy">Switch back to "All Passes" to see your full history.</p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
let currentType = 'exh';
let currentStatus = 'all';

const bannerCopy = {
  events: {
    sub: 'All your event tickets, organized in one place.',
    pill: @json($activeEventPassesCount > 0 ? $activeEventPassesCount . ' pass' . ($activeEventPassesCount === 1 ? '' : 'es') . ' active' : ''),
    emptyTitle: 'No active or live passes',
    emptyCopy: 'Switch back to "All Passes" to see your full history.',
  },
  exh: {
    sub: 'Browse and explore exhibitions you can register for.',
    pill: @json($openExhibitionsCount > 0 ? $openExhibitionsCount . ' exhibition' . ($openExhibitionsCount === 1 ? '' : 's') . ' open' : ''),
    emptyTitle: 'No active or live exhibitions',
    emptyCopy: 'Switch back to "All Passes" to see your full history.',
  },
};

function updateBanner(){
  const copy = bannerCopy[currentType];
  document.getElementById('banner-sub').textContent = copy.sub;
  const pill = document.getElementById('banner-pill');
  const pillText = document.getElementById('banner-pill-text');
  if (copy.pill) {
    pill.style.display = 'flex';
    if (pillText) pillText.textContent = copy.pill;
    else pill.innerHTML = '<span class="dot"></span><span id="banner-pill-text">' + copy.pill + '</span>';
  } else {
    pill.style.display = 'none';
  }
  document.getElementById('empty-title').textContent = copy.emptyTitle;
  document.getElementById('empty-copy').textContent = copy.emptyCopy;

  const bookBtn = document.getElementById('book-btn');
  const bookLabel = document.getElementById('book-btn-label');
  if (currentType === 'events') {
    bookBtn.href = bookBtn.dataset.eventsHref;
    bookLabel.textContent = 'Book Event';
  } else {
    bookBtn.href = bookBtn.dataset.exhHref;
    bookLabel.textContent = 'Book Exhibition';
  }
}

function toggleType(which, btn){
  currentType = which;
  document.querySelectorAll('.action-bar .toggle-row button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  updateBanner();
  applyFilters();
}

function toggleStatus(which, btn){
  currentStatus = which;
  document.querySelectorAll('.sub-toggle-row button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  applyFilters();
}

function applyFilters(){
  document.getElementById('list-events').style.display = currentType === 'events' ? 'block' : 'none';
  document.getElementById('list-exh').style.display = currentType === 'exh' ? 'block' : 'none';

  const activeListId = currentType === 'events' ? 'list-events' : 'list-exh';
  const rows = document.querySelectorAll('#' + activeListId + ' .pass-row');
  let visibleCount = 0;

  rows.forEach(row => {
    const status = row.getAttribute('data-status');
    const show = currentStatus === 'all' || status === 'live';
    row.style.display = show ? 'flex' : 'none';
    if (show) visibleCount++;
  });

  const empty = document.getElementById('empty');
  const hasRows = rows.length > 0;
  empty.style.display = hasRows && visibleCount === 0 ? 'block' : 'none';
}

updateBanner();
</script>
@endpush
