@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Halls')
@section('shell-class', 'shell--passes')

@section('page-styles')
<style>
:root{
  --green:#1D9E75;
  --green-bg:#E6F7F1;
}
.action-bar{display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap;}
.search-wrap{display:flex; align-items:center; gap:10px; flex:1; justify-content:flex-end; min-width:0;}
.search-box{
  display:flex; align-items:center; gap:8px;
  background:#fff; border:1px solid var(--line); border-radius:12px;
  padding:10px 14px; flex:1; max-width:280px; color:var(--muted);
}
.search-box input{border:none; outline:none; font-size:13px; font-family:'Inter'; flex:1; background:transparent; color:var(--ink);}
.search-btn{
  display:flex; align-items:center; gap:7px;
  background:var(--grad); color:#fff; border:none; font-size:13px; font-weight:700;
  padding:10px 18px; border-radius:12px; cursor:pointer; box-shadow:var(--shadow); white-space:nowrap;
}
.hall-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:22px 26px; display:grid; grid-template-columns:1fr auto; gap:24px; align-items:center;
  width:100%;
}
.hall-main{display:flex; gap:18px; align-items:center;}
.hall-img{
  width:96px; height:80px; border-radius:12px; flex-shrink:0; overflow:hidden;
  background:var(--grad-soft); position:relative;
}
.hall-img img{width:100%; height:100%; object-fit:cover; display:block;}
.hall-info{flex:1; min-width:0;}
.hall-info .top-line{display:flex; align-items:center; gap:10px; margin-bottom:3px; flex-wrap:wrap;}
.hall-info h4{font-size:15.5px; font-weight:800; color:var(--ink);}
.hall-info .sub{font-size:12.5px; color:var(--muted); margin-bottom:10px;}
.badge-avail{
  font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.03em;
  padding:4px 10px; border-radius:999px; background:var(--green-bg); color:var(--green);
}
.badge-full{
  font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.03em;
  padding:4px 10px; border-radius:999px; background:#EDEAFB; color:#5B5570;
}
.stat-line{display:flex; gap:24px; flex-wrap:wrap;}
.stat-line .item{display:flex; align-items:center; gap:7px; font-size:12.5px; color:var(--ink-soft); font-weight:600;}
.stat-line .item svg{color:var(--violet); flex-shrink:0;}
.hall-side{
  display:flex; flex-direction:column; gap:8px; align-items:flex-end; text-align:right;
}
.hall-side .avail-num{font-size:20px; font-weight:800; color:var(--ink); font-family:'Plus Jakarta Sans';}
.hall-side .avail-label{font-size:11.5px; color:var(--muted); font-weight:600;}
.btn-solid{
  background:var(--grad); border:none; color:#fff; margin-top:6px;
  font-size:12.5px; font-weight:700; padding:10px 22px; border-radius:10px; cursor:pointer;
  display:inline-flex; align-items:center; justify-content:center; gap:6px;
  box-shadow:0 8px 18px -8px rgba(139,47,214,.5); white-space:nowrap; text-decoration:none;
}
.btn-solid:hover{filter:brightness(1.05);}
.pager{display:flex; justify-content:center; gap:14px; margin-top:4px;}
.pager button{
  width:38px; height:38px; border-radius:50%; border:1px solid var(--line); background:#fff;
  color:var(--ink-soft); display:flex; align-items:center; justify-content:center; cursor:pointer;
}
.pager button:hover:not(:disabled){background:var(--grad-soft); color:var(--violet); border-color:transparent;}
.pager button:disabled{opacity:.4; cursor:default;}
.list-empty{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:48px 24px; text-align:center; color:var(--muted); font-size:13px;
}
#halls-list{display:flex; flex-direction:column; gap:14px;}
@media(max-width:768px){
  .hall-card{padding:16px; gap:16px;}
  .hall-main{flex-direction:column; align-items:stretch;}
  .hall-img{width:100%; height:120px;}
  .hall-side{align-items:stretch; text-align:left;}
  .hall-side .btn-solid{width:100%;}
  .search-wrap{flex-direction:column; width:100%; justify-content:stretch;}
  .search-box{max-width:none; width:100%;}
  .search-btn{width:100%; justify-content:center;}
  .stat-line{gap:12px;}
}
@media(max-width:640px){
  .hall-card{grid-template-columns:1fr;}
}
</style>
@endsection

@section('portal-content')
@php
    $exhibitionName = $exhibition->title ?: $exhibition->name ?: 'Exhibition';
@endphp
<main class="main">
    <a href="{{ route('frontend.user.passes') }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
        Back to My Passes
    </a>

    <div class="welcome-banner">
        <div>
            <h1>Halls</h1>
            <p>Browse halls at {{ $exhibitionName }}, check booth availability, and reserve your space.</p>
        </div>
        <div class="pill" @if ($totalCount === 0) style="display:none;" @endif>
            <span class="dot"></span>{{ $availableCount }} hall{{ $availableCount === 1 ? '' : 's' }} available
        </div>
    </div>

    <div class="action-bar">
        <div class="toggle-row">
            <button class="active" type="button" onclick="filterHalls('all', this)">All ({{ $totalCount }})</button>
            <button type="button" onclick="filterHalls('available', this)">Available ({{ $availableCount }})</button>
        </div>
        <div class="search-wrap">
            <div class="search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="text" id="hall-search" placeholder="Search halls..." oninput="applyHallSearch()">
            </div>
            <button class="search-btn" type="button" onclick="applyHallSearch()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                Search
            </button>
        </div>
    </div>

    <div id="halls-list">
        @forelse ($halls as $index => $hall)
            <div class="hall-card" data-status="{{ $hall['is_available'] ? 'available' : 'full' }}" data-search="{{ strtolower($hall['title'] . ' ' . $hall['pavilion']) }}">
                <div class="hall-main">
                    <div class="hall-img">
                        @if ($hall['image'])
                            <img src="{{ \App\Support\HallMedia::imageUrl($hall['image']) }}" alt="{{ $hall['title'] }}">
                        @else
                            <svg width="100%" height="100%" viewBox="0 0 96 80" fill="none" aria-hidden="true">
                                <rect width="96" height="80" fill="url(#g{{ $index }})"/>
                                <circle cx="48" cy="38" r="18" fill="none" stroke="#fff" stroke-width="2" opacity=".5"/>
                                <path d="M20 60h56M30 50v10M48 45v15M66 50v10" stroke="#fff" stroke-width="2" opacity=".6"/>
                                <defs>
                                    <linearGradient id="g{{ $index }}" x1="0" y1="0" x2="96" y2="80">
                                        <stop stop-color="#4F2DC8"/>
                                        <stop offset="1" stop-color="#E0359E"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        @endif
                    </div>
                    <div class="hall-info">
                        <div class="top-line">
                            <h4>{{ $hall['title'] }}</h4>
                        </div>
                        <div class="sub">{{ $hall['pavilion'] }}</div>
                        <div class="stat-line">
                            <span class="item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
                                {{ $hall['available_booths'] }} Available Booths
                            </span>
                            <span class="item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="3"/></svg>
                                {{ $hall['booked_booths'] }} Booked Booths
                            </span>
                            <span class="item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21v-7h6v7"/></svg>
                                {{ $hall['total_booths'] }} Total Booths
                            </span>
                        </div>
                    </div>
                </div>
                <div class="hall-side">
                    @if ($hall['is_available'])
                        <span class="badge-avail">Available</span>
                        <div class="avail-num">{{ $hall['available_booths'] }} Available Booths</div>
                    @else
                        <span class="badge-full">Full</span>
                        <div class="avail-num">0 Available Booths</div>
                    @endif
                    <a href="{{ $hall['enter_url'] }}" class="btn-solid">
                        Enter Hall
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="list-empty">No halls published for this exhibition yet.</div>
        @endforelse
    </div>

    @if ($totalCount > 0)
        <div class="pager">
            <button type="button" title="Previous" disabled>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button type="button" title="Next" disabled>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
    @endif
</main>
@endsection

@push('scripts')
<script>
let currentHallFilter = 'all';

function filterHalls(which, btn){
  currentHallFilter = which;
  document.querySelectorAll('.toggle-row button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  applyHallSearch();
}

function applyHallSearch(){
  const query = (document.getElementById('hall-search')?.value || '').trim().toLowerCase();

  document.querySelectorAll('.hall-card').forEach(card => {
    const status = card.getAttribute('data-status');
    const searchText = card.getAttribute('data-search') || '';
    const matchesFilter = currentHallFilter === 'all' || status === 'available';
    const matchesSearch = !query || searchText.includes(query);
    card.style.display = matchesFilter && matchesSearch ? 'grid' : 'none';
  });
}
</script>
@endpush
