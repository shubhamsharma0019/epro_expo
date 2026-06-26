@php
    $title = $title ?? ($exhibition->title ?? $exhibition->name ?? 'Exhibition');
    $ticketUrl = $ticketUrl ?? \App\Support\ExhibitionTicketFlow::visitorPassEntryUrl($slug);
    $bannerImage = $bannerImage ?? asset('images/exhibitions/hero-pavilion-scene.png');
    $dateStr = $dateStr ?? 'Date TBD';
    $location = $location ?? 'Virtual';
    $timeStr = $timeStr ?? 'Time TBD';
    $eventType = $eventType ?? 'On-site';
    $statusLabel = $statusLabel ?? 'Live registration';
    $tags = $tags ?? ['Expo', 'Interactive'];
    $participatingCompanies = $participatingCompanies ?? collect();
    $speakerCards = $speakerCards ?? collect();
    $displayCompanies = $displayCompanies ?? 0;
    $displayCountries = $displayCountries ?? 0;
    $displaySpeakers = $displaySpeakers ?? 0;
    $displaySessions = $displaySessions ?? 0;
    $expectations = $expectations ?? [];
    $visibleTabs = $visibleTabs ?? [['id' => 'overview', 'label' => 'Overview', 'icon' => 'ph-layout', 'show' => true]];
    $firstTabId = $visibleTabs[0]['id'] ?? 'overview';
    $agenda = $agenda ?? collect();
    $sponsors = $sponsors ?? collect();
    $faqs = $faqs ?? collect();
    $halls = $halls ?? collect();
    $displayPavilions = $halls->pluck('pavilion.title')->filter()->unique()->count();
    $displayHalls = $halls->count();
    $description = $exhibition->description ?: 'Explore the latest technologies, interact with global business leaders, and discover innovative solutions. Enter virtual lobbies, book corporate meetings, download brochures, and attend live product demos.';
    $heroBadge = strtoupper($eventType ?: 'Expo & Innovation');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Exhibition Details - EproExpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f0f2f9; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .perspective-1000 { perspective: 1000px; }
    </style>
</head>
<body class="min-h-screen bg-[#f0f2f9] text-[#0f172a] font-sans antialiased selection:bg-indigo-200 selection:text-indigo-900">

    <main class="flex min-h-screen w-full flex-col">
        <div id="header-container" class="relative z-40 w-full shrink-0 bg-white">
            @include('frontend.exhibitions.tickets.header', ['hideMobileMenu' => true])
        </div>

        <div class="relative flex-1 overflow-y-auto pb-6 sm:pb-8">
            <div class="w-full space-y-8 pb-4 md:pb-8">

                {{-- HERO --}}
                <section class="relative overflow-hidden rounded-b-[2.5rem] border border-t-0 border-white/60 bg-gradient-to-br from-[#ffffff] via-[#faf8ff] to-[#f4efff] pb-2 shadow-[0_20px_40px_-15px_rgba(109,40,217,0.15)] lg:pb-3">
                    <div class="relative h-full w-full overflow-hidden rounded-b-[2.25rem] border border-t-0 border-white/50 bg-white/40 p-6 backdrop-blur-3xl sm:p-8 lg:p-12">
                        <div class="pointer-events-none absolute right-0 top-0 h-full w-full opacity-30" style="background-image: radial-gradient(#d8b4fe 2px, transparent 2px); background-size: 30px 30px;"></div>
                        <div class="absolute -right-40 -top-40 h-96 w-96 animate-pulse rounded-full bg-purple-400 opacity-30 mix-blend-multiply blur-3xl filter"></div>
                        <div class="absolute -bottom-40 -left-40 h-96 w-96 animate-pulse rounded-full bg-indigo-400 opacity-30 mix-blend-multiply blur-3xl filter" style="animation-delay: 2s;"></div>

                        <div class="relative z-10 grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                            <div>
                                <a href="{{ url('/exhibitions') }}" class="mb-8 inline-flex cursor-pointer items-center gap-2 text-sm font-semibold uppercase tracking-wide text-indigo-600 transition-colors hover:text-indigo-800">
                                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                                    Back to Exhibitions
                                </a>

                                <div class="mb-5 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-2 rounded-full border border-indigo-200/50 bg-gradient-to-r from-purple-100 to-indigo-100 px-4 py-1.5 text-xs font-bold tracking-widest text-indigo-800 shadow-sm">
                                        <span class="h-2 w-2 animate-pulse rounded-full bg-indigo-600"></span>
                                        {{ $heroBadge }}
                                    </span>
                                    @foreach (collect($tags)->take(2) as $tag)
                                        <span class="rounded-full border border-indigo-100 bg-white px-4 py-1.5 text-xs font-bold tracking-widest text-indigo-700 shadow-sm">{{ strtoupper($tag) }}</span>
                                    @endforeach
                                </div>

                                <h1 id="exh-name" class="mb-4 bg-gradient-to-r from-slate-900 via-indigo-900 to-purple-900 bg-clip-text text-5xl font-black tracking-tighter text-transparent md:text-7xl">{{ $title }}</h1>

                                <p class="mb-8 text-2xl font-light text-slate-600">
                                    Where <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text font-bold text-transparent">Innovation</span> Meets the Future
                                </p>

                                <div class="mb-6 inline-flex flex-wrap gap-6 rounded-2xl border border-white/60 bg-white/50 p-4 font-medium text-slate-700 shadow-sm backdrop-blur-md">
                                    <span class="flex items-center gap-2"><i data-lucide="calendar" class="h-5 w-5 text-indigo-500"></i> <span id="exh-dates">{{ $dateStr }}</span></span>
                                    <span class="flex items-center gap-2"><i data-lucide="clock" class="h-5 w-5 text-indigo-500"></i> {{ $timeStr }}</span>
                                    <span class="flex items-center gap-2"><i data-lucide="map-pin" class="h-5 w-5 text-indigo-500"></i> <span id="exh-venue">{{ $location }}</span></span>
                                </div>

                                <div class="mb-6 flex flex-wrap gap-3">
                                    @foreach ($tags as $tag)
                                        <span class="rounded-full border border-indigo-100 bg-white px-4 py-1 text-sm font-bold text-indigo-700 shadow-sm">{{ $tag }}</span>
                                    @endforeach
                                </div>

                                <p id="exh-description" class="mb-8 max-w-xl text-lg leading-relaxed text-slate-600">{{ $description }}</p>

                                <div class="flex flex-wrap gap-4">
                                    <a id="get-pass-btn-hero" href="{{ $ticketUrl }}" class="group flex items-center gap-3 rounded-xl bg-gradient-to-r from-indigo-600 via-purple-600 to-fuchsia-600 px-8 py-4 font-bold text-white shadow-lg shadow-purple-500/30 transition-all hover:-translate-y-0.5 hover:shadow-purple-500/50">
                                        Get Visitor Pass <i data-lucide="arrow-right" class="h-5 w-5 transition-transform group-hover:translate-x-1"></i>
                                    </a>
                                    <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="flex items-center gap-3 rounded-xl border-2 border-indigo-100 bg-white/50 px-8 py-4 font-bold text-indigo-900 shadow-sm transition-all hover:border-indigo-200 hover:bg-white">
                                        <i data-lucide="map" class="h-5 w-5 text-indigo-600"></i> View Floor Plan
                                    </a>
                                </div>
                            </div>

                            <div class="group relative mt-8 perspective-1000 lg:mt-0">
                                <div class="absolute -inset-4 rounded-[3rem] bg-gradient-to-br from-purple-500 to-indigo-500 opacity-20 blur-2xl transition-opacity duration-500 group-hover:opacity-40"></div>
                                <div class="relative overflow-hidden rounded-[2.5rem] border-[8px] border-white/80 shadow-2xl transition-transform duration-500 hover:rotate-1 hover:scale-[1.02]">
                                    <img src="{{ $bannerImage }}" alt="{{ $title }}" class="h-[360px] w-full scale-105 object-cover lg:h-[450px]">
                                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/40 to-transparent mix-blend-multiply"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- STATS --}}
                <section class="relative overflow-hidden rounded-[2rem] border border-indigo-100 bg-white shadow-xl">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-[0.03]"></div>
                    <div class="absolute right-1/4 top-0 h-96 w-96 rounded-full bg-purple-200/40 blur-3xl"></div>
                    <div class="absolute bottom-0 left-1/4 h-96 w-96 rounded-full bg-blue-200/40 blur-3xl"></div>

                    <div class="relative grid grid-cols-1 gap-8 divide-y divide-indigo-100 p-8 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4 lg:p-12">
                        <div class="flex flex-col items-center px-4 pt-6 text-center sm:pt-0">
                            <div class="mb-6 h-16 w-16 -rotate-3 transform rounded-2xl bg-gradient-to-br from-purple-200 to-indigo-300 p-[2px] shadow-[0_0_20px_-5px_rgba(139,92,246,0.3)]">
                                <div class="flex h-full w-full items-center justify-center rounded-[14px] bg-white">
                                    <i data-lucide="building-2" class="h-8 w-8 text-purple-600"></i>
                                </div>
                            </div>
                            <h2 class="mb-2 text-4xl font-black tracking-tight text-indigo-950 md:text-5xl"><span id="exh-companies-count">{{ $displayCompanies }}</span></h2>
                            <p class="mb-1 text-sm font-bold uppercase tracking-wider text-purple-600">Companies</p>
                            <p class="text-sm text-slate-500">Leading the future of innovation</p>
                        </div>

                        <div class="flex flex-col items-center px-4 pt-6 text-center sm:pt-0">
                            <div class="mb-6 h-16 w-16 rotate-3 transform rounded-2xl bg-gradient-to-br from-blue-200 to-cyan-300 p-[2px] shadow-[0_0_20px_-5px_rgba(59,130,246,0.3)]">
                                <div class="flex h-full w-full items-center justify-center rounded-[14px] bg-white">
                                    <i data-lucide="globe" class="h-8 w-8 text-blue-600"></i>
                                </div>
                            </div>
                            <h2 class="mb-2 text-4xl font-black tracking-tight text-indigo-950 md:text-5xl">{{ $displayCountries }}</h2>
                            <p class="mb-1 text-sm font-bold uppercase tracking-wider text-blue-600">Countries</p>
                            <p class="text-sm text-slate-500">Global participation</p>
                        </div>

                        <div class="flex flex-col items-center px-4 pt-6 text-center sm:pt-0">
                            <div class="mb-6 h-16 w-16 -rotate-3 transform rounded-2xl bg-gradient-to-br from-fuchsia-200 to-pink-300 p-[2px] shadow-[0_0_20px_-5px_rgba(217,70,239,0.3)]">
                                <div class="flex h-full w-full items-center justify-center rounded-[14px] bg-white">
                                    <i data-lucide="users" class="h-8 w-8 text-fuchsia-600"></i>
                                </div>
                            </div>
                            <h2 class="mb-2 text-4xl font-black tracking-tight text-indigo-950 md:text-5xl">{{ $displaySpeakers }}</h2>
                            <p class="mb-1 text-sm font-bold uppercase tracking-wider text-fuchsia-600">Speakers</p>
                            <p class="text-sm text-slate-500">Industry thought leaders</p>
                        </div>

                        <div class="flex flex-col items-center px-4 pt-6 text-center sm:pt-0">
                            <div class="mb-6 h-16 w-16 rotate-3 transform rounded-2xl bg-gradient-to-br from-amber-200 to-orange-300 p-[2px] shadow-[0_0_20px_-5px_rgba(245,158,11,0.3)]">
                                <div class="flex h-full w-full items-center justify-center rounded-[14px] bg-white">
                                    <i data-lucide="mic" class="h-8 w-8 text-amber-600"></i>
                                </div>
                            </div>
                            <h2 class="mb-2 text-4xl font-black tracking-tight text-indigo-950 md:text-5xl">{{ $displaySessions }}</h2>
                            <p class="mb-1 text-sm font-bold uppercase tracking-wider text-amber-600">Sessions</p>
                            <p class="text-sm text-slate-500">Power-packed insights</p>
                        </div>
                    </div>
                </section>

                {{-- CONTENT --}}
                <section class="grid grid-cols-1 gap-8 lg:grid-cols-[2fr_1fr]">
                    <div class="rounded-[2rem] border border-slate-200/60 bg-white p-6 shadow-sm sm:p-8 lg:p-10">
                        <nav class="no-scrollbar mb-8 flex gap-8 overflow-x-auto border-b border-slate-100 pb-1 font-semibold text-slate-500">
                            @foreach ($visibleTabs as $tab)
                                <button
                                    id="tab-{{ $tab['id'] }}"
                                    data-tab="{{ $tab['id'] }}"
                                    onclick="switchTab('{{ $tab['id'] }}', this)"
                                    class="tab-btn whitespace-nowrap px-1 pb-4 transition-colors {{ $loop->first ? 'border-b-2 border-indigo-600 text-indigo-700' : 'hover:text-slate-800' }}"
                                >{{ $tab['label'] }}</button>
                            @endforeach
                        </nav>

                        <div id="tab-panels-container">
                            {{-- Overview --}}
                            <div id="panel-overview" class="tab-panel {{ $firstTabId === 'overview' ? '' : 'hidden' }}">
                                <div class="group mb-6 rounded-2xl border border-slate-100 bg-slate-50/50 p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50">
                                    <div class="flex gap-5">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white">
                                            <i data-lucide="star" class="h-6 w-6"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="mb-3 text-xl font-bold text-slate-800">What to Expect</h3>
                                            <ul class="space-y-4 leading-relaxed text-slate-600">
                                                @foreach ($expectations as [, $label])
                                                    <li class="flex items-start gap-3">
                                                        <i data-lucide="check-circle-2" class="mt-0.5 h-5 w-5 shrink-0 text-indigo-500"></i>
                                                        {{ $label }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="group mb-6 rounded-2xl border border-slate-100 bg-slate-50/50 p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50">
                                    <div class="flex gap-5">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white">
                                            <i data-lucide="info" class="h-6 w-6"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="mb-3 text-xl font-bold text-slate-800">About This Exhibition</h3>
                                            <p class="leading-relaxed text-slate-600">{{ $description }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="group mb-6 rounded-2xl border border-slate-100 bg-slate-50/50 p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50">
                                    <div class="flex gap-5">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white">
                                            <i data-lucide="building-2" class="h-6 w-6"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="mb-4 text-xl font-bold text-slate-800">Participating Companies</h3>
                                            <div class="space-y-4">
                                                @forelse ($participatingCompanies->take(6) as $company)
                                                    <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition-shadow hover:shadow-md">
                                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                                            <div class="flex items-center gap-4">
                                                                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-slate-50 p-2">
                                                                    @if($company['logo_url'])
                                                                        <img src="{{ $company['logo_url'] }}" alt="{{ $company['name'] }}" class="max-h-full max-w-full object-contain">
                                                                    @else
                                                                        <div class="flex h-full w-full items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 text-xs font-bold uppercase text-white">
                                                                            {{ substr($company['name'], 0, 2) }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <h4 class="font-black text-slate-800">{{ $company['name'] }}</h4>
                                                                    <p class="text-sm text-slate-500">{{ $company['location'] }}</p>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('exhibitions.visitor.companies.show', ['slug' => $slug, 'companySlug' => $company['slug']]) }}" class="w-full rounded-lg border-2 border-indigo-100 py-2 text-center text-sm font-bold text-indigo-700 transition-colors hover:border-indigo-600 sm:w-auto sm:px-5">View Booth</a>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="py-6 text-center text-sm font-semibold text-slate-500">No exhibitors registered yet.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a id="get-pass-btn" href="{{ $ticketUrl }}" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-3.5 font-bold text-white shadow-md transition-all hover:bg-indigo-600 hover:shadow-indigo-500/30">
                                    Get Visitor Pass <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>

                            {{-- Agenda --}}
                            <div id="panel-agenda" class="tab-panel {{ $firstTabId === 'agenda' ? '' : 'hidden' }}">
                                <h2 class="mb-6 text-xl font-bold text-slate-800">Conference Agenda / Schedule</h2>
                                <div class="space-y-6">
                                    @forelse ($agenda as $session)
                                        <div class="flex flex-col gap-4 border-b border-slate-100 pb-6 last:border-0 last:pb-0 sm:flex-row sm:items-start sm:gap-6">
                                            <div class="w-full shrink-0 sm:w-[120px]">
                                                <div class="mb-0.5 text-sm font-bold text-indigo-600">{{ $session->start_time }}</div>
                                                <div class="text-[11px] font-semibold uppercase text-slate-400">{{ $session->end_time ?: 'Session' }}</div>
                                                @if($session->date)
                                                    <div class="mt-1 text-[10px] font-semibold text-slate-400">{{ $session->date }}</div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="mb-1.5 text-[15px] font-bold text-slate-800">{{ $session->title }}</h3>
                                                <p class="mb-3 text-[13px] leading-relaxed text-slate-500">{{ $session->description }}</p>
                                                <div class="flex flex-wrap gap-4 text-[12px] font-semibold text-slate-600">
                                                    @if($session->speaker_name)
                                                        <div class="flex items-center gap-1.5"><i class="ph ph-user text-[16px] text-indigo-500"></i> {{ $session->speaker_name }}</div>
                                                    @endif
                                                    @if($session->hall_name)
                                                        <div class="flex items-center gap-1.5"><i class="ph ph-map-pin text-[16px] text-indigo-500"></i> {{ $session->hall_name }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-6 text-sm text-slate-400">No agenda sessions listed for this event.</div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Speakers --}}
                            <div id="panel-speakers" class="tab-panel {{ $firstTabId === 'speakers' ? '' : 'hidden' }}">
                                <h2 class="mb-6 text-xl font-bold text-slate-800">Keynote Speakers</h2>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    @forelse ($speakerCards as $sp)
                                        <div class="flex flex-col items-center rounded-2xl border border-slate-100 bg-white p-6 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-indigo-100 hover:shadow-md">
                                            @if($sp->avatar_url)
                                                <img src="{{ $sp->avatar_url }}" alt="{{ $sp->name }}" class="mb-4 h-16 w-16 rounded-full border-2 border-indigo-50 object-cover">
                                            @else
                                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full border border-indigo-100 bg-indigo-50 text-xl font-bold text-indigo-600">
                                                    {{ substr($sp->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <h4 class="mb-1 text-[15px] font-bold text-slate-800">{{ $sp->name }}</h4>
                                            <div class="mb-3 text-[11px] font-bold text-indigo-600">{{ $sp->title }} @if($sp->company) • {{ $sp->company }} @endif</div>
                                            <p class="line-clamp-3 text-[12px] font-medium leading-relaxed text-slate-500">{{ $sp->bio }}</p>
                                        </div>
                                    @empty
                                        <div class="col-span-full py-6 text-center text-sm text-slate-400">No keynote speakers listed.</div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Sponsors --}}
                            <div id="panel-sponsors" class="tab-panel {{ $firstTabId === 'sponsors' ? '' : 'hidden' }}">
                                <h2 class="mb-8 text-center text-xl font-bold text-slate-800">Event Sponsors & Partners</h2>
                                @php
                                    $platinumSponsors = $sponsors->where('level', 'Platinum');
                                    $goldSponsors = $sponsors->where('level', 'Gold');
                                    $silverSponsors = $sponsors->where('level', 'Silver');
                                @endphp
                                <div class="space-y-12">
                                    <div>
                                        <div class="mb-4 flex items-center gap-4">
                                            <span class="rounded border border-indigo-100 bg-indigo-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-indigo-700">Platinum Sponsors</span>
                                            <div class="h-px flex-1 bg-slate-100"></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                                            @forelse ($platinumSponsors as $sp)
                                                <div class="flex h-[90px] flex-col items-center justify-center rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md">
                                                    @if($sp->logo_url)
                                                        <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="mb-1 h-7 max-w-full object-contain">
                                                    @endif
                                                    <span class="text-[9px] font-bold uppercase tracking-wide text-slate-400">{{ $sp->name }}</span>
                                                </div>
                                            @empty
                                                <div class="col-span-full text-center text-[12px] text-slate-400">No Platinum Sponsors.</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mb-4 flex items-center gap-4">
                                            <span class="rounded border border-yellow-100 bg-yellow-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-yellow-700">Gold Sponsors</span>
                                            <div class="h-px flex-1 bg-slate-100"></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                                            @forelse ($goldSponsors as $sp)
                                                <div class="flex h-[90px] flex-col items-center justify-center rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md">
                                                    @if($sp->logo_url)
                                                        <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="mb-1 h-7 max-w-full object-contain">
                                                    @endif
                                                    <span class="text-[9px] font-bold uppercase tracking-wide text-slate-400">{{ $sp->name }}</span>
                                                </div>
                                            @empty
                                                <div class="col-span-full text-center text-[12px] text-slate-400">No Gold Sponsors.</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mb-4 flex items-center gap-4">
                                            <span class="rounded border border-gray-100 bg-gray-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-gray-600">Silver Sponsors</span>
                                            <div class="h-px flex-1 bg-slate-100"></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                                            @forelse ($silverSponsors as $sp)
                                                <div class="flex h-[90px] flex-col items-center justify-center rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md">
                                                    @if($sp->logo_url)
                                                        <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="mb-1 h-7 max-w-full object-contain">
                                                    @endif
                                                    <span class="text-[9px] font-bold uppercase tracking-wide text-slate-400">{{ $sp->name }}</span>
                                                </div>
                                            @empty
                                                <div class="col-span-full text-center text-[12px] text-slate-400">No Silver Sponsors.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Floor Plan --}}
                            <div id="panel-floorplan" class="tab-panel {{ $firstTabId === 'floorplan' ? '' : 'hidden' }}">
                                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <h2 class="text-xl font-bold text-slate-800">Exhibition Halls Floor Plan</h2>
                                    <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-[13px] font-bold text-white shadow-sm transition-colors hover:bg-indigo-700 sm:w-auto">
                                        <i class="ph ph-map-trifold text-[18px]"></i> Full Floor Map
                                    </a>
                                </div>
                                <p class="mb-8 text-[13px] leading-relaxed text-slate-500">Select any hall below to explore interactive booths, find registered exhibitors, or book B2B meeting slots.</p>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                                    @forelse ($halls as $hall)
                                        @php
                                            $hallLogo = $hall->image ? (str_starts_with($hall->image, 'http') ? $hall->image : (str_starts_with($hall->image, 'storage/') ? asset($hall->image) : asset('storage/' . $hall->image))) : asset('images/exhibitions/hall-fallback.jpg');
                                            $badge = $hall->pavilion?->title ?: 'Hall';
                                            $exhibitorsCount = $hall->boothBookings()->where('payment_status', 'paid')->whereIn('booking_status', ['confirmed', 'active'])->where('admin_status', 'approved')->count();
                                        @endphp
                                        <div onclick="window.location.href='{{ route('exhibitions.visitor.floor-map', [$slug, 'hall' => $hall->id]) }}'" class="flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-transform hover:-translate-y-1">
                                            <div class="relative h-28">
                                                <img src="{{ $hallLogo }}" class="h-full w-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=400&q=80'">
                                                <div class="absolute left-2 top-2 rounded bg-indigo-600 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm">{{ $badge }}</div>
                                            </div>
                                            <div class="flex flex-1 flex-col p-4">
                                                <h4 class="mb-1.5 truncate text-[13px] font-bold text-slate-800">{{ $hall->title }}</h4>
                                                <p class="mb-3 line-clamp-2 flex-1 text-[11px] font-medium leading-relaxed text-slate-500">{{ $hall->description }}</p>
                                                <div class="flex items-center justify-between text-[11px] font-bold text-indigo-700">
                                                    <span>{{ $exhibitorsCount }} Exhibitors</span>
                                                    <i class="ph ph-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full py-6 text-center text-sm text-slate-400">No halls active in this exhibition.</div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- FAQs --}}
                            <div id="panel-faqs" class="tab-panel {{ $firstTabId === 'faqs' ? '' : 'hidden' }}">
                                <h2 class="mb-6 text-xl font-bold text-slate-800">Frequently Asked Questions</h2>
                                <div class="space-y-4">
                                    @forelse ($faqs as $idx => $faq)
                                        <div class="overflow-hidden rounded-xl border border-slate-100 bg-slate-50/50">
                                            <button onclick="toggleFaqAccordion({{ $idx }})" class="flex w-full items-center justify-between p-4 text-left text-[13px] font-bold text-slate-800 transition-colors hover:bg-white">
                                                <div class="flex items-center gap-3">
                                                    <i class="ph {{ $faq->icon ?: 'ph-question' }} text-[18px] text-indigo-600"></i>
                                                    <span>{{ $faq->question }}</span>
                                                </div>
                                                <i id="faq-chevron-{{ $idx }}" class="ph ph-caret-down text-[16px] text-slate-400 transition-transform"></i>
                                            </button>
                                            <div id="faq-answer-{{ $idx }}" class="hidden border-t border-slate-100 bg-white p-4 pt-0 text-[12px] leading-relaxed text-slate-600">
                                                {{ $faq->answer }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-6 text-center text-sm text-slate-400">No FAQs available.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <aside class="space-y-6">
                        <div class="rounded-[1.5rem] border border-slate-200/60 bg-white p-6 shadow-sm transition-shadow hover:shadow-md lg:p-8">
                            <h3 class="mb-6 flex items-center gap-3 text-xl font-black text-slate-800">
                                <span class="h-6 w-1.5 rounded-full bg-indigo-600"></span>
                                Event Information
                            </h3>
                            <div class="flex items-center justify-between border-b border-slate-50 py-3.5">
                                <span class="font-medium text-slate-500">Date</span>
                                <span class="text-right font-bold text-slate-800">{{ $dateStr }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-50 py-3.5">
                                <span class="font-medium text-slate-500">Time</span>
                                <span class="text-right font-bold text-slate-800">{{ $timeStr }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-50 py-3.5">
                                <span class="font-medium text-slate-500">Venue</span>
                                <span class="text-right font-bold text-slate-800">{{ $location }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-50 py-3.5">
                                <span class="font-medium text-slate-500">Event Type</span>
                                <span class="text-right font-bold text-slate-800">{{ $eventType }}</span>
                            </div>
                            @if($displayPavilions > 0)
                                <div class="flex items-center justify-between border-b border-slate-50 py-3.5">
                                    <span class="font-medium text-slate-500">Pavilions</span>
                                    <span class="text-right font-bold text-slate-800">{{ $displayPavilions }}</span>
                                </div>
                            @endif
                            @if($displayHalls > 0)
                                <div class="flex items-center justify-between py-3.5">
                                    <span class="font-medium text-slate-500">Halls</span>
                                    <span class="text-right font-bold text-slate-800">{{ $displayHalls }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="rounded-[1.5rem] border border-slate-200/60 bg-white p-6 shadow-sm transition-shadow hover:shadow-md lg:p-8">
                            <h3 class="mb-6 flex items-center gap-3 text-xl font-black text-slate-800">
                                <span class="h-6 w-1.5 rounded-full bg-indigo-600"></span>
                                Organizer
                            </h3>
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-lg font-bold text-indigo-600">
                                    @if($exhibition->organizer_logo)
                                        <img src="{{ str_starts_with($exhibition->organizer_logo, 'http') ? $exhibition->organizer_logo : asset('storage/' . $exhibition->organizer_logo) }}" alt="Organizer" class="h-full w-full rounded-2xl object-contain">
                                    @else
                                        <i data-lucide="user" class="h-5 w-5"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ $exhibition->organizer_name ?: $title }}</h4>
                                    <p class="mt-0.5 text-xs font-medium text-slate-400">Exhibition Organizer</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-[1.5rem] border border-slate-200/60 bg-white p-6 shadow-sm transition-shadow hover:shadow-md lg:p-8">
                            <h3 class="mb-6 flex items-center gap-3 text-xl font-black text-slate-800">
                                <span class="h-6 w-1.5 rounded-full bg-indigo-600"></span>
                                Quick Actions
                            </h3>
                            <a href="{{ $ticketUrl }}" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-3.5 font-bold text-white shadow-md transition-all hover:bg-indigo-600 hover:shadow-indigo-500/30">
                                Get Visitor Pass <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                            </a>
                            <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl border-2 border-slate-200 py-3.5 font-bold text-slate-700 transition-colors hover:border-indigo-600 hover:text-indigo-700">
                                <i data-lucide="map" class="h-4 w-4"></i> View Floor Plan
                            </a>
                            <button onclick="shareExhibition()" class="mt-3 w-full rounded-xl border-2 border-slate-200 py-3.5 font-bold text-slate-700 transition-colors hover:border-indigo-600 hover:text-indigo-700">
                                Share Event
                            </button>
                        </div>
                    </aside>
                </section>
            </div>
        </div>
    </main>

    <script>
        function switchTab(tabId, el, updateHash = true) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));

            const targetPanel = document.getElementById(`panel-${tabId}`);
            if (targetPanel) targetPanel.classList.remove('hidden');

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-b-2', 'border-indigo-600', 'text-indigo-700');
                btn.classList.add('text-slate-500', 'hover:text-slate-800');
            });

            el.classList.remove('text-slate-500', 'hover:text-slate-800');
            el.classList.add('border-b-2', 'border-indigo-600', 'text-indigo-700');

            if (updateHash) {
                window.location.hash = `tab-${tabId}`;
            }

            if (window.lucide) lucide.createIcons();
        }

        function openTabFromHash() {
            const hash = window.location.hash.replace('#', '');
            if (!hash.startsWith('tab-')) return;

            const tabId = hash.replace('tab-', '');
            const tabButton = document.getElementById(`tab-${tabId}`);

            if (tabButton) {
                switchTab(tabId, tabButton, false);
            }
        }

        function toggleFaqAccordion(idx) {
            const answer = document.getElementById(`faq-answer-${idx}`);
            const chevron = document.getElementById(`faq-chevron-${idx}`);
            if (answer && chevron) {
                const isHidden = answer.classList.contains('hidden');
                if (isHidden) {
                    answer.classList.remove('hidden');
                    chevron.classList.add('rotate-180');
                } else {
                    answer.classList.add('hidden');
                    chevron.classList.remove('rotate-180');
                }
            }
        }

        function shareExhibition() {
            if (navigator.share) {
                navigator.share({
                    title: @json($title),
                    url: window.location.href
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Event link copied to clipboard!');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
            openTabFromHash();
        });
        window.addEventListener('hashchange', openTabFromHash);
    </script>
</body>
</html>
