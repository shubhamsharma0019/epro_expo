@extends('layouts.visitor-portal')

@section('title', 'eproexpo — My Meetings')
@section('shell-class', 'shell--passes')
@section('visitorNavActive', 'meetings')

@section('page-styles')
<style>
:root{--live:#E0353B;--green:#23BE76;}
.tabbar{
  background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
  padding:8px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;
}
.tab{
  padding:11px 18px;border-radius:11px;font-size:13.5px;font-weight:700;
  color:var(--muted);cursor:pointer;border:none;background:transparent;
  display:flex;align-items:center;gap:8px;transition:.15s;white-space:nowrap;
  font-family:'Inter',sans-serif;
}
.tab .badge{background:var(--ivory);color:var(--ink-soft);font-size:11px;font-weight:800;padding:2px 8px;border-radius:999px;}
.tab.active{background:var(--grad);color:#fff;}
.tab.active .badge{background:rgba(255,255,255,.22);color:#fff;}
.filter-wrap{position:relative;margin-left:auto;}
.filter-btn{
  display:flex;align-items:center;gap:7px;padding:10px 16px;border-radius:11px;
  border:1.5px solid var(--line);background:#fff;font-size:13px;font-weight:700;
  color:var(--ink-soft);cursor:pointer;white-space:nowrap;transition:.15s;
  font-family:'Inter',sans-serif;
}
.filter-btn:hover{border-color:var(--indigo);color:var(--indigo);}
.filter-btn.on{border-color:var(--indigo);color:var(--indigo);background:rgba(79,45,200,.05);}
.chevron{transition:transform .2s;display:flex;}
.filter-btn.open .chevron{transform:rotate(180deg);}
.dropdown{
  display:none;position:absolute;top:calc(100% + 8px);right:0;
  background:#fff;border:1.5px solid var(--line);border-radius:14px;
  padding:6px;min-width:200px;z-index:200;
  box-shadow:0 14px 32px -10px rgba(40,20,90,.16);
}
.dropdown.open{display:flex;flex-direction:column;}
.opt{
  display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:10px;
  border:none;background:transparent;font-size:13px;font-weight:600;
  color:var(--ink-soft);cursor:pointer;text-align:left;width:100%;transition:.12s;
  font-family:'Inter',sans-serif;
}
.opt:hover{background:var(--ivory);color:var(--ink);}
.opt.picked{background:var(--grad);color:#fff;}
.dot-live{width:10px;height:10px;border-radius:50%;background:var(--live);flex-shrink:0;}
.dot-done{width:10px;height:10px;border-radius:50%;background:var(--muted);flex-shrink:0;}
.list-card{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);padding:10px;}
.mrow{display:flex;align-items:center;gap:16px;padding:16px 14px;border-radius:14px;transition:.15s;}
.mrow:hover{background:var(--ivory);}
.mrow+.mrow{border-top:1px solid var(--line);}
.mavatar{
  width:46px;height:46px;border-radius:13px;background:var(--grad);
  display:flex;align-items:center;justify-content:center;color:#fff;
  font-weight:800;font-size:15px;font-family:'Plus Jakarta Sans';flex-shrink:0;position:relative;
}
.beep{
  position:absolute;top:-3px;right:-3px;width:13px;height:13px;border-radius:50%;
  background:var(--live);border:2.5px solid #fff;animation:pulse 1.5s infinite;
}
@keyframes pulse{
  0%{box-shadow:0 0 0 0 rgba(224,53,59,.55);}
  70%{box-shadow:0 0 0 9px rgba(224,53,59,0);}
  100%{box-shadow:0 0 0 0 rgba(224,53,59,0);}
}
.minfo{flex:1;min-width:0;}
.topline{display:flex;align-items:center;gap:9px;margin-bottom:3px;flex-wrap:wrap;}
.minfo h3{font-size:14.5px;font-weight:800;color:var(--ink);}
.live-tag{
  display:flex;align-items:center;gap:5px;background:rgba(224,53,59,.1);color:var(--live);
  font-size:10.5px;font-weight:800;text-transform:uppercase;letter-spacing:.03em;
  padding:3px 9px 3px 7px;border-radius:999px;
}
.livedot{width:6px;height:6px;border-radius:50%;background:var(--live);animation:pulse 1.5s infinite;}
.minfo p{font-size:12.5px;color:var(--muted);display:flex;align-items:center;gap:6px;flex-wrap:wrap;}
.sep{opacity:.5;}
.pill{font-size:11px;font-weight:800;padding:5px 12px;border-radius:999px;white-space:nowrap;}
.pill.green{background:rgba(35,190,118,.12);color:var(--green);}
.pill.purple{background:rgba(139,47,214,.1);color:var(--violet);}
.pill.grey{background:#EFEEF5;color:var(--muted);}
.btn{
  background:var(--grad);color:#fff;border:none;font-size:12.5px;font-weight:700;
  padding:10px 16px;border-radius:10px;cursor:pointer;white-space:nowrap;
  display:inline-flex;align-items:center;gap:6px;font-family:'Inter',sans-serif;text-decoration:none;
}
.btn.out{background:#fff;color:var(--indigo);border:1.5px solid var(--indigo);}
.btn svg{width:14px;height:14px;}
.empty{
  display:none;flex-direction:column;align-items:center;justify-content:center;
  padding:48px 20px;color:var(--muted);gap:10px;
}
.empty svg{width:38px;height:38px;opacity:.35;}
.empty p{font-size:13.5px;font-weight:600;}
.list-empty{padding:40px 20px;text-align:center;color:var(--muted);font-size:13px;}
.list-empty h4{font-size:14px;font-weight:700;color:var(--ink-soft);margin-bottom:4px;}
@media(max-width:768px){
  .filter-wrap{width:100%;margin-left:0;}
  .filter-btn{width:100%;justify-content:center;}
  .mrow{flex-wrap:wrap;}
  .btn,.pill{margin-left:auto;}
}
</style>
@endsection

@section('portal-content')
<main class="main">
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-[13px] font-semibold text-green-800 mb-4">{{ session('success') }}</div>
    @endif
    <div class="welcome-banner">
        <div>
            <h1>My Meetings</h1>
            <p>Manage your scheduled, live, and pending exhibitor meetings.</p>
        </div>
    </div>

    <div class="tabbar">
        <button class="tab active" type="button" id="tab-all" onclick="setTab('all')">
            All meetings <span class="badge">{{ $totalCount }}</span>
        </button>
        <button class="tab" type="button" id="tab-upcoming" onclick="setTab('upcoming')">
            Upcoming meetings <span class="badge">{{ $upcomingCount }}</span>
        </button>

        <div class="filter-wrap">
            <button class="filter-btn" type="button" id="filterBtn" onclick="toggleDropdown(event)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filter
                <span class="chevron"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg></span>
            </button>
            <div class="dropdown" id="dropdown">
                <button class="opt" type="button" id="opt-live" onclick="pickFilter(event,'live')">
                    <span class="dot-live"></span>Live meetings
                </button>
                <button class="opt" type="button" id="opt-done" onclick="pickFilter(event,'done')">
                    <span class="dot-done"></span>Completed meetings
                </button>
            </div>
        </div>
    </div>

    <div class="list-card" id="meeting-list">
        @forelse ($meetings as $meeting)
            @php
                $rowType = $meeting['is_live'] ? 'live' : ($meeting['status_key'] === 'done' ? 'done' : 'upcoming');
            @endphp
            <div class="mrow" data-type="{{ $rowType }}">
                <div class="mavatar">
                    {{ $meeting['initials'] }}
                    @if ($meeting['is_live'])
                        <span class="beep"></span>
                    @endif
                </div>
                <div class="minfo">
                    <div class="topline">
                        <h3>{{ $meeting['company'] }}</h3>
                        @if ($meeting['is_live'])
                            <span class="live-tag"><span class="livedot"></span>Live now</span>
                        @endif
                    </div>
                    <p>
                        {{ $meeting['booth_label'] }}
                        <span class="sep">·</span>
                        {{ $meeting['schedule_label'] }}
                        <span class="sep">·</span>
                        {{ $meeting['hall_name'] }}
                    </p>
                </div>

                @if (! $meeting['is_live'])
                    <span class="pill {{ $meeting['status_key'] === 'done' ? 'grey' : ($meeting['status_key'] === 'pending' ? 'purple' : 'green') }}">
                        {{ $meeting['status_label'] }}
                    </span>
                @endif

                @if ($meeting['action']['type'] === 'join' && $meeting['action']['url'])
                    <a href="{{ $meeting['action']['url'] }}" target="_blank" rel="noopener" class="btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.12.81.34 1.6.66 2.34a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.74-1.23a2 2 0 012.11-.45c.74.32 1.53.54 2.34.66A2 2 0 0122 16.92z"/></svg>
                        {{ $meeting['action']['label'] }}
                    </a>
                @elseif ($meeting['action']['type'] === 'request' && $meeting['action']['url'])
                    <form method="POST" action="{{ $meeting['action']['url'] }}">
                        @csrf
                        <button type="submit" class="btn {{ $meeting['action']['outline'] ? 'out' : '' }}">{{ $meeting['action']['label'] }}</button>
                    </form>
                @elseif ($meeting['action']['type'] === 'notes')
                    <button type="button" class="btn out" onclick="showMeetingNotes(@js($meeting['company']), @js($meeting['notes'] ?: 'No notes added for this meeting yet.'))">
                        {{ $meeting['action']['label'] }}
                    </button>
                @else
                    <button type="button" class="btn {{ $meeting['action']['outline'] ? 'out' : '' }}">
                        {{ $meeting['action']['label'] }}
                    </button>
                @endif
            </div>
        @empty
            <div class="list-empty">
                <h4>No meetings scheduled yet</h4>
                <p>Book a meeting from an exhibitor booth to see it here.</p>
            </div>
        @endforelse

        <div class="empty" id="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            <p>No meetings match this filter.</p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
let currentTab = 'all';
let currentFilter = null;
let dropdownOpen = false;

const rows = document.querySelectorAll('.mrow');
const emptyEl = document.getElementById('empty');
const filterBtn = document.getElementById('filterBtn');
const dropdown = document.getElementById('dropdown');

function setTab(tab) {
    currentTab = tab;
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + tab)?.classList.add('active');
    render();
}

function toggleDropdown(e) {
    e.stopPropagation();
    dropdownOpen = !dropdownOpen;
    if (dropdownOpen) {
        dropdown?.classList.add('open');
        filterBtn?.classList.add('open');
    } else {
        closeAndReset();
    }
}

function pickFilter(e, value) {
    e.stopPropagation();
    currentFilter = value;
    document.querySelectorAll('.opt').forEach(o => o.classList.remove('picked'));
    document.getElementById('opt-' + value)?.classList.add('picked');
    filterBtn?.classList.add('on');
    dropdownOpen = false;
    dropdown?.classList.remove('open');
    filterBtn?.classList.remove('open');
    render();
}

function closeAndReset() {
    dropdownOpen = false;
    dropdown?.classList.remove('open');
    filterBtn?.classList.remove('open');
    filterBtn?.classList.remove('on');
    currentFilter = null;
    document.querySelectorAll('.opt').forEach(o => o.classList.remove('picked'));
    render();
}

document.addEventListener('click', function(e) {
    if (dropdownOpen && dropdown && filterBtn && !dropdown.contains(e.target) && !filterBtn.contains(e.target)) {
        closeAndReset();
    }
});

function render() {
    if (!rows.length) return;

    let visible = 0;
    rows.forEach(row => {
        const type = row.dataset.type;

        let tabOk = true;
        if (currentTab === 'upcoming') tabOk = (type === 'upcoming' || type === 'live');

        let filterOk = true;
        if (currentFilter === 'live') filterOk = (type === 'live');
        if (currentFilter === 'done') filterOk = (type === 'done');

        const show = tabOk && filterOk;
        row.style.display = show ? 'flex' : 'none';
        if (show) visible++;
    });

    if (emptyEl) {
        emptyEl.style.display = visible === 0 ? 'flex' : 'none';
    }
}

function showMeetingNotes(company, notes) {
    alert(company + '\n\n' + notes);
}

render();
</script>
@endpush
