@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Visitor Dashboard')
@section('shell-class', 'shell--dashboard')

@section('page-styles')
<style>
.section-title{font-size:16px; font-weight:800; color:var(--ink); margin-bottom:2px;}
.section-sub{font-size:12.5px; color:var(--muted); margin-bottom:14px;}
.agenda-row{display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px;}
.agenda-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:18px 20px; display:flex; align-items:center; gap:14px; min-height:88px;
}
.agenda-card .ic{
  width:42px; height:42px; border-radius:12px; flex-shrink:0;
  background:var(--grad-soft); color:var(--violet);
  display:flex; align-items:center; justify-content:center; font-size:18px;
}
.agenda-card .info{flex:1; min-width:0;}
.agenda-card .info h4{font-size:14px; font-weight:700; margin-bottom:3px;}
.agenda-card .info p{font-size:12px; color:var(--muted);}
.agenda-card .join-btn{
  background:var(--grad); color:#fff; font-size:12px; font-weight:700;
  border:none; padding:8px 14px; border-radius:9px; cursor:pointer; flex-shrink:0;
  text-decoration:none; display:inline-flex; align-items:center; justify-content:center;
}
.agenda-card .join-btn.outline{
  background:#fff; color:var(--indigo); border:1.5px solid var(--indigo);
}
.agenda-empty{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:28px 20px; text-align:center; color:var(--muted); font-size:13px; font-weight:600;
}
.stat-row{display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:14px;}
.stat-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:18px; min-height:118px;
}
.stat-card .icon-wrap{
  width:38px; height:38px; border-radius:11px; margin-bottom:14px;
  background:var(--grad-soft); color:var(--violet);
  display:flex; align-items:center; justify-content:center; font-size:16px;
}
.stat-card .num{font-family:'Plus Jakarta Sans'; font-weight:800; font-size:26px; color:var(--ink);}
.stat-card .label{font-size:12px; color:var(--muted); font-weight:600; margin-top:2px;}
.listing-card .toggle-row{background:#F7F6FC; border:none; margin-bottom:18px;}
.item-row{
  display:grid;
  grid-template-columns:auto minmax(0,1fr) auto auto;
  align-items:center;
  gap:14px;
  padding:13px 0;
  border-top:1px solid var(--line);
}
.item-row:first-of-type{border-top:none;}
.item-row .badge{
  font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
  padding:4px 9px; border-radius:7px; background:var(--grad-soft); color:var(--violet); white-space:nowrap;
}
.item-row .title{min-width:0; font-size:13.5px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
.item-row .meta{font-size:12px; color:var(--muted); white-space:nowrap;}
.item-row .status{font-size:12px; font-weight:700; color:#1D9E75; white-space:nowrap;}
.listing-empty{padding:24px 0; text-align:center; font-size:13px; color:var(--muted);}
.rail{display:flex; flex-direction:column; gap:14px; min-width:0;}
.rail-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:20px;
}
.rail-card h4{font-size:14px; font-weight:800; margin-bottom:14px;}
.pass-mini{
  display:flex; align-items:flex-start; gap:10px;
  padding:10px 0; border-top:1px solid var(--line);
}
.pass-mini:first-of-type{border-top:none; padding-top:0;}
.pass-mini .dot2{width:8px; height:8px; border-radius:50%; background:var(--grad); flex-shrink:0; margin-top:5px;}
.pass-mini > div{min-width:0;}
.pass-mini p{font-size:12.5px; font-weight:600; line-height:1.3; word-break:break-word;}
.pass-mini span{font-size:11px; color:var(--muted); word-break:break-all;}
.ring-card{text-align:center; padding:24px 20px;}
.ring-wrap{position:relative; width:120px; height:120px; margin:0 auto 14px;}
.ring-wrap svg{display:block; transform:rotate(-90deg);}
.ring-label{
  position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;
  pointer-events:none;
}
.ring-label .big{font-family:'Plus Jakarta Sans'; font-weight:800; font-size:22px; color:var(--ink);}
.ring-label .small{font-size:10.5px; color:var(--muted); font-weight:600;}
.ring-card p.caption{font-size:12.5px; color:var(--ink-soft); font-weight:600;}
@media(max-width:1100px){
  .stat-row{grid-template-columns:repeat(2,minmax(0,1fr));}
}
@media(max-width:768px){
  .stat-row{gap:10px;}
  .stat-card{padding:14px; min-height:auto;}
  .stat-card .num{font-size:22px;}
  .agenda-card{flex-wrap:wrap; padding:14px 16px; min-height:auto;}
  .agenda-card .join-btn{width:100%; text-align:center; padding:10px 14px;}
  .item-row{grid-template-columns:1fr; gap:6px;}
  .item-row .title{white-space:normal;}
  .item-row .meta,
  .item-row .status{justify-self:start; white-space:normal;}
  .listing-card .toggle-row{width:100%;}
  .listing-card .toggle-row button{flex:1;}
}
@media(max-width:640px){
  .stat-row{grid-template-columns:1fr;}
  .agenda-row{grid-template-columns:1fr;}
  .welcome-banner .pill{align-self:stretch; justify-content:center;}
}
</style>
@endsection

@section('portal-content')
@php
    $firstName = str($user->name ?? 'Visitor')->before(' ')->toString() ?: ($user->name ?? 'Visitor');
    $eventPassList = $passes->where('type', 'event')->values();
    $exhibitionPassList = $passes->where('type', 'exhibition')->values();
    $eventTicketsCount = $eventTickets->count();
    $exhibitionPassesCount = $exhibitionPasses->count();
    $totalPassesCount = $totalTicketsCount ?? ($eventTicketsCount + $exhibitionPassesCount);
    $pendingMeetings = $pendingMeetingsCount ?? 0;
    $agendaItems = $todayAgenda ?? collect();
    $sessionProgress = $sessionProgress ?? ['total' => 0, 'completed' => 0, 'percent' => 0];
    $totalRegisteredSessions = $sessionProgress['total'];
    $completedSessions = $sessionProgress['completed'];
    $sessionPercent = $sessionProgress['percent'];
    $liveSessionsCount = $liveSessionsCount ?? 0;
    $ringCircumference = 314.16;
    $ringOffset = $ringCircumference - ($ringCircumference * $sessionPercent / 100);
    $categoryLabel = fn (string $cat) => match ($cat) {
        'upcoming' => 'Upcoming',
        'live' => 'Live',
        default => 'Completed',
    };
    $welcomeLabel = ($isFirstDashboardVisit ?? false) ? 'Welcome' : 'Welcome back';
@endphp

<main class="main">
    <div class="welcome-banner">
        <div>
            <h1>{{ $welcomeLabel }}, {{ $firstName }}</h1>
            <p>Your event tickets, exhibition passes, and activity agenda are ready in one place.</p>
        </div>
        @if ($liveSessionsCount > 0)
            <div class="pill"><span class="dot"></span>{{ $liveSessionsCount }} session{{ $liveSessionsCount === 1 ? '' : 's' }} live now</div>
        @endif
    </div>

    <div>
        <div class="section-title">Today's agenda</div>
        <div class="section-sub">Sessions and meetings scheduled for you today.</div>
        <div class="agenda-row">
            @forelse ($agendaItems as $item)
                <div class="agenda-card">
                    <div class="ic">
                        @if ($item['type'] === 'meeting')
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        @else
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        @endif
                    </div>
                    <div class="info">
                        <h4>{{ $item['title'] }}</h4>
                        <p>{{ $item['subtitle'] }}</p>
                    </div>
                    @if (! empty($item['action_url']))
                        <a href="{{ $item['action_url'] }}" target="_blank" rel="noopener" class="join-btn">{{ $item['action_label'] }}</a>
                    @else
                        <button class="join-btn {{ $item['type'] === 'session' ? 'outline' : '' }}" type="button">{{ $item['action_label'] }}</button>
                    @endif
                </div>
            @empty
                <div class="agenda-empty">No meetings or sessions scheduled for today.</div>
            @endforelse
        </div>
    </div>

    <div>
        <div class="stat-row">
            <div class="stat-card">
                <div class="icon-wrap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg></div>
                <div class="num">{{ $eventTicketsCount }}</div><div class="label">Event tickets</div>
            </div>
            <div class="stat-card">
                <div class="icon-wrap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21v-7h6v7"/></svg></div>
                <div class="num">{{ $exhibitionPassesCount }}</div><div class="label">Exhibition passes</div>
            </div>
            <div class="stat-card">
                <div class="icon-wrap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
                <div class="num">{{ $totalPassesCount }}</div><div class="label">Total passes</div>
            </div>
            <div class="stat-card">
                <div class="icon-wrap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="3"/><path d="M2 21v-1a6 6 0 0112 0v1"/><circle cx="17" cy="8" r="2.5"/><path d="M22 21v-1a4.5 4.5 0 00-5-4.47"/></svg></div>
                <div class="num">{{ $pendingMeetings }}</div><div class="label">Pending meetings</div>
            </div>
        </div>
    </div>

    <div class="listing-card">
        <div class="toggle-row">
            <button class="active" type="button" onclick="toggleList('events', this)">Events</button>
            <button type="button" onclick="toggleList('exh', this)">Exhibitions</button>
        </div>
        <div id="list-events">
            @forelse ($eventPassList as $pass)
                <div class="item-row">
                    <span class="badge">{{ $categoryLabel($pass['category']) }}</span>
                    <span class="title">{{ $pass['name'] }}</span>
                    <span class="meta">{{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}@if(($pass['quantity'] ?? 1) > 1) · Qty {{ $pass['quantity'] }}@endif</span>
                    <span class="status">{{ ucfirst($pass['status']) }}</span>
                </div>
            @empty
                <div class="listing-empty">No event tickets yet.</div>
            @endforelse
        </div>
        <div id="list-exh" style="display:none;">
            @forelse ($exhibitionPassList as $pass)
                <div class="item-row">
                    <span class="badge">{{ $categoryLabel($pass['category']) }}</span>
                    <span class="title">{{ $pass['name'] }}</span>
                    <span class="meta">{{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}</span>
                    <span class="status">{{ ucfirst($pass['status']) }}</span>
                </div>
            @empty
                <div class="listing-empty">No exhibition passes yet.</div>
            @endforelse
        </div>
    </div>
</main>

<aside class="rail">
    <div class="rail-card">
        <h4>My passes / tickets</h4>
        @forelse ($passes->take(5) as $pass)
            <div class="pass-mini">
                <div class="dot2"></div>
                <div>
                    <p>{{ $pass['pass_type'] }}@if ($pass['category'] === 'live') — live @endif</p>
                    <span>{{ $pass['number'] }}</span>
                </div>
            </div>
        @empty
            <div class="listing-empty" style="padding:12px 0;">No passes yet.</div>
        @endforelse
    </div>
    <div class="rail-card ring-card">
        <h4 style="margin-bottom:18px;">Sessions completed</h4>
        <div class="ring-wrap">
            <svg width="120" height="120" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="50" fill="none" stroke="#ECEAF5" stroke-width="11"/>
                <circle cx="60" cy="60" r="50" fill="none" stroke="url(#ringGrad)" stroke-width="11" stroke-linecap="round" stroke-dasharray="{{ $ringCircumference }}" stroke-dashoffset="{{ $ringOffset }}"/>
                <defs>
                    <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#4F2DC8"/>
                        <stop offset="50%" stop-color="#8B2FD6"/>
                        <stop offset="100%" stop-color="#E0359E"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="ring-label"><span class="big">{{ $completedSessions }}/{{ $totalRegisteredSessions }}</span><span class="small">SESSIONS</span></div>
        </div>
        <p class="caption">
            @if ($totalRegisteredSessions > 0)
                {{ $sessionPercent }}% of registered sessions completed
            @else
                Register for sessions to track your progress
            @endif
        </p>
    </div>
</aside>
@endsection

@push('scripts')
<script>
function toggleList(which, btn){
  document.getElementById('list-events').style.display = which==='events' ? 'block':'none';
  document.getElementById('list-exh').style.display = which==='exh' ? 'block':'none';
  document.querySelectorAll('.listing-card .toggle-row button').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
}
</script>
@endpush
