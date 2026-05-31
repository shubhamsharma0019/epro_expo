@extends('layouts.frontend')

@section('title', ($exhibition->title ?? $exhibition->name) . ' - Exhibition Details - EproExpo')

@section('content')
@php
    $title = $exhibition->title ?: $exhibition->name;
    $ticketUrl = route('exhibitions.tickets.select', $slug);
    
    // Resolve banner image (prioritize booth setup banner or logo)
    $publishedBookings = ($exhibition->boothBookings ?? collect())->filter(fn ($booking) => 
        in_array($booking->booth_setup_status, ['published', 'approved', 'live'])
    );
    $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
        ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);
        
    $bannerImage = $exhibition->banner_url ?: ($exhibition->banner_image ?: 'images/exhibitions/hero-pavilion-scene.png');
    if ($firstBooking) {
        if ($firstBooking->boothBranding?->booth_banner) {
            $bannerPath = $firstBooking->boothBranding->booth_banner;
            $bannerImage = str_starts_with($bannerPath, 'storage/') ? $bannerPath : 'storage/' . $bannerPath;
        } elseif ($firstBooking->boothProfile?->company_logo) {
            $logoPath = $firstBooking->boothProfile->company_logo;
            $bannerImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
        } elseif ($firstBooking->company?->logo) {
            $logoPath = $firstBooking->company->logo;
            $bannerImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
        }
    }

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
        $dateStr = 'June 12 - 14, 2026';
    }
    
    // Resolve location
    $location = $exhibition->venue ?: ($exhibition->location ?: 'Virtual');
    
    // Filter booth bookings to only show published, approved, or live setups
    $publishedBookings = $exhibition->boothBookings->filter(fn ($booking) => 
        in_array($booking->booth_setup_status, ['published', 'approved', 'live'])
    );
    
    // Resolve dynamic stats based on published/live booths
    $boothsCount = $publishedBookings->count();
    $countriesCount = $publishedBookings->map(fn($b) => $b->company?->country)->filter()->unique()->count();
    
    // Fallback counts using database records
    $displayBooths = $boothsCount > 0 ? $boothsCount : 120;
    $displayCountries = $countriesCount > 0 ? $countriesCount : 8;
    $displaySpeakers = $speakers->count() > 0 ? $speakers->count() : 14;
    $displaySessions = $agenda->count() > 0 ? $agenda->count() : 50;

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
@endphp

<div class="px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE] min-h-screen">
    <div class="mx-auto max-w-[1440px]">
        
        <!-- Back button -->
        <a href="{{ url('/exhibitions') }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
            <i class="ph ph-arrow-left text-lg"></i> Back to Exhibitions
        </a>

        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-6">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Image -->
                <div class="w-[150px] h-[150px] rounded-2xl bg-cover bg-center border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.05)]" style="background-image: url('{{ $bannerImage }}');"></div>
                
                <!-- Info -->
                <div class="flex flex-col justify-center">
                    <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-3">{{ $title }}</h1>
                    
                    <div class="flex items-center gap-5 text-[#475569] text-[14px] font-medium mb-3">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-calendar-blank text-[18px]"></i>
                            <span>{{ $dateStr }}</span>
                        </div>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <div class="flex items-center gap-2">
                            <i class="ph ph-clock text-[18px]"></i>
                            <span>09:00 AM – 06:00 PM (IST)</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 text-[#475569] text-[14px] font-medium mb-5">
                        <i class="ph ph-map-pin text-[18px]"></i>
                        <span>{{ $location }}</span>
                    </div>
                    
                    <div class="flex gap-3">
                        @foreach ($tags as $tag)
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button class="flex items-center gap-2 border border-gray-200 bg-white text-indigo-600 hover:bg-gray-50 rounded-xl px-5 py-2.5 font-bold text-[14px] transition-colors shadow-sm">
                    <i class="ph ph-share-network text-[20px] font-bold"></i> Share
                </button>
                <button class="flex items-center justify-center border border-gray-200 bg-white text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 rounded-xl w-[44px] h-[44px] transition-all duration-300 shadow-sm hover:-translate-y-1 hover:shadow-md">
                    <i class="ph ph-heart text-[22px]"></i>
                </button>
            </div>
        </div>

        <!-- Description -->
        <p class="text-[#64748B] text-[15px] font-medium leading-relaxed max-w-[850px] mb-8">
            {{ $exhibition->description ?: 'Explore the latest technologies, interact with global business leaders, and discover innovative solutions. Enter virtual lobbies, book corporate meetings, download brochures, and attend live product demos.' }}
        </p>

        <!-- Stats Row -->
        <div class="border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 flex items-center justify-around bg-white max-w-full">
            <div class="text-center flex-1">
                <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                    <span>{{ $displayBooths }}</span>
                    <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                </div>
                <div class="text-[14px] text-[#64748B] font-bold">Companies</div>
            </div>
            <div class="w-px h-12 bg-gray-100"></div>
            <div class="text-center flex-1">
                <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                    <span>{{ $displayCountries }}+</span>
                    <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                </div>
                <div class="text-[14px] text-[#64748B] font-bold">Countries</div>
            </div>
            <div class="w-px h-12 bg-gray-100"></div>
            <div class="text-center flex-1">
                <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                    <span>{{ $displaySpeakers }}</span>
                    <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                </div>
                <div class="text-[14px] text-[#64748B] font-bold">Speakers</div>
            </div>
            <div class="w-px h-12 bg-gray-100"></div>
            <div class="text-center flex-1">
                <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                    <span>{{ $displaySessions }}+</span>
                    <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                </div>
                <div class="text-[14px] text-[#64748B] font-bold">Sessions</div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-8 flex gap-8 border-b border-gray-200">
            <button onclick="switchTab('about')" id="btn-tab-about" class="tab-btn -mb-px border-b-2 border-indigo-600 pb-4 text-[15px] font-bold text-indigo-600 transition-colors">
                About
            </button>
            <button onclick="switchTab('speakers')" id="btn-tab-speakers" class="tab-btn -mb-px border-b-2 border-transparent pb-4 text-[15px] font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                Speakers ({{ $speakers->count() > 0 ? $speakers->count() : 4 }})
            </button>
            <button onclick="switchTab('sponsors')" id="btn-tab-sponsors" class="tab-btn -mb-px border-b-2 border-transparent pb-4 text-[15px] font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                Sponsors ({{ $sponsors->count() > 0 ? $sponsors->count() : 9 }})
            </button>
            <button onclick="switchTab('agenda')" id="btn-tab-agenda" class="tab-btn -mb-px border-b-2 border-transparent pb-4 text-[15px] font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                Agenda / Sessions ({{ $agenda->count() > 0 ? $agenda->count() : 4 }})
            </button>
        </div>

        <!-- About Tab Content -->
        <div id="tab-content-about" class="tab-content grid grid-cols-1 lg:grid-cols-[1fr_1.3fr] gap-6 pb-10">
            <!-- Left: What to Expect -->
            <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-7">What to Expect</h2>
                
                <div class="space-y-6 mb-8 flex-1">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-[#4A22E0] flex-shrink-0">
                            <i class="ph ph-star text-[20px]"></i>
                        </div>
                        <span class="text-[14px] text-[#475569] font-semibold">Explore innovative solutions</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-[#4A22E0] flex-shrink-0">
                            <i class="ph ph-users text-[20px]"></i>
                        </div>
                        <span class="text-[14px] text-[#475569] font-semibold">Live product demos</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-[#4A22E0] flex-shrink-0">
                            <i class="ph ph-user-circle text-[20px]"></i>
                        </div>
                        <span class="text-[14px] text-[#475569] font-semibold">Network with industry leaders</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-[#4A22E0] flex-shrink-0">
                            <i class="ph ph-presentation-chart text-[20px]"></i>
                        </div>
                        <span class="text-[14px] text-[#475569] font-semibold">Panel discussions & keynotes</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-[#4A22E0] flex-shrink-0">
                            <i class="ph ph-certificate text-[20px]"></i>
                        </div>
                        <span class="text-[14px] text-[#475569] font-semibold">One-to-one meetings</span>
                    </div>
                </div>
                
                <a id="get-pass-btn" href="{{ $ticketUrl }}" class="w-full inline-block text-center bg-[#4A22E0] hover:bg-[#3D1CBA] text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px]">
                    Get Visitor Pass
                </a>
            </div>

            <!-- Right: Participating Companies -->
            <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-7">Participating Companies</h2>
                
                <!-- Logos Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                    @forelse ($publishedBookings->take(9) as $booking)
                        @php
                            $logo = $booking->boothProfile?->company_logo ?: ($booking->company?->logo ?: '');
                            $logoUrl = $logo ? (str_starts_with($logo, 'http') ? $logo : (str_starts_with($logo, 'storage/') ? asset($logo) : asset('storage/' . $logo))) : null;
                            $companyName = $booking->boothProfile?->company_name ?: ($booking->company?->company_name ?: ($booking->company?->name ?: 'Exhibitor'));
                        @endphp
                        <div onclick="window.location.href='{{ route('exhibitions.visitor.companies.show', ['slug' => $slug, 'companySlug' => ($booking->boothProfile?->slug ?: $booking->company?->slug ?: $booking->company?->id)]) }}'" class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-pointer" title="{{ $companyName }}">
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $companyName }}" class="h-6 opacity-90 max-w-full object-contain">
                            @else
                                <span class="text-[11px] font-bold text-gray-500 text-center line-clamp-2 uppercase tracking-wide">{{ $companyName }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-[14px] font-semibold text-[#7A819A]">No exhibitors registered yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Speakers Tab Content -->
        <div id="tab-content-speakers" class="tab-content hidden pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($speakers as $speaker)
                    <div class="border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col items-center text-center">
                        @if($speaker->avatar_url)
                            <img src="{{ $speaker->avatar_url }}" alt="{{ $speaker->name }}" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-indigo-50 shadow-sm">
                        @else
                            <div class="w-24 h-24 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold mb-4">
                                {{ substr($speaker->name, 0, 1) }}
                            </div>
                        @endif
                        <h3 class="text-[17px] font-bold text-[#1E1B4B] mb-1">{{ $speaker->name }}</h3>
                        <p class="text-[13px] text-indigo-600 font-semibold mb-1">{{ $speaker->title }}</p>
                        <p class="text-[13px] text-gray-500 font-bold mb-4">{{ $speaker->company }}</p>
                        <p class="text-[13px] text-[#64748B] font-medium leading-relaxed line-clamp-3">{{ $speaker->bio }}</p>
                    </div>
                @empty
                    @foreach ([
                        ['Dr. Alan Stone', 'Director of AI Research', 'FutureLabs', 'https://randomuser.me/api/portraits/men/82.jpg', 'A pioneer in deep reinforcement learning and autonomous robotics. He has published 50+ research papers and leads the robotic intelligence team at FutureLabs.'],
                        ['Elena Rodriguez', 'Cloud Solutions Architect', 'CloudSphere Tech', 'https://randomuser.me/api/portraits/women/68.jpg', 'Elena specializes in microservices and zero-downtime migrations. She has assisted over 50 enterprise clients in automating infrastructure.'],
                        ['David Chen', 'VP of Sales & Engineering', 'DataMind Analytics', 'https://randomuser.me/api/portraits/men/62.jpg', 'David designs distributed storage engines capable of sub-millisecond query execution. He has over 15 years of database engineering experience.'],
                        ['Rahul Sharma', 'Lead Product Manager', 'TechNext Solutions', 'https://randomuser.me/api/portraits/men/32.jpg', 'Rahul oversees the development of RPA software and workflow cognitive managers designed to automate document ingestion and high-volume billing operations.']
                    ] as [$name, $title, $company, $avatar, $bio])
                        <div class="border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col items-center text-center">
                            <img src="{{ $avatar }}" alt="{{ $name }}" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-indigo-50 shadow-sm">
                            <h3 class="text-[17px] font-bold text-[#1E1B4B] mb-1">{{ $name }}</h3>
                            <p class="text-[13px] text-indigo-600 font-semibold mb-1">{{ $title }}</p>
                            <p class="text-[13px] text-gray-500 font-bold mb-4">{{ $company }}</p>
                            <p class="text-[13px] text-[#64748B] font-medium leading-relaxed line-clamp-3">{{ $bio }}</p>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>

        <!-- Sponsors Tab Content -->
        <div id="tab-content-sponsors" class="tab-content hidden pb-10">
            <div class="space-y-10">
                @php
                    $platinumSponsors = $sponsors->where('level', 'Platinum');
                    $goldSponsors = $sponsors->where('level', 'Gold');
                    $silverSponsors = $sponsors->where('level', 'Silver');
                @endphp

                <!-- Platinum Sponsors -->
                @if($platinumSponsors->count() > 0 || $sponsors->isEmpty())
                    <div>
                        <h3 class="text-[18px] font-bold text-[#1E1B4B] mb-5 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> Platinum Sponsors
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @forelse ($platinumSponsors as $sponsor)
                                <div class="bg-white border border-gray-100 rounded-[20px] h-[120px] flex items-center justify-center p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-gray-200 transition-all duration-300" title="{{ $sponsor->name }}">
                                    @if($sponsor->logo_url)
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="h-12 max-w-full object-contain">
                                    @else
                                        <span class="text-[14px] font-bold text-indigo-600 text-center line-clamp-2 uppercase tracking-wider px-4">{{ $sponsor->name }}</span>
                                    @endif
                                </div>
                            @empty
                                @foreach ([
                                    ['IBM', 'https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg'],
                                    ['Microsoft', 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg']
                                ] as [$name, $logo])
                                    <div class="bg-white border border-gray-100 rounded-[20px] h-[120px] flex items-center justify-center p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-gray-200 transition-all duration-300">
                                        <img src="{{ $logo }}" alt="{{ $name }}" class="h-12 max-w-full object-contain">
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Gold Sponsors -->
                @if($goldSponsors->count() > 0 || $sponsors->isEmpty())
                    <div>
                        <h3 class="text-[18px] font-bold text-[#1E1B4B] mb-5 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Gold Sponsors
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                            @forelse ($goldSponsors as $sponsor)
                                <div class="bg-white border border-gray-100 rounded-[20px] h-[100px] flex items-center justify-center p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-gray-200 transition-all duration-300" title="{{ $sponsor->name }}">
                                    @if($sponsor->logo_url)
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="h-10 max-w-full object-contain">
                                    @else
                                        <span class="text-[13px] font-bold text-yellow-600 text-center line-clamp-2 uppercase tracking-wider px-4">{{ $sponsor->name }}</span>
                                    @endif
                                </div>
                            @empty
                                @foreach ([
                                    ['Intel', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Intel_logo_%282020%29.svg'],
                                    ['Nvidia', 'https://upload.wikimedia.org/wikipedia/commons/2/21/Nvidia_logo.svg'],
                                    ['AWS', 'https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg'],
                                    ['Google', 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg']
                                ] as [$name, $logo])
                                    <div class="bg-white border border-gray-100 rounded-[20px] h-[100px] flex items-center justify-center p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-gray-200 transition-all duration-300">
                                        <img src="{{ $logo }}" alt="{{ $name }}" class="h-10 max-w-full object-contain">
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Silver Sponsors -->
                @if($silverSponsors->count() > 0 || $sponsors->isEmpty())
                    <div>
                        <h3 class="text-[18px] font-bold text-[#1E1B4B] mb-5 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span> Silver Sponsors
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-6">
                            @forelse ($silverSponsors as $sponsor)
                                <div class="bg-white border border-gray-100 rounded-[20px] h-[80px] flex items-center justify-center p-4 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-gray-200 transition-all duration-300" title="{{ $sponsor->name }}">
                                    @if($sponsor->logo_url)
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="h-8 max-w-full object-contain">
                                    @else
                                        <span class="text-[12px] font-bold text-gray-500 text-center line-clamp-2 uppercase tracking-wider px-4">{{ $sponsor->name }}</span>
                                    @endif
                                </div>
                            @empty
                                @foreach ([
                                    ['Dell Technologies', 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Dell_logo_2016.svg'],
                                    ['Cisco Systems', 'https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg'],
                                    ['Bosch', 'https://upload.wikimedia.org/wikipedia/commons/b/b2/Bosch_logo.svg']
                                ] as [$name, $logo])
                                    <div class="bg-white border border-gray-100 rounded-[20px] h-[80px] flex items-center justify-center p-4 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-gray-200 transition-all duration-300">
                                        <img src="{{ $logo }}" alt="{{ $name }}" class="h-8 max-w-full object-contain">
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Agenda Tab Content -->
        <div id="tab-content-agenda" class="tab-content hidden pb-10">
            <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white max-w-[850px] mx-auto">
                <h3 class="text-[18px] font-bold text-[#1E1B4B] mb-7">Exhibition Agenda & Sessions</h3>
                <div class="space-y-6">
                    @forelse ($agenda as $session)
                        <div class="flex gap-4 rounded-[12px] bg-[#FBFAFF] border border-[#F1EFF7] p-5">
                            <div class="w-[120px] shrink-0">
                                <span class="text-[13px] font-bold text-indigo-600 block">{{ $session->start_time }}</span>
                                <span class="text-[12px] text-gray-500 font-medium block mt-1">{{ $session->date }}</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-[16px] font-bold text-[#071044] mb-1.5">{{ $session->title }}</h4>
                                <p class="text-[13px] text-[#5A6480] font-medium leading-relaxed">{{ $session->description }}</p>
                                @if($session->speaker_name)
                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="text-[12px] font-bold text-[#071044]">Speaker:</span>
                                        <span class="text-[12px] text-indigo-600 font-semibold">{{ $session->speaker_name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        @foreach ([
                            ['10:00 AM', 'Day 1', 'Exhibition Lobby & Pavilion Launch', 'Welcome remarks, visitor pass onboarding instructions, and dynamic booth map orientation.'],
                            ['12:30 PM', 'Day 1', 'Future of Deep Learning & Robotics Keynote', 'Keynote address by Dr. Alan Stone on state-of-the-art AI research, autonomous agent architectures and large model workflows.'],
                            ['03:00 PM', 'Day 2', 'Microservices & Enterprise Cloud Security', 'An in-depth tech talk by Elena Rodriguez on migrating zero-downtime microservices to secure, scalable cloud infrastructure.'],
                            ['05:30 PM', 'Day 2', 'High-Performance Data Storage Engagements', 'A technical workshop by David Chen on designing distributed real-time analytics query engines and billing cognitive managers.']
                        ] as [$time, $day, $title, $description])
                            <div class="flex gap-4 rounded-[12px] bg-[#FBFAFF] border border-[#F1EFF7] p-5">
                                <div class="w-[120px] shrink-0">
                                    <span class="text-[13px] font-bold text-indigo-600 block">{{ $time }}</span>
                                    <span class="text-[12px] text-gray-500 font-medium block mt-1">{{ $day }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-[16px] font-bold text-[#071044] mb-1.5">{{ $title }}</h4>
                                    <p class="text-[13px] text-[#5A6480] font-medium leading-relaxed">{{ $description }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<script>
    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        
        // Show active tab content
        const activeContent = document.getElementById('tab-content-' + tabId);
        if (activeContent) {
            activeContent.classList.remove('hidden');
        }
        
        // Reset all tab button styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-indigo-600', 'text-indigo-600', 'font-bold');
            btn.classList.add('border-transparent', 'text-gray-500', 'font-medium');
        });
        
        // Highlight active tab button
        const activeBtn = document.getElementById('btn-tab-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-gray-500', 'font-medium');
            activeBtn.classList.add('border-indigo-600', 'text-indigo-600', 'font-bold');
        }
    }

    // Handle hash on page load
    window.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        if (hash === '#tab-speakers') {
            switchTab('speakers');
        } else if (hash === '#tab-sponsors') {
            switchTab('sponsors');
        } else if (hash === '#tab-agenda') {
            switchTab('agenda');
        } else {
            switchTab('about');
        }
    });

    // Handle hash change
    window.addEventListener('hashchange', () => {
        const hash = window.location.hash;
        if (hash === '#tab-speakers') {
            switchTab('speakers');
        } else if (hash === '#tab-sponsors') {
            switchTab('sponsors');
        } else if (hash === '#tab-agenda') {
            switchTab('agenda');
        } else {
            switchTab('about');
        }
    });
</script>
@endpush
@endsection

