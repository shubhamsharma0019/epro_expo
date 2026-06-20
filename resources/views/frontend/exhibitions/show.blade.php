@php
    $title = $exhibition->title ?: $exhibition->name;
    $ticketUrl = auth()->check()
        ? route('exhibitions.visitor.dashboard', $slug)
        : route('exhibitions.visitor.login', ['exhibition' => $slug]);
    
    $publishedBookings = ($exhibition->boothBookings ?? collect())->values();

    // Resolve banner image directly from database
    $bannerImage = $exhibition->banner_image ?: ($exhibition->banner_url ?: 'images/exhibitions/hero-pavilion-scene.png');

    if (str_starts_with($bannerImage, 'http://') || str_starts_with($bannerImage, 'https://')) {
        // Keep absolute URLs as is
    } elseif (str_starts_with($bannerImage, 'images/') || str_starts_with($bannerImage, 'assets/') || str_starts_with($bannerImage, 'storage/')) {
        $bannerImage = asset($bannerImage);
    } else {
        $bannerImage = asset('storage/' . $bannerImage);
    }
    
    // Resolve date string
    if ($exhibition->start_date && $exhibition->end_date) {
        $dateStr = $exhibition->start_date->format('M d') . ' – ' . $exhibition->end_date->format('d, Y');
    } else {
        $dateStr = 'Date TBD';
    }
    
    // Resolve location
    $location = $exhibition->venue ?: ($exhibition->location ?: 'Virtual');
    $firstAgendaSession = $agenda->first();
    $timeStr = $firstAgendaSession?->start_time
        ? trim($firstAgendaSession->start_time . ($firstAgendaSession->end_time ? ' - ' . $firstAgendaSession->end_time : ''))
        : 'Time TBD';
    
    // Resolve dynamic stats from the live exhibition flow.
    $participatingCompanies = $publishedBookings
        ->map(function ($booking) {
            $companyName = $booking->boothProfile?->company_name ?: ($booking->company?->company_name ?: ($booking->company?->name ?: null));

            if (! filled($companyName)) {
                return null;
            }

            $logo = $booking->boothProfile?->company_logo ?: ($booking->company?->logo ?: '');
            $logoUrl = $logo ? (str_starts_with($logo, 'http') ? $logo : (str_starts_with($logo, 'storage/') ? asset($logo) : asset('storage/' . $logo))) : null;
            $companySlug = \Illuminate\Support\Str::slug($companyName);

            return [
                'key' => 'name-' . (string) \Illuminate\Support\Str::of($companyName)->lower()->squish(),
                'name' => $companyName,
                'logo_url' => $logoUrl,
                'slug' => $companySlug,
            ];
        })
        ->filter()
        ->unique('key')
        ->values();
    $companiesCount = $participatingCompanies->count();
    $countriesCount = $publishedBookings
        ->map(fn($booking) => $booking->company?->country)
        ->filter()
        ->unique()
        ->count();
    $eventSpeakerCards = $speakers->map(fn ($speaker) => (object) [
        'name' => $speaker->name,
        'title' => $speaker->title,
        'company' => $speaker->company,
        'bio' => $speaker->bio,
        'avatar_url' => $speaker->avatar_url,
    ]);
    $boothSpeakerCards = $publishedBookings->flatMap(function ($booking) {
        $companyName = $booking->boothProfile?->company_name ?: ($booking->company?->company_name ?: ($booking->company?->name ?: null));

        return ($booking->boothTeamMembers ?? collect())
            ->where('status', 'active')
            ->map(function ($member) use ($companyName) {
                $photo = $member->photo ? ltrim($member->photo, '/') : null;

                return (object) [
                    'name' => $member->name,
                    'title' => $member->designation,
                    'company' => $companyName,
                    'bio' => collect($member->expertise_tags ?? [])->filter()->implode(', '),
                    'avatar_url' => $photo ? (str_starts_with($photo, 'http') ? $photo : (str_starts_with($photo, 'storage/') ? asset($photo) : asset('storage/' . $photo))) : null,
                ];
            });
    });
    $speakerCards = $eventSpeakerCards
        ->concat($boothSpeakerCards)
        ->filter(fn ($speaker) => filled($speaker->name))
        ->unique(fn ($speaker) => strtolower(trim($speaker->name)))
        ->values();
    $boothSessionsCount = $publishedBookings
        ->flatMap(fn ($booking) => $booking->boothSessions ?? collect())
        ->whereIn('status', ['live', 'upcoming', 'completed'])
        ->count();
    
    $displayCompanies = $companiesCount;
    $displayCountries = $countriesCount > 0 ? $countriesCount : ($companiesCount > 0 ? 1 : 0);
    $displaySpeakers = $speakerCards->count();
    $displaySessions = $agenda->count() + $boothSessionsCount;

    // Determine tags dynamically based on title
    $tags = ['Expo', 'Interactive'];
    $lowerTitle = strtolower($title);
    if (str_contains($lowerTitle, 'tech') || str_contains($lowerTitle, 'digital')) {
        $tags = ['Technology', 'Innovation', 'AI & ML', 'Cloud'];
    } elseif (str_contains($lowerTitle, 'ai') || str_contains($lowerTitle, 'artificial')) {
        $tags = ['AI & ML', 'Neural Networks', 'Future Tech', 'Robotics'];
    } elseif (str_contains($lowerTitle, 'sustain') || str_contains($lowerTitle, 'green') || str_contains($lowerTitle, 'eco')) {
        $tags = ['Sustainability', 'Green Energy', 'Eco Friendly', 'Climate'];
    } elseif (str_contains($lowerTitle, 'health') || str_contains($lowerTitle, 'medical')) {
        $tags = ['Healthcare', 'Medicine', 'Wellness', 'Biotech'];
    }

    $expectations = [
        ['ph-star', 'Explore ' . $title],
        ['ph-users', $displayCompanies . ' participating ' . \Illuminate\Support\Str::plural('company', $displayCompanies)],
        ['ph-user-circle', $displaySpeakers . ' keynote ' . \Illuminate\Support\Str::plural('speaker', $displaySpeakers)],
        ['ph-presentation-chart', $displaySessions . ' agenda ' . \Illuminate\Support\Str::plural('session', $displaySessions)],
        ['ph-certificate', 'One-to-one meetings and visitor pass access'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Exhibition Details - EproExpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 500: '#5A32FA', 600: '#4A22E0' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FFFFFF; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">



    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-40 w-full relative">
            @include('frontend.exhibitions.tickets.header')
        </div>        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-4 sm:px-8 md:px-12 py-8 relative bg-[#F8FAFC]">
            
            <!-- Back button -->
            <a href="{{ url('/exhibitions') }}" class="inline-flex items-center gap-1.5 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-sm">
                <i class="ph ph-arrow-left text-base"></i> Back to Exhibitions
            </a>

            <!-- Header Section (Hero Card Banner) -->
            <div class="relative bg-gradient-to-r from-[#EEF2FF] via-[#F4F2FF] to-[#FAF5FF] rounded-3xl p-6 md:p-8 lg:p-10 shadow-sm border border-indigo-100/40 mb-8 overflow-hidden">
                <!-- Dotted pattern decorations -->
                <div class="absolute top-6 left-6 text-indigo-300/30 opacity-60">
                    <svg width="40" height="60" fill="currentColor">
                        <pattern id="dot-pattern-1" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5"></circle>
                        </pattern>
                        <rect width="40" height="60" fill="url(#dot-pattern-1)"></rect>
                    </svg>
                </div>
                <div class="absolute bottom-6 right-6 text-indigo-300/30 opacity-60">
                    <svg width="40" height="60" fill="currentColor">
                        <pattern id="dot-pattern-2" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5"></circle>
                        </pattern>
                        <rect width="40" height="60" fill="url(#dot-pattern-2)"></rect>
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col lg:flex-row gap-8 lg:items-center justify-between">
                    <div class="flex-1 flex flex-col">
                        <!-- Pill Badges -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($tags as $tag)
                                <span class="bg-indigo-50 border border-indigo-150/60 text-indigo-700 rounded-full px-3.5 py-1 text-[11px] font-bold tracking-wide uppercase shadow-sm">{{ $tag }}</span>
                            @endforeach
                        </div>

                        <!-- Heading -->
                        <h1 id="exh-name" class="text-3xl md:text-4xl lg:text-[40px] font-extrabold text-[#1E1B4B] tracking-tight leading-tight mb-4">{{ $title }}</h1>

                        <!-- Date & Location Meta Row -->
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-[#475569] text-sm font-medium mb-4">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar-blank text-[18px] text-indigo-600"></i>
                                <span id="exh-dates">{{ $dateStr }}</span>
                            </div>
                            <span class="hidden md:inline w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-clock text-[18px] text-indigo-600"></i>
                                <span>{{ $timeStr }}</span>
                            </div>
                            <span class="hidden md:inline w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-map-pin text-[18px] text-indigo-600"></i>
                                <span id="exh-venue">{{ $location }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p id="exh-description" class="text-[#64748B] text-[15px] font-medium leading-relaxed max-w-[550px] mb-6">
                            {{ $exhibition->description ?: 'Explore the latest technologies, interact with global business leaders, and discover innovative solutions. Enter virtual lobbies, book corporate meetings, download brochures, and attend live product demos.' }}
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap gap-4">
                            <a id="get-pass-btn-hero" href="{{ $ticketUrl }}" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-[0_4px_14px_rgba(74,34,224,0.25)] transition-all text-sm">
                                <i class="ph ph-ticket text-[18px]"></i> Get Visitor Pass
                            </a>
                            <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="bg-white border-2 border-[#E0D7FF] text-[#4A22E0] px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:bg-[#F5F3FF] transition-colors text-sm shadow-sm">
                                <i class="ph ph-map-trifold text-[18px]"></i> View Floor Plan
                            </a>
                        </div>
                    </div>

                    <!-- Right Column (Large Banner Image) -->
                    <div class="lg:w-[460px] xl:w-[520px] shrink-0">
                        <img src="{{ $bannerImage }}" alt="{{ $title }}" class="w-full h-[220px] md:h-[280px] rounded-3xl object-cover shadow-[0_15px_30px_rgba(74,34,224,0.1)] border-4 border-white">
                    </div>
                </div>
            </div>

            <!-- Stats Row (4 Individual Cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Companies Card -->
                <div class="bg-white rounded-[20px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.01)] border border-gray-100 flex items-center gap-4 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-buildings text-[24px]"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-[#1E1B4B] flex items-center leading-none">
                            <span id="exh-companies-count">{{ $displayCompanies }}</span>
                            <span class="w-1.5 h-1.5 bg-orange-400 rounded-full ml-1 self-start"></span>
                        </div>
                        <div class="text-[13px] text-gray-400 font-bold tracking-wide mt-1.5">Companies</div>
                    </div>
                    <!-- Corner wavy decoration -->
                    <div class="absolute bottom-0 right-0 w-12 h-12 bg-gradient-to-br from-transparent to-indigo-50/30 rounded-tl-full pointer-events-none"></div>
                </div>

                <!-- Countries Card -->
                <div class="bg-white rounded-[20px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.01)] border border-gray-100 flex items-center gap-4 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-globe text-[24px]"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-[#1E1B4B] flex items-center leading-none">
                            <span>{{ $displayCountries }}+</span>
                            <span class="w-1.5 h-1.5 bg-orange-400 rounded-full ml-1 self-start"></span>
                        </div>
                        <div class="text-[13px] text-gray-400 font-bold tracking-wide mt-1.5">Countries</div>
                    </div>
                    <!-- Corner wavy decoration -->
                    <div class="absolute bottom-0 right-0 w-12 h-12 bg-gradient-to-br from-transparent to-blue-50/30 rounded-tl-full pointer-events-none"></div>
                </div>

                <!-- Speakers Card -->
                <div class="bg-white rounded-[20px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.01)] border border-gray-100 flex items-center gap-4 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-users text-[24px]"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-[#1E1B4B] flex items-center leading-none">
                            <span>{{ $displaySpeakers }}</span>
                            <span class="w-1.5 h-1.5 bg-orange-400 rounded-full ml-1 self-start"></span>
                        </div>
                        <div class="text-[13px] text-gray-400 font-bold tracking-wide mt-1.5">Speakers</div>
                    </div>
                    <!-- Corner wavy decoration -->
                    <div class="absolute bottom-0 right-0 w-12 h-12 bg-gradient-to-br from-transparent to-emerald-50/30 rounded-tl-full pointer-events-none"></div>
                </div>

                <!-- Sessions Card -->
                <div class="bg-white rounded-[20px] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.01)] border border-gray-100 flex items-center gap-4 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-calendar text-[24px]"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-[#1E1B4B] flex items-center leading-none">
                            <span>{{ $displaySessions }}+</span>
                            <span class="w-1.5 h-1.5 bg-orange-400 rounded-full ml-1 self-start"></span>
                        </div>
                        <div class="text-[13px] text-gray-400 font-bold tracking-wide mt-1.5">Sessions</div>
                    </div>
                    <!-- Corner wavy decoration -->
                    <div class="absolute bottom-0 right-0 w-12 h-12 bg-gradient-to-br from-transparent to-orange-50/30 rounded-tl-full pointer-events-none"></div>
                </div>
            </div>

            <!-- Tabs (Horizontal scrollable strip with prefix icons) -->
            <div class="bg-white border border-gray-150 rounded-2xl shadow-[0_4px_15px_rgba(0,0,0,0.01)] p-1.5 mb-8 flex items-center gap-2 overflow-x-auto no-scrollbar select-none">
                <button id="tab-overview" data-tab="overview" onclick="switchTab('overview', this)" class="tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none bg-[#F5F3FF] text-[#4A22E0]">
                    <i class="ph ph-layout text-lg"></i> Overview
                </button>
                <button id="tab-agenda" data-tab="agenda" onclick="switchTab('agenda', this)" class="tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none text-gray-500 hover:text-gray-950 hover:bg-gray-50">
                    <i class="ph ph-calendar-blank text-lg"></i> Agenda
                </button>
                <button id="tab-speakers" data-tab="speakers" onclick="switchTab('speakers', this)" class="tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none text-gray-500 hover:text-gray-950 hover:bg-gray-50">
                    <i class="ph ph-users text-lg"></i> Speakers
                </button>
                <button id="tab-sponsors" data-tab="sponsors" onclick="switchTab('sponsors', this)" class="tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none text-gray-500 hover:text-gray-950 hover:bg-gray-50">
                    <i class="ph ph-shield-star text-lg"></i> Sponsors
                </button>
                <button id="tab-floorplan" data-tab="floorplan" onclick="switchTab('floorplan', this)" class="tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none text-gray-500 hover:text-gray-950 hover:bg-gray-50">
                    <i class="ph ph-map-trifold text-lg"></i> Floor Plan
                </button>
                <button id="tab-faqs" data-tab="faqs" onclick="switchTab('faqs', this)" class="tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none text-gray-500 hover:text-gray-950 hover:bg-gray-50">
                    <i class="ph ph-question text-lg"></i> FAQs
                </button>
            </div>

            <!-- Tab Panels -->
            <div id="tab-panels-container">
                
                <!-- Overview Panel -->
                <div id="panel-overview" class="tab-panel grid grid-cols-1 lg:grid-cols-[1.1fr_1.1fr_0.8fr] gap-6 pb-10">
                    <!-- Left: What to Expect -->
                    <div class="border border-gray-100 rounded-3xl p-8 shadow-[0_4px_25px_rgba(0,0,0,0.02)] bg-white flex flex-col relative overflow-hidden">
                        <!-- Decorative dome outline sketch watermark -->
                        <div class="absolute bottom-12 right-0 w-48 h-32 pointer-events-none select-none">
                            <svg class="w-full h-full" viewBox="0 0 100 60" fill="none" stroke="#4A22E0" stroke-opacity="0.04" stroke-width="0.75">
                                <ellipse cx="50" cy="45" rx="42" ry="12" />
                                <ellipse cx="50" cy="40" rx="38" ry="10" />
                                <ellipse cx="50" cy="35" rx="32" ry="8" />
                                <path d="M12 43 L12 55 M20 38 L20 53 M30 33 L30 50 M40 31 L40 48 M50 30 L50 48 M60 31 L60 48 M70 33 L70 50 M80 38 L80 53 M88 43 L88 55" />
                                <line x1="2" y1="55" x2="98" y2="55" />
                            </svg>
                        </div>

                        <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-8">What to Expect</h2>
                        
                        <div class="space-y-6 mb-8 flex-1 relative z-10">
                            @foreach ($expectations as [$icon, $label])
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-[#EEF2FF] border border-[#E0D7FF] flex items-center justify-center text-[#4A22E0] flex-shrink-0">
                                        <i class="ph {{ $icon }} text-[20px]"></i>
                                    </div>
                                    <span class="text-[14px] text-gray-600 font-semibold">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <a id="get-pass-btn" href="{{ $ticketUrl }}" class="w-full inline-block text-center bg-[#4A22E0] hover:bg-[#3D1CBA] text-white py-4 rounded-xl font-bold shadow-[0_4px_14px_rgba(74,34,224,0.25)] transition-all text-[15px] flex items-center justify-center gap-2 relative z-10">
                            <i class="ph ph-ticket text-lg"></i> Get Visitor Pass
                        </a>
                    </div>

                    <!-- Middle: Participating Companies -->
                    <div class="border border-gray-100 rounded-3xl p-8 shadow-[0_4px_25px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                        <div class="flex items-center gap-2 mb-8 text-[#1E1B4B]">
                            <i class="ph ph-buildings text-[22px] text-indigo-600"></i>
                            <h2 class="text-[20px] font-bold">Participating Companies</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse ($participatingCompanies->take(6) as $company)
                                <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.01)] hover:border-indigo-100 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center gap-4">
                                        <!-- Logo container -->
                                        <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-xl overflow-hidden flex items-center justify-center p-2 flex-shrink-0">
                                            @if($company['logo_url'])
                                                <img src="{{ $company['logo_url'] }}" alt="{{ $company['name'] }}" class="max-w-full max-h-full object-contain">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-700 font-bold text-xs uppercase rounded">
                                                    {{ substr($company['name'], 0, 2) }}
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Details -->
                                        <div>
                                            <h4 class="font-bold text-[#1E1B4B] text-[15px]">{{ $company['name'] }}</h4>
                                            <p class="text-xs text-gray-400 mt-0.5 font-medium">Exhibition • {{ $exhibition->venue ?: ($exhibition->location ?: 'India') }}</p>
                                        </div>
                                    </div>
                                    <!-- Action -->
                                    <a href="{{ route('exhibitions.visitor.companies.show', ['slug' => $slug, 'companySlug' => $company['slug']]) }}" class="text-xs font-bold text-[#4A22E0] bg-white border border-[#E0D7FF] px-4 py-2.5 rounded-lg hover:bg-[#F5F3FF] transition-colors whitespace-nowrap">
                                        View Company
                                    </a>
                                </div>
                            @empty
                                <div class="py-12 text-center text-[14px] font-semibold text-[#7A819A]">No exhibitors registered yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Right: Sidebar widgets -->
                    <div class="flex flex-col gap-6">
                        <!-- Event Information Card -->
                        <div class="border border-gray-100 rounded-3xl p-6 shadow-[0_4px_25px_rgba(0,0,0,0.02)] bg-white">
                            <div class="flex items-center gap-2 mb-6 text-[#1E1B4B]">
                                <i class="ph ph-calendar-blank text-[20px] text-indigo-600"></i>
                                <h3 class="font-bold text-[16px]">Event Information</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-start text-xs font-semibold">
                                    <span class="text-gray-400">Date</span>
                                    <span class="text-[#1E1B4B] text-right">{{ $dateStr }}</span>
                                </div>
                                <div class="flex justify-between items-start text-xs font-semibold">
                                    <span class="text-gray-400">Time</span>
                                    <span class="text-[#1E1B4B] text-right">{{ $timeStr }}</span>
                                </div>
                                <div class="flex justify-between items-start text-xs font-semibold">
                                    <span class="text-gray-400">Venue</span>
                                    <span class="text-[#1E1B4B] text-right">{{ $location }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs font-semibold">
                                    <span class="text-gray-400">Event Type</span>
                                    <span class="bg-indigo-50 border border-indigo-150 text-indigo-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">Interactive Expo</span>
                                </div>
                            </div>
                        </div>

                        <!-- Organizer Card -->
                        <div class="border border-gray-100 rounded-3xl p-6 shadow-[0_4px_25px_rgba(0,0,0,0.02)] bg-white">
                            <div class="flex items-center gap-2 mb-6 text-[#1E1B4B]">
                                <i class="ph ph-user text-[20px] text-indigo-600"></i>
                                <h3 class="font-bold text-[16px]">Organizer</h3>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#EEF2FF] rounded-2xl flex items-center justify-center text-[#4A22E0] font-bold text-lg flex-shrink-0">
                                    @if($exhibition->organizer_logo)
                                        <img src="{{ str_starts_with($exhibition->organizer_logo, 'http') ? $exhibition->organizer_logo : asset('storage/' . $exhibition->organizer_logo) }}" alt="Organizer" class="w-full h-full object-contain rounded-2xl">
                                    @else
                                        <i class="ph ph-user text-[22px]"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#1E1B4B] text-sm">{{ $exhibition->organizer_name ?: $title }}</h4>
                                    <p class="text-xs text-gray-400 font-medium mt-0.5">Exhibition Organizer</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Card -->
                        <div class="border border-gray-100 rounded-3xl p-6 shadow-[0_4px_25px_rgba(0,0,0,0.02)] bg-white">
                            <div class="flex items-center gap-2 mb-6 text-[#1E1B4B]">
                                <i class="ph ph-lightning text-[20px] text-indigo-600"></i>
                                <h3 class="font-bold text-[16px]">Quick Actions</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="bg-white border border-[#E0D7FF] text-[#4A22E0] py-2.5 rounded-xl font-bold flex items-center justify-center gap-1.5 hover:bg-[#F5F3FF] transition-colors text-xs text-center">
                                    <i class="ph ph-map-trifold text-base"></i> View Floor Plan
                                </a>
                                <button onclick="shareExhibition()" class="bg-white border border-[#E0D7FF] text-[#4A22E0] py-2.5 rounded-xl font-bold flex items-center justify-center gap-1.5 hover:bg-[#F5F3FF] transition-colors text-xs text-center">
                                    <i class="ph ph-share-network text-base"></i> Share Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agenda Panel -->
                <div id="panel-agenda" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Conference Agenda / Schedule</h2>
                    <div class="space-y-6">
                        @forelse ($agenda as $session)
                            <div class="flex gap-6 items-start pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                <div class="w-[120px] shrink-0">
                                    <div class="text-indigo-600 font-bold text-[14px] mb-0.5">{{ $session->start_time }}</div>
                                    <div class="text-gray-400 font-semibold text-[11px] uppercase">{{ $session->end_time ?: 'Session' }}</div>
                                    @if($session->date)
                                        <div class="text-[10px] text-gray-400 font-semibold mt-1">{{ $session->date }}</div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1.5">{{ $session->title }}</h3>
                                    <p class="text-gray-500 text-[13px] leading-relaxed mb-3">{{ $session->description }}</p>
                                    <div class="flex flex-wrap gap-4 text-[12px] font-semibold text-gray-600">
                                        @if($session->speaker_name)
                                            <div class="flex items-center gap-1.5"><i class="ph ph-user text-indigo-500 text-[16px]"></i> {{ $session->speaker_name }}</div>
                                        @endif
                                        @if($session->hall_name)
                                            <div class="flex items-center gap-1.5"><i class="ph ph-map-pin text-indigo-500 text-[16px]"></i> {{ $session->hall_name }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-400 text-sm py-6">No agenda sessions listed for this event.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Speakers Panel -->
                <div id="panel-speakers" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Keynote Speakers</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($speakerCards as $sp)
                            <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-center text-center hover:border-indigo-100 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                @if($sp->avatar_url)
                                    <img src="{{ $sp->avatar_url }}" alt="{{ $sp->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-50 mb-4">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold mb-4 text-xl">
                                        {{ substr($sp->name, 0, 1) }}
                                    </div>
                                @endif
                                <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">{{ $sp->name }}</h4>
                                <div class="text-indigo-600 font-bold text-[11px] mb-3">{{ $sp->title }} @if($sp->company) • {{ $sp->company }} @endif</div>
                                <p class="text-[12px] text-gray-500 leading-relaxed font-medium line-clamp-3">{{ $sp->bio }}</p>
                            </div>
                        @empty
                            <div class="col-span-full text-gray-400 text-sm py-6 text-center">No keynote speakers listed.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Sponsors Panel -->
                <div id="panel-sponsors" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-8 text-center">Event Sponsors & Partners</h2>
                    
                    <div class="space-y-12">
                        @php
                            $platinumSponsors = $sponsors->where('level', 'Platinum');
                            $goldSponsors = $sponsors->where('level', 'Gold');
                            $silverSponsors = $sponsors->where('level', 'Silver');
                        @endphp

                        <!-- Platinum Sponsors -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="bg-indigo-50 border border-indigo-150 text-indigo-700 font-bold px-3 py-1 rounded text-[11px] uppercase tracking-wider">Platinum Sponsors</span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                @forelse ($platinumSponsors as $sp)
                                    <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(0,0,0,0.02)] h-[90px] hover:border-indigo-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                        @if($sp->logo_url)
                                            <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="h-7 max-w-full object-contain mb-1">
                                        @endif
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide">{{ $sp->name }}</span>
                                    </div>
                                @empty
                                    <div class="text-[12px] text-gray-400 col-span-full text-center">No Platinum Sponsors.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Gold Sponsors -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="bg-yellow-50 border border-yellow-150 text-yellow-700 font-bold px-3 py-1 rounded text-[11px] uppercase tracking-wider">Gold Sponsors</span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                @forelse ($goldSponsors as $sp)
                                    <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(0,0,0,0.02)] h-[90px] hover:border-indigo-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                        @if($sp->logo_url)
                                            <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="h-7 max-w-full object-contain mb-1">
                                        @endif
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide">{{ $sp->name }}</span>
                                    </div>
                                @empty
                                    <div class="text-[12px] text-gray-400 col-span-full text-center">No Gold Sponsors.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Silver Sponsors -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="bg-gray-50 border border-gray-150 text-gray-600 font-bold px-3 py-1 rounded text-[11px] uppercase tracking-wider">Silver Sponsors</span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                @forelse ($silverSponsors as $sp)
                                    <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(0,0,0,0.02)] h-[90px] hover:border-indigo-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                        @if($sp->logo_url)
                                            <img src="{{ $sp->logo_url }}" alt="{{ $sp->name }}" class="h-7 max-w-full object-contain mb-1">
                                        @endif
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide">{{ $sp->name }}</span>
                                    </div>
                                @empty
                                    <div class="text-[12px] text-gray-400 col-span-full text-center">No Silver Sponsors.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floor Plan Panel -->
                <div id="panel-floorplan" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-[18px] font-bold text-[#1E1B4B]">Exhibition Halls Floor Plan</h2>
                        <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                            <i class="ph ph-map-trifold text-[18px]"></i> Full Floor Map
                        </a>
                    </div>
                    <p class="text-[13px] text-gray-500 mb-8 leading-relaxed">Select any hall below to explore interactive booths, find registered exhibitors, or book B2B meeting slots.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @forelse ($halls as $hall)
                            @php
                                $hallLogo = $hall->image ? (str_starts_with($hall->image, 'http') ? $hall->image : (str_starts_with($hall->image, 'storage/') ? asset($hall->image) : asset('storage/' . $hall->image))) : asset('images/exhibitions/hall-fallback.jpg');
                                $badge = $hall->pavilion?->title ?: 'Hall';
                                $exhibitorsCount = $hall->boothBookings()->where('payment_status', 'paid')->whereIn('booking_status', ['confirmed', 'active'])->where('admin_status', 'approved')->count();
                            @endphp
                            <div onclick="window.location.href='{{ route('exhibitions.visitor.floor-map', [$slug, 'hall' => $hall->id]) }}'" class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="h-28 relative">
                                    <img src="{{ $hallLogo }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=400&q=80'">
                                    <div class="absolute top-2 left-2 bg-[#4A22E0] text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">{{ $badge }}</div>
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 truncate">{{ $hall->title }}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium line-clamp-2 leading-relaxed mb-3 flex-1">{{ $hall->description }}</p>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-indigo-700">
                                        <span>{{ $exhibitorsCount }} Exhibitors</span>
                                        <i class="ph ph-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-gray-400 text-sm py-6 text-center">No halls active in this exhibition.</div>
                        @endforelse
                    </div>
                </div>

                <!-- FAQs Panel -->
                <div id="panel-faqs" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Frequently Asked Questions</h2>
                    <div class="space-y-4">
                        @forelse ($faqs as $idx => $faq)
                            <div class="border border-gray-150 rounded-xl overflow-hidden bg-[#FAFAFC]">
                                <button onclick="toggleFaqAccordion({{ $idx }})" class="w-full flex items-center justify-between p-4 text-left font-bold text-[#1E1B4B] text-[13px] hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <i class="ph {{ $faq->icon ?: 'ph-question' }} text-[18px] text-indigo-600"></i>
                                        <span>{{ $faq->question }}</span>
                                    </div>
                                    <i id="faq-chevron-{{ $idx }}" class="ph ph-caret-down text-[16px] text-gray-400 transition-transform"></i>
                                </button>
                                <div id="faq-answer-{{ $idx }}" class="hidden p-4 pt-0 border-t border-gray-150 text-[12px] text-gray-600 leading-relaxed bg-white">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-400 text-sm py-6 text-center">No FAQs available.</div>
                        @endforelse
                    </div>
                </div>

            </div>
            
        </div>
    </main>

    <script>
        // Switch tabs dynamically
        function switchTab(tabId, el, updateHash = true) {
            // Hide all tab panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            
            // Show target tab panel
            const targetPanel = document.getElementById(`panel-${tabId}`);
            if (targetPanel) targetPanel.classList.remove('hidden');

            // Reset active tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none text-gray-500 hover:text-gray-950 hover:bg-gray-50';
            });

            // Set current tab button active styles
            el.className = 'tab-btn shrink-0 flex items-center gap-2 px-5 py-3 rounded-xl text-[14px] font-bold transition-all focus:outline-none bg-[#F5F3FF] text-[#4A22E0]';

            if (updateHash) {
                window.location.hash = `tab-${tabId}`;
            }
        }

        function openTabFromHash() {
            const hash = window.location.hash.replace('#', '');
            if (!hash.startsWith('tab-')) {
                return;
            }

            const tabId = hash.replace('tab-', '');
            const tabButton = document.getElementById(`tab-${tabId}`);

            if (tabButton) {
                switchTab(tabId, tabButton, false);
            }
        }

        // FAQ accordion toggle helper
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
                    title: '{{ $title }}',
                    url: window.location.href
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Event link copied to clipboard!');
            }
        }

        document.addEventListener('DOMContentLoaded', openTabFromHash);
        window.addEventListener('hashchange', openTabFromHash);
    </script>
</body>
</html>
