@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Hall Layout')
@section('shell-class', 'shell--passes')

@section('page-styles')
<style>
:root{
  --available:#23BE76;
  --selected:#4F2DC8;
  --booked:#8A84A0;
  --reserved:#D9D5E8;
}
.section-title{font-size:16px; font-weight:800; color:var(--ink); margin-bottom:2px;}
.section-sub{font-size:12.5px; color:var(--muted); margin-bottom:14px;}
.layout-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:20px 22px;
}
.legend-row{
  display:flex; align-items:center; gap:26px; flex-wrap:wrap;
  background:var(--ivory);
  border:1px solid var(--line);
  border-radius:12px;
  padding:14px 20px;
  margin-bottom:18px;
}
.legend-item{display:flex; align-items:center; gap:9px; font-size:13px; font-weight:700; color:var(--ink-soft);}
.legend-swatch{width:18px; height:18px; border-radius:5px;}
.legend-swatch.available{background:var(--available);}
.legend-swatch.selected{background:var(--selected);}
.legend-swatch.booked{background:var(--booked);}
.legend-swatch.reserved{background:var(--reserved);}
.hall-frame{
  border:1px solid var(--line);
  border-radius:14px;
  padding:22px 26px 26px;
  background:#fff;
  overflow-x:auto;
}
.aisle-label{
  text-align:center; font-size:13px; font-weight:800; color:var(--ink);
  position:relative; margin-bottom:20px;
}
.aisle-label::before, .aisle-label::after{
  content:""; position:absolute; top:50%; width:38%; height:1px; background:var(--line);
}
.aisle-label::before{left:0;}
.aisle-label::after{right:0;}
.hall-grid{
  display:grid;
  grid-template-columns:repeat(8, minmax(52px, 1fr));
  gap:8px;
  min-width:min(100%, 720px);
}
.booth{
  aspect-ratio:1/1;
  border-radius:10px;
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  gap:6px;
  font-size:13px; font-weight:800;
  color:#fff;
  cursor:pointer;
  transition:transform .12s ease, box-shadow .12s ease;
  text-align:center;
  padding:6px;
  min-height:52px;
}
.booth:hover{transform:translateY(-2px); box-shadow:0 8px 16px -8px rgba(40,20,90,.3);}
.booth.available{background:var(--available);}
.booth.booked{background:var(--booked);}
.booth.booked{cursor:default;}
.booth.booked.is-link{cursor:pointer;}
.booth.booked.is-link:hover{transform:translateY(-2px); box-shadow:0 8px 16px -8px rgba(40,20,90,.3);}
.booth.booked:not(.is-link):hover{transform:none; box-shadow:none;}
.booth.selected{background:var(--selected); box-shadow:0 0 0 3px rgba(79,45,200,.18);}
.booth.reserved{background:var(--reserved); color:var(--ink-soft); cursor:default;}
.booth.reserved:hover{transform:none; box-shadow:none;}
.booth.wide{grid-column:span 2; aspect-ratio:auto; min-height:52px;}
.booth .logo-wrap{
  width:26px; height:26px; border-radius:50%; background:rgba(255,255,255,.9);
  display:flex; align-items:center; justify-content:center; font-size:13px; overflow:hidden;
  color:var(--ink);
}
.booth .blabel{font-size:11px; font-weight:700; opacity:.95;}
.booth .num{font-size:14px; font-weight:800;}
.layout-empty{
  text-align:center; padding:40px 20px; color:var(--muted); font-size:13px;
}
@media(max-width:768px){
  .hall-grid{grid-template-columns:repeat(4, minmax(44px, 1fr));}
  .legend-row{gap:14px;}
  .hall-frame{padding:16px;}
  .layout-card{padding:16px;}
  .welcome-banner{flex-direction:column; align-items:flex-start;}
  .welcome-banner .pill{align-self:stretch; justify-content:center; white-space:normal;}
}
@media(max-width:480px){
  .hall-grid{grid-template-columns:repeat(3, minmax(40px, 1fr)); gap:6px;}
  .booth.wide{grid-column:span 1;}
}
</style>
@endsection

@section('portal-content')
@php
    $hallTitle = $hall->title ?: 'Hall';
    $availableCount = $floorMap['availableBoothsCount'] ?? 0;
@endphp
<main class="main">
    <a href="{{ $backUrl }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
        Back to Halls
    </a>

    <div class="welcome-banner">
        <div>
            <h1>Hall Layout</h1>
            <p>Pick an available booth in {{ $hallTitle }} to view details or reserve it.</p>
        </div>
        <div class="pill"><span class="dot"></span>{{ $passLabel }}</div>
    </div>

    <div class="layout-card">
        <div class="section-sub">Tap a booked booth to open the exhibitor hub. Green booths are available to select.</div>

        <div class="legend-row">
            <div class="legend-item"><span class="legend-swatch available"></span>Available ({{ $availableCount }})</div>
            <div class="legend-item"><span class="legend-swatch selected"></span>Selected</div>
            <div class="legend-item"><span class="legend-swatch booked"></span>Booked</div>
            <div class="legend-item"><span class="legend-swatch reserved"></span>Reserved</div>
        </div>

        <div class="hall-frame">
            <div class="aisle-label">Main Aisle</div>
            @if (count($gridCells) > 0)
                <div class="hall-grid" id="hall-grid">
                    @foreach ($gridCells as $cell)
                        @php
                            $boothClass = 'booth ' . $cell['type'] . ($cell['wide'] ? ' wide' : '') . (!empty($cell['hub_url']) ? ' is-link' : '');
                            $boothStyle = $cell['span'] > 1 ? 'grid-column: span ' . $cell['span'] . ';' : '';
                        @endphp
                        @if (!empty($cell['hub_url']))
                            <a
                                href="{{ $cell['hub_url'] }}"
                                class="{{ $boothClass }}"
                                @if ($boothStyle) style="{{ $boothStyle }}" @endif
                                title="Open {{ $cell['label'] }} booth hub"
                            >
                                @if ($cell['label'] && $cell['type'] === 'booked')
                                    <div class="logo-wrap">{{ $cell['initial'] }}</div>
                                    <span class="blabel">{{ \Illuminate\Support\Str::limit($cell['label'], 14) }}</span>
                                @elseif ($cell['number'])
                                    <span class="num">{{ $cell['number'] }}</span>
                                @endif
                            </a>
                        @else
                            <div
                                class="{{ $boothClass }}"
                                @if ($boothStyle) style="{{ $boothStyle }}" @endif
                                @if ($cell['type'] === 'available') data-selectable="1" onclick="selectBooth(this)" @endif
                                data-number="{{ $cell['number'] }}"
                            >
                                @if ($cell['label'] && $cell['type'] === 'booked')
                                    <div class="logo-wrap">{{ $cell['initial'] }}</div>
                                    <span class="blabel">{{ \Illuminate\Support\Str::limit($cell['label'], 14) }}</span>
                                @elseif ($cell['number'])
                                    <span class="num">{{ $cell['number'] }}</span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="layout-empty">No booth layout published for this hall yet.</div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
function selectBooth(el){
  document.querySelectorAll('.booth[data-selectable="1"]').forEach(b => {
    b.classList.remove('selected');
    b.classList.add('available');
  });
  el.classList.remove('available');
  el.classList.add('selected');
}
</script>
@endpush
