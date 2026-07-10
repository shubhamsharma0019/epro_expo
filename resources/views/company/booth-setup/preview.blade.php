@extends('layouts.company')

@section('title', 'Preview Booth | eproexpo')
@section('page-title', 'Preview Booth')

@section('content')
@php
    $p = $preview;
    $stats = $highlightStats ?? [];
    $routes = fn (string $name, array $params = []) => route($name, array_merge(['booking' => $booking], $params));
@endphp

<style>
    .pv { color: #1e293b; }
    .pv-wrap { max-width: 1536px; margin: 0 auto; padding: 0 4px; }
    .pv-card { background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,.04); }
    .pv-top { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 20px; margin-bottom: 20px; }
    .pv-top-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
    .pv-top-icon { width: 36px; height: 36px; border-radius: 8px; background: #f5f3ff; color: #4c33c3; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .pv-top-title { font-size: 18px; font-weight: 700; color: #4c33c3; margin: 0; }
    .pv-top-sub { font-size: 13px; color: #64748b; margin: 2px 0 0; }
    .pv-actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .pv-btn-outline { display: inline-flex; align-items: center; justify-content: center; height: 44px; padding: 0 20px; border-radius: 8px; border: 1px solid #4c33c3; color: #4c33c3; font-size: 14px; font-weight: 700; text-decoration: none; background: #fff; }
    .pv-btn-primary { display: inline-flex; align-items: center; justify-content: center; height: 44px; padding: 0 20px; border-radius: 8px; border: none; background: #4c33c3; color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; }
    .pv-btn-primary:hover { background: #3b279c; }
    .pv-layout { display: flex; flex-direction: column; gap: 24px; }
    @media (min-width: 1280px) { .pv-layout { flex-direction: row; align-items: flex-start; } }
    .pv-main { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 24px; }
    .pv-aside { width: 100%; flex-shrink: 0; display: flex; flex-direction: column; gap: 20px; }
    @media (min-width: 1280px) { .pv-aside { width: 245px; } }

    /* 3D Booth */
    .pv-stage { position: relative; height: 560px; overflow: hidden; border-radius: 16px; border: 2px solid #161a25; background: #1e2230; box-shadow: 0 10px 30px rgba(0,0,0,.12); }
    .pv-stage-bg { position: absolute; inset: 0; background: #0f172a; }
    .pv-stage-floor { position: absolute; bottom: 0; left: 5%; right: 5%; height: 35%; border-top: 1px solid #d1d5db; background: linear-gradient(to top, #d1d5db, #f8fafc); transform: perspective(800px) rotateX(45deg); transform-origin: bottom; }
    .pv-stage-wall { position: absolute; top: 0; left: 8%; right: 8%; bottom: 15%; border-left: 1px solid #d1d5db; border-right: 1px solid #d1d5db; background: linear-gradient(to bottom, #f8fafc, #e2e8f0); box-shadow: 0 25px 50px -12px rgba(0,0,0,.25); z-index: 1; }
    .pv-stage-lights { position: absolute; top: 0; left: 0; right: 0; z-index: 2; display: flex; justify-content: space-around; padding: 0 15%; }
    .pv-stage-light { width: 40px; height: 10px; border-radius: 0 0 999px 999px; background: #fff; box-shadow: 0 15px 30px 10px rgba(255,255,255,.8); }
    .pv-stage-content { position: absolute; inset: 0; z-index: 10; display: flex; flex-direction: column; padding: 32px 0 16px; }
    .pv-banner { position: relative; width: 85%; margin: 0 auto; height: 100px; border-radius: 12px; display: flex; align-items: center; padding: 0 24px; border: 1px solid rgba(99,102,241,.4); background: linear-gradient(to right, #170e51, #2d1b8c, #170e51); box-shadow: 0 10px 30px rgba(0,0,0,.12); overflow: hidden; flex-shrink: 0; }
    .pv-banner::before { content: ''; position: absolute; inset: 0; background-image: url('{{ $p['bannerUrl'] }}'); background-size: cover; background-position: center; opacity: .4; mix-blend-mode: overlay; }
    .pv-banner-logo { position: relative; z-index: 1; width: 76px; height: 76px; border-radius: 8px; background: #fff; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; text-align: center; font-size: 10px; font-weight: 700; color: #94a3b8; flex-shrink: 0; overflow: hidden; }
    .pv-banner-logo img { width: 100%; height: 100%; object-fit: contain; padding: 6px; }
    .pv-banner-text { position: relative; z-index: 1; flex: 1; margin-left: 24px; text-align: center; color: #fff; }
    .pv-banner-text h1 { margin: 0 0 4px; font-size: 26px; font-weight: 700; }
    .pv-banner-text p { margin: 0; font-size: 13px; color: rgba(224,231,255,.9); }
    .pv-grid { width: 85%; margin: 24px auto 0; flex: 1; min-height: 320px; display: grid; grid-template-columns: 28% 44% 28%; gap: 24px; }
    .pv-col { display: flex; flex-direction: column; gap: 16px; min-width: 0; }
    .pv-panel { background: #fff; border-radius: 12px; padding: 14px; box-shadow: 0 10px 30px rgba(0,0,0,.12); display: flex; flex-direction: column; flex: 1; min-height: 0; text-decoration: none; color: inherit; }
    .pv-panel-title { font-size: 12px; font-weight: 700; color: #1e293b; margin: 0 0 8px; }
    .pv-video { position: relative; flex: 1; min-height: 90px; border-radius: 8px; overflow: hidden; background: #000; display: block; }
    .pv-video img { width: 100%; height: 100%; object-fit: cover; opacity: .8; }
    .pv-video-play { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
    .pv-video-play span { width: 40px; height: 40px; border-radius: 50%; background: rgba(0,0,0,.6); border: 2px solid #fff; color: #fff; display: flex; align-items: center; justify-content: center; }
    .pv-brochure-body { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .pv-brochure-icon { width: 54px; height: 70px; margin-bottom: 12px; border-radius: 4px; border-left: 3px solid #818cf8; background: linear-gradient(135deg, #4c33c3, #2c1d75); color: #fff; font-size: 7px; font-weight: 700; display: flex; align-items: center; justify-content: center; text-align: center; }
    .pv-btn-sm { width: 100%; padding: 6px 0; border-radius: 4px; background: #4c33c3; color: #fff; font-size: 10px; font-weight: 700; text-align: center; text-decoration: none; border: none; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .pv-welcome { text-align: center; padding: 24px; }
    .pv-welcome h2 { margin: 0 0 12px; font-size: 18px; font-weight: 700; color: #1e293b; }
    .pv-welcome p { margin: 0 0 24px; font-size: 11px; line-height: 1.6; color: #64748b; padding: 0 8px; }
    .pv-stats { display: flex; border-top: 1px solid #f1f5f9; padding-top: 20px; }
    .pv-stat { flex: 1; text-align: center; }
    .pv-stat-val { font-size: 18px; font-weight: 700; color: #4c33c3; line-height: 1; margin-bottom: 4px; }
    .pv-stat-lbl { font-size: 7px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; }
    .pv-panel-desc { font-size: 10px; color: #64748b; line-height: 1.4; margin: 0 0 16px; flex: 1; }
    .pv-panel-btn { margin-top: auto; padding: 8px 0; border-radius: 4px; background: #4c33c3; color: #fff; font-size: 11px; font-weight: 700; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .pv-session-meta { font-size: 9px; color: #64748b; display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .pv-session-meta i { color: #4c33c3; }
    .pv-session-title { font-size: 12px; font-weight: 700; color: #1e293b; margin: 4px 0; }
    .pv-session-label { font-size: 8px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
    .pv-live { color: #ef4444; font-weight: 600; }

    .pv-stand { position: absolute; right: 2%; top: 160px; width: 5%; min-width: 36px; height: 260px; z-index: 12; display: flex; flex-direction: column; align-items: center; gap: 16px; padding: 16px 0; border-radius: 4px 4px 0 0; border-left: 1px solid #4b5563; border-right: 1px solid #4b5563; background: linear-gradient(to bottom, #374151, #111827); box-shadow: -10px 0 20px rgba(0,0,0,.5); transform: perspective(1000px) rotateY(-12deg); }
    .pv-stand a { width: 85%; height: 48px; border-radius: 4px; border-bottom: 2px solid #818cf8; background: linear-gradient(135deg, #4c33c3, #2c1d75); color: #fff; font-size: 5px; font-weight: 700; display: flex; flex-direction: column; justify-content: flex-end; text-align: center; text-decoration: none; padding: 4px; }
    .pv-plant { position: absolute; bottom: 10%; z-index: 8; display: flex; flex-direction: column; align-items: center; opacity: .9; }
    .pv-plant-left { left: 6%; }
    .pv-plant-right { right: 32%; }
    .pv-plant-top { width: 48px; height: 64px; border-radius: 999px; background: #166534; filter: blur(2px); }
    .pv-plant-pot { width: 32px; height: 40px; border-radius: 0 0 8px 8px; background: #fff; box-shadow: 0 10px 15px rgba(0,0,0,.1); }
    .pv-desk { position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%); width: 35%; height: 80px; z-index: 15; border-radius: 25px 25px 0 0; border: 2px solid rgba(202,138,4,.7); border-bottom: none; background: linear-gradient(to bottom, #2d3748, #111827); box-shadow: 0 -10px 25px rgba(0,0,0,.4); display: flex; align-items: center; justify-content: center; }
    .pv-desk-logo { color: rgba(255,255,255,.9); font-size: 16px; font-weight: 700; letter-spacing: .25em; border-bottom: 1px solid rgba(107,114,128,.5); padding-bottom: 4px; margin-top: 12px; }
    .pv-desk-logo img { max-height: 24px; max-width: 120px; filter: brightness(0) invert(1); object-fit: contain; }
    .pv-desk-tablet { position: absolute; top: -12px; width: 48px; height: 28px; background: #000; border: 2px solid #4b5563; border-radius: 4px; transform: skewX(-12deg) rotate(5deg); display: flex; align-items: center; justify-content: center; }
    .pv-desk-tablet span { width: 40px; height: 20px; border-radius: 2px; background: #4c33c3; opacity: .9; display: block; }

    /* Products */
    .pv-section { padding: 24px; }
    .pv-section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .pv-section-head h2 { margin: 0; font-size: 18px; font-weight: 700; color: #0f172a; }
    .pv-link { font-size: 12px; font-weight: 700; color: #4c33c3; text-decoration: none; }
    .pv-products { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
    @media (max-width: 1024px) { .pv-products { grid-template-columns: repeat(2, minmax(0, 1fr)); } .pv-grid { grid-template-columns: 1fr; min-height: auto; } .pv-stage { height: auto; min-height: 700px; } }
    @media (max-width: 640px) { .pv-products { grid-template-columns: 1fr; } }
    .pv-product { display: flex; gap: 12px; padding: 12px; border-radius: 12px; border: 1px solid #f1f5f9; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,.05); text-decoration: none; color: inherit; }
    .pv-product img, .pv-product-thumb { width: 76px; height: 84px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
    .pv-product-thumb { background: #1e2230; display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 28px; }
    .pv-product h4 { margin: 0 0 4px; font-size: 14px; font-weight: 700; color: #0f172a; }
    .pv-product p { margin: 0 0 8px; font-size: 11px; color: #64748b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .pv-product-cta { font-size: 11px; font-weight: 700; color: #4c33c3; margin-top: auto; }

    /* Feature cards */
    .pv-features { width: 100%; display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 12px; margin-top: 24px; padding-bottom: 8px; }
    @media (max-width: 1200px) { .pv-features { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
    @media (max-width: 900px) { .pv-features { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 500px) { .pv-features { grid-template-columns: 1fr; } }
    .pv-feature { width: 100%; min-width: 0; padding: 20px 16px; border-radius: 12px; border: 1px solid #f1f5f9; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,.04); text-decoration: none; color: inherit; display: flex; flex-direction: column; }
    .pv-feature-icon { width: 40px; height: 40px; border-radius: 50%; border: 2px solid #eef2ff; display: flex; align-items: center; justify-content: center; color: #4c33c3; margin-bottom: 14px; font-size: 16px; }
    .pv-feature-icon.hl { background: #c4b5fd; border-color: #c4b5fd; color: #fff; }
    .pv-feature h4 { margin: 0 0 6px; font-size: 13px; font-weight: 700; color: #1e293b; }
    .pv-feature p { margin: 0 0 16px; flex: 1; font-size: 10px; line-height: 1.5; color: #64748b; }
    .pv-feature-cta { font-size: 11px; font-weight: 700; color: #4c33c3; margin-top: auto; }

    /* Right sidebar */
    .pv-aside-card { padding: 20px; }
    .pv-aside-card h3 { margin: 0 0 16px; font-size: 14px; font-weight: 700; color: #1e293b; }
    .pv-rep { display: flex; gap: 16px; align-items: flex-start; }
    .pv-rep-avatar { position: relative; flex-shrink: 0; }
    .pv-rep-avatar img { width: 46px; height: 46px; border-radius: 50%; object-fit: cover; }
    .pv-rep-dot { position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; border-radius: 50%; background: #22c55e; border: 2px solid #fff; }
    .pv-rep-name { font-size: 13px; font-weight: 700; color: #1e293b; }
    .pv-rep-role { font-size: 11px; color: #64748b; margin: 2px 0 12px; }
    .pv-rep-actions { display: flex; gap: 6px; }
    .pv-rep-actions a { width: 28px; height: 28px; border-radius: 50%; border: 1px solid #e5e7eb; background: #fff; color: #94a3b8; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; }
    .pv-aside-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .pv-aside-head h3 { margin: 0; }
    .pv-metric { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; }
    .pv-metric-left { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #475569; }
    .pv-metric-left i { width: 20px; text-align: center; font-size: 15px; }
    .pv-metric-val { font-size: 15px; font-weight: 700; color: #1e293b; }
    .pv-empty { text-align: center; padding: 16px; background: #f8fafc; border-radius: 8px; color: #4c33c3; font-size: 13px; font-weight: 600; text-decoration: none; display: block; }
    .pv-alert { margin-bottom: 20px; padding: 12px 16px; border-radius: 8px; border: 1px solid #a7f3d0; background: #ecfdf5; color: #047857; font-size: 14px; font-weight: 600; }
</style>

<div class="pv">
    <div class="pv-wrap">
        <div class="pv-card pv-top">
            <div class="pv-top-left">
                <div class="pv-top-icon"><i class="fa-solid fa-store"></i></div>
                <div>
                    <h2 class="pv-top-title">{{ $p['companyName'] }}</h2>
                    <p class="pv-top-sub">{{ $p['hallName'] }} / Booth {{ $p['boothNumber'] }}</p>
                </div>
            </div>
            <div class="pv-actions">
                @if ($visitorPreviewUrl)
                    <a href="{{ $visitorPreviewUrl }}" target="_blank" class="pv-btn-outline"><i class="fa-solid fa-eye" style="margin-right:8px"></i>Preview in Visitor</a>
                @endif
                <form method="POST" action="{{ route('company.booth-setup.preview.mark-ready', $booking) }}">
                    @csrf
                    <input type="hidden" name="next" value="publish">
                    <button type="submit" class="pv-btn-primary">Save & Continue <i class="fa-solid fa-arrow-right" style="margin-left:8px"></i></button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="pv-alert">{{ session('status') }}</div>
        @endif

        <div class="pv-layout">
            <div class="pv-main">
                {{-- 3D Booth --}}
                <div class="pv-stage">
                    <div class="pv-stage-bg"></div>
                    <div class="pv-stage-floor"></div>
                    <div class="pv-stage-wall"></div>
                    <div class="pv-stage-lights">
                        @for ($i = 0; $i < 4; $i++) <div class="pv-stage-light"></div> @endfor
                    </div>

                    <div class="pv-stage-content">
                        <div class="pv-banner">
                            <div class="pv-banner-logo">
                                @if ($p['logoUrl'])
                                    <img src="{{ $p['logoUrl'] }}" alt="{{ $p['companyName'] }}">
                                @else
                                    YOUR<br>LOGO
                                @endif
                            </div>
                            <div class="pv-banner-text">
                                <h1>{{ $p['companyName'] }}</h1>
                                @if ($p['tagline'])
                                    <p>{{ $p['tagline'] }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="pv-grid">
                            <div class="pv-col">
                                <div class="pv-panel">
                                    <p class="pv-panel-title">{{ $p['videoTitle'] }}</p>
                                    <a href="{{ $p['videoUrl'] ?: $routes('company.booth-setup.media.index') }}" @if($p['videoUrl']) target="_blank" @endif class="pv-video">
                                        @if ($p['videoThumb'])
                                            <img src="{{ $p['videoThumb'] }}" alt="{{ $p['videoTitle'] }}">
                                        @else
                                            <div style="width:100%;height:100%;background:#111;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:11px">{{ $p['videoTitle'] }}</div>
                                        @endif
                                        <div class="pv-video-play"><span><i class="fa-solid fa-play" style="margin-left:2px;font-size:12px"></i></span></div>
                                    </a>
                                </div>
                                <div class="pv-panel">
                                    <p class="pv-panel-title">{{ $p['brochureHeading'] }}</p>
                                    <div class="pv-brochure-body">
                                        <div class="pv-brochure-icon">{{ \Illuminate\Support\Str::limit($p['brochureTitle'], 24) }}</div>
                                        @if ($p['brochureUrl'])
                                            <a href="{{ $p['brochureUrl'] }}" target="_blank" class="pv-btn-sm">Download <i class="fa-solid fa-download"></i></a>
                                        @else
                                            <a href="{{ $routes('company.booth-setup.catalogues.index') }}" class="pv-btn-sm">Upload <i class="fa-solid fa-upload"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="pv-col">
                                <div class="pv-panel pv-welcome">
                                    <h2>{{ $p['welcomeHeading'] }}</h2>
                                    <p>{{ $p['aboutText'] }}</p>
                                    <div class="pv-stats">
                                        @foreach ([['years_experience', 'Years Experience'], ['clients', 'Clients'], ['countries', 'Countries'], ['team_size', 'Expert Team']] as [$key, $label])
                                            <div class="pv-stat">
                                                <div class="pv-stat-val">{{ filled($stats[$key] ?? null) ? $stats[$key] : '0' }}</div>
                                                <div class="pv-stat-lbl">{{ $label }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="pv-col">
                                <a href="{{ $routes('company.booth-setup.meetings.edit') }}" class="pv-panel">
                                    <p class="pv-panel-title">Live Session (1 to 1 Meet)</p>
                                    <p class="pv-panel-desc">{{ $p['meetingSlotsText'] }}</p>
                                    <div class="pv-panel-btn"><i class="fa-regular fa-calendar-check"></i> Request Meeting</div>
                                </a>
                                <a href="{{ $routes('company.booth-setup.sessions.index') }}" class="pv-panel">
                                    <p class="pv-panel-title">Join Conference / Webinar</p>
                                    @if ($p['nextSession'])
                                        <div class="pv-session-label">Next Session</div>
                                        <div class="pv-session-title">{{ $p['nextSession']->title }}</div>
                                        @if ($p['sessionDescription'])
                                            <p class="pv-panel-desc" style="margin-bottom:8px">{{ \Illuminate\Support\Str::limit($p['sessionDescription'], 80) }}</p>
                                        @endif
                                        <div class="pv-session-meta">
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $p['sessionDateLine'] }}
                                            @if ($p['liveSession'])<span class="pv-live">· Live</span>@endif
                                        </div>
                                    @else
                                        <p class="pv-panel-desc">No upcoming sessions scheduled yet.</p>
                                    @endif
                                    <div class="pv-panel-btn" style="margin-top:12px"><i class="fa-solid fa-video"></i> Join Session</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="pv-stand">
                        <a href="{{ $routes('company.booth-setup.profile.edit') }}">Profile</a>
                        <a href="{{ $routes('company.booth-setup.catalogues.index') }}">Catalog</a>
                        <a href="{{ $routes('company.booth-setup.analytics') }}">Report</a>
                    </div>
                    <div class="pv-plant pv-plant-left"><div class="pv-plant-top"></div><div class="pv-plant-pot"></div></div>
                    <div class="pv-plant pv-plant-right"><div class="pv-plant-top"></div><div class="pv-plant-pot"></div></div>
                    <div class="pv-desk">
                        <div class="pv-desk-logo">
                            @if ($p['logoUrl'])
                                <img src="{{ $p['logoUrl'] }}" alt="{{ $p['companyName'] }}">
                            @else
                                YOUR LOGO
                            @endif
                        </div>
                        <div class="pv-desk-tablet"><span></span></div>
                    </div>
                </div>

                {{-- Products --}}
                <div class="pv-card pv-section" id="products">
                    <div class="pv-section-head">
                        <h2>Our Products & Services</h2>
                        <a href="{{ $routes('company.booth-setup.products.index') }}" class="pv-link">View All</a>
                    </div>
                    <div class="pv-products">
                        @forelse ($products->take(4) as $product)
                            <a href="{{ route('company.booth-setup.products.edit', [$booking, $product]) }}" class="pv-product">
                                @if ($product->product_image)
                                    <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="pv-product-thumb"><i class="fa-solid fa-box"></i></div>
                                @endif
                                <div>
                                    <h4>{{ $product->name }}</h4>
                                    <p>{{ $product->short_description ?: 'Add a short description for this product.' }}</p>
                                    <div class="pv-product-cta">Learn More <i class="fa-solid fa-arrow-right" style="font-size:9px"></i></div>
                                </div>
                            </a>
                        @empty
                            <p style="grid-column:1/-1;text-align:center;padding:24px;color:#64748b">No published products yet. <a href="{{ $routes('company.booth-setup.products.create') }}" class="pv-link">Add products</a></p>
                        @endforelse
                    </div>
                </div>
            </div>

            <aside class="pv-aside">
                <div class="pv-card pv-aside-card">
                    <h3>Booth Representatives</h3>
                    @if ($p['rep'])
                        <div class="pv-rep">
                            <div class="pv-rep-avatar">
                                <img src="{{ $p['rep']->photo ? asset('storage/' . $p['rep']->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($p['rep']->name) . '&background=f1f5f9&color=334155' }}" alt="{{ $p['rep']->name }}">
                                <div class="pv-rep-dot"></div>
                            </div>
                            <div>
                                <div class="pv-rep-name">{{ $p['rep']->name }}</div>
                                <div class="pv-rep-role">{{ $p['rep']->designation }}</div>
                                <div class="pv-rep-actions">
                                    <a href="{{ route('company.booth-setup.team-members.edit', [$booking, $p['rep']]) }}" title="Manage"><i class="fa-regular fa-comment-dots"></i></a>
                                    @if ($p['repEmail'])
                                        <a href="mailto:{{ $p['repEmail'] }}" title="Email"><i class="fa-regular fa-envelope"></i></a>
                                    @endif
                                    <a href="{{ $routes('company.booth-setup.meetings.edit') }}" title="Meetings"><i class="fa-regular fa-calendar-check"></i></a>
                                    @if ($p['repPhone'])
                                        <a href="tel:{{ $p['repPhone'] }}" title="Call"><i class="fa-solid fa-phone"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $routes('company.booth-setup.team-members.create') }}" class="pv-empty">Add team member</a>
                    @endif
                </div>

                <div class="pv-card pv-aside-card">
                    <div class="pv-aside-head">
                        <h3>Visitor Reporting</h3>
                        <a href="{{ $routes('company.booth-setup.analytics') }}" class="pv-link" style="font-size:11px">View All</a>
                    </div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-solid fa-users" style="color:#a78bfa"></i>Total Visitors</div><span class="pv-metric-val">{{ number_format($visitorStats['total']) }}</span></div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-regular fa-user" style="color:#38bdf8"></i>Unique Visitors</div><span class="pv-metric-val">{{ number_format($visitorStats['unique']) }}</span></div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-solid fa-arrow-right-arrow-left" style="color:#c084fc"></i>Returning Visitors</div><span class="pv-metric-val">{{ number_format($visitorStats['returning']) }}</span></div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-regular fa-clock" style="color:#4ade80"></i>Avg. Time Spent</div><span class="pv-metric-val">{{ $visitorStats['avg_time'] }} min</span></div>
                </div>

                <div class="pv-card pv-aside-card">
                    <div class="pv-aside-head">
                        <h3>Business Leads</h3>
                        <a href="{{ route('company.enquiries.index') }}" class="pv-link" style="font-size:11px">View All</a>
                    </div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-solid fa-user-tie" style="color:#60a5fa"></i>Total Leads</div><span class="pv-metric-val">{{ number_format($leadStats['total']) }}</span></div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-solid fa-fire" style="color:#fb923c"></i>Hot Leads</div><span class="pv-metric-val">{{ number_format($leadStats['hot']) }}</span></div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-solid fa-check-double" style="color:#4ade80"></i>Qualified Leads</div><span class="pv-metric-val">{{ number_format($leadStats['qualified']) }}</span></div>
                    <div class="pv-metric"><div class="pv-metric-left"><i class="fa-solid fa-bolt" style="color:#a855f7"></i>New Leads</div><span class="pv-metric-val">{{ number_format($leadStats['new']) }}</span></div>
                </div>
            </aside>
        </div>

        {{-- Feature cards — full width below booth + sidebar --}}
        <div class="pv-features">
            @foreach ($featureCards as $card)
                <a href="{{ $card['url'] }}" class="pv-feature">
                    <div class="pv-feature-icon {{ $card['highlight'] ? 'hl' : '' }}"><i class="{{ $card['icon'] }}"></i></div>
                    <h4>{{ $card['title'] }}</h4>
                    <p>{{ $card['desc'] }}</p>
                    <div class="pv-feature-cta">{{ $card['cta'] }} <i class="fa-solid fa-arrow-right" style="font-size:9px"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
