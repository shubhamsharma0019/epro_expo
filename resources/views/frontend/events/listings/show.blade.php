@extends('layouts.frontend')

@php
    if (isset($dbEvent)) {
        $eventSlug = $dbEvent->slug;
        $ticketTypes = $dbEvent->ticketTypes ?? collect();
        $sessions = $dbEvent->sessions ?? collect();
        $speakers = $dbEvent->speakers ?? collect();
        $minTicket = $ticketTypes->sortBy('price')->first();
        $minPrice = $minTicket?->price;
        $currency = strtoupper($minTicket?->currency ?: 'INR');
        $currencySymbols = ['INR' => 'Rs. ', 'USD' => '$', 'EUR' => 'EUR ', 'GBP' => 'GBP '];
        $price = $minPrice !== null
            ? (($currencySymbols[$currency] ?? $currency . ' ') . number_format((float) $minPrice, 2))
            : 'Free';
        $eventVenue = collect([$dbEvent->venue_name])
            ->merge(collect(explode(',', (string) $dbEvent->venue_address))->map(fn ($part) => trim($part)))
            ->merge([$dbEvent->city, $dbEvent->country])
            ->filter()
            ->unique(fn ($part) => strtolower($part))
            ->join(', ');
        $eventWebsite = $dbEvent->website ?: $dbEvent->company?->website;
        $eventWebsiteUrl = $eventWebsite
            ? (str_starts_with($eventWebsite, 'http') ? $eventWebsite : 'https://' . $eventWebsite)
            : null;
        $organizerName = $dbEvent->company?->company_name
            ?: $dbEvent->company?->name
            ?: $dbEvent->company?->contact_person_name
            ?: 'Organizer TBD';
        $eventDays = $dbEvent->starts_at && $dbEvent->ends_at
            ? max(1, $dbEvent->starts_at->copy()->startOfDay()->diffInDays($dbEvent->ends_at->copy()->startOfDay()) + 1)
            : 1;
        $ticketCapacity = (int) $ticketTypes->sum('quantity_total');
        $ticketSold = (int) $ticketTypes->sum('quantity_sold');
        $eventCapacity = (int) ($dbEvent->capacity ?: $ticketCapacity);
        $seatsLeft = $eventCapacity > 0 ? max(0, $eventCapacity - $ticketSold) : null;
        $event = [
            'title' => $dbEvent->title,
            'tagline' => $dbEvent->branding?->tagline ?: ($dbEvent->summary ?: 'Event details and tickets are available now.'),
            'date' => $dbEvent->starts_at ? $dbEvent->starts_at->format('M d') . ($dbEvent->ends_at ? ' - ' . $dbEvent->ends_at->format('M d, Y') : $dbEvent->starts_at->format(', Y')) : 'Date TBD',
            'venue' => $eventVenue ?: 'Location TBD',
            'price' => $price,
            'image' => $dbEvent->branding?->banner_path ? asset('storage/' . $dbEvent->branding->banner_path) : 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
            'description' => $dbEvent->description ?: ($dbEvent->summary ?: $dbEvent->title . ' event information will be updated soon.'),
            'website' => $eventWebsite ?: 'Not provided',
            'website_url' => $eventWebsiteUrl,
            'organizer' => $organizerName,
            'category' => collect([$dbEvent->category, $dbEvent->sub_category])->filter()->map(fn ($value) => ucfirst(str_replace('_', ' ', $value)))->join(', ') ?: 'General',
            'event_id' => 'EVT-' . str_pad($dbEvent->id, 4, '0', STR_PAD_LEFT),
            'time' => $dbEvent->starts_at ? $dbEvent->starts_at->format('h:i A') . ($dbEvent->ends_at ? ' - ' . $dbEvent->ends_at->format('h:i A') : '') . ($dbEvent->timezone ? ' (' . $dbEvent->timezone . ')' : '') : 'Time TBD',
            'tags' => collect([$dbEvent->event_type, $dbEvent->category, $dbEvent->sub_category, $dbEvent->event_mode])
                ->filter()
                ->map(fn ($value) => ucfirst(str_replace('_', ' ', $value)))
                ->unique()
                ->values()
                ->all(),
            'highlights' => collect($dbEvent->highlights ?: [])
                ->filter()
                ->values()
                ->all(),
        ];
        if (empty($event['highlights'])) {
            $event['highlights'] = collect([
                $eventDays > 1 ? $eventDays . ' days event' : '1 day event',
                $sessions->count() ? $sessions->count() . ' sessions planned' : null,
                $speakers->count() ? $speakers->count() . ' speakers' : null,
                $eventCapacity ? number_format($eventCapacity) . ' attendee capacity' : null,
                $seatsLeft !== null ? number_format($seatsLeft) . ' seats left' : null,
                $dbEvent->event_mode ? ucfirst(str_replace('_', ' ', $dbEvent->event_mode)) . ' event experience' : null,
            ])->filter()->values()->all();
        }
        $eventTabs = collect([
            ['label' => 'About', 'href' => '#event-about', 'show' => filled($event['description']) || count($event['highlights']) > 0],
        ])->filter(fn ($tab) => $tab['show'])->values();
    } else {
        $eventSlug = $slug ?? 'global-tech-summit-2024';
        $eventDetails = [
            'global-tech-summit-2024' => [
                'title' => 'Global Tech Summit 2024',
                'tagline' => 'Innovate. Connect. Transform.',
                'date' => 'May 15 - May 17, 2024',
                'venue' => 'Jio World Convention Centre, Mumbai',
                'price' => '₹49.00',
                'image' => asset('images/events-home/trending/global-tech-summit.svg'),
                'description' => 'Global Tech Summit 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.globaltechsummit.com',
                'website_url' => url('/events'),
                'organizer' => 'TechFuture Events',
                'category' => 'Technology, Conference',
                'event_id' => 'GTS-2024-MUM',
                'time' => '09:00 AM - 06:00 PM (IST)'
            ],
            'world-ai-conference-2024' => [
                'title' => 'World AI Conference 2024',
                'tagline' => 'Explore the next generation of intelligent products.',
                'date' => 'May 18 - May 19, 2024',
                'venue' => 'London Tech Arena, UK',
                'price' => '₹29.00',
                'image' => asset('images/events-home/trending/world-ai-conference.svg'),
                'description' => 'World AI Conference 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.worldai.com',
                'website_url' => url('/events'),
                'organizer' => 'AI Global Forum',
                'category' => 'AI, Conference',
                'event_id' => 'WAI-2024-LDN',
                'time' => '09:00 AM - 06:00 PM (BST)'
            ],
            'digital-marketing-summit' => [
                'title' => 'Digital Marketing Summit',
                'tagline' => 'Growth, content, performance, and brand strategy.',
                'date' => 'May 21, 2024',
                'venue' => 'Toronto Digital Hub, Canada',
                'price' => '₹19.00',
                'image' => asset('images/events-home/trending/digital-marketing-summit.svg'),
                'description' => 'Digital Marketing Summit brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.digitalmarketing.com',
                'website_url' => url('/events'),
                'organizer' => 'Marketing Assoc',
                'category' => 'Marketing, Summit',
                'event_id' => 'DMS-2024-TOR',
                'time' => '09:00 AM - 05:00 PM (EST)'
            ],
            'healthcare-innovation-2024' => [
                'title' => 'Healthcare Innovation 2024',
                'tagline' => 'Modern healthcare, diagnostics, and patient experience.',
                'date' => 'May 18 - May 20, 2024',
                'venue' => 'Berlin MedTech Centre, Germany',
                'price' => '₹39.00',
                'image' => asset('images/events-home/trending/healthcare-innovation.svg'),
                'description' => 'Healthcare Innovation 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.healthcare-innovation.de',
                'website_url' => url('/events'),
                'organizer' => 'MedTech Europe',
                'category' => 'Healthcare, Innovation',
                'event_id' => 'HCI-2024-BER',
                'time' => '09:00 AM - 06:00 PM (CET)'
            ],
            'future-of-education-summit' => [
                'title' => 'Future of Education Summit',
                'tagline' => 'Learning technology, classrooms, and skills for tomorrow.',
                'date' => 'May 25 - May 26, 2024',
                'venue' => 'India Expo Centre, Greater Noida',
                'price' => '₹24.00',
                'image' => asset('images/events-home/trending/future-education.svg'),
                'description' => 'Future of Education Summit brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.futureeducation.in',
                'website_url' => url('/events'),
                'organizer' => 'EdTech India',
                'category' => 'Education, Summit',
                'event_id' => 'FES-2024-DEL',
                'time' => '09:00 AM - 06:00 PM (IST)'
            ],
            'sustainability-forum-2024' => [
                'title' => 'Sustainability Forum 2024',
                'tagline' => 'Climate, circular business, and clean growth.',
                'date' => 'May 27 - May 28, 2024',
                'venue' => 'Sydney Convention Centre, Australia',
                'price' => '₹19.00',
                'image' => asset('images/events-home/trending/sustainability-forum.svg'),
                'description' => 'Sustainability Forum 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.sustainabilityforum.au',
                'website_url' => url('/events'),
                'organizer' => 'GreenBusiness Org',
                'category' => 'Sustainability, Forum',
                'event_id' => 'SUF-2024-SYD',
                'time' => '09:00 AM - 06:00 PM (AEST)'
            ],
            'future-of-ai-expo' => [
                'title' => 'Future of AI Expo',
                'tagline' => 'AI products, demos, and automation showcases.',
                'date' => 'Jun 10 - Jun 12, 2024',
                'venue' => 'Pragati Maidan, New Delhi',
                'price' => '₹29.00',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Future of AI Expo brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.futureaiexpo.com',
                'website_url' => url('/events'),
                'organizer' => 'AI Tech Association',
                'category' => 'AI, Expo',
                'event_id' => 'AIX-2024-DEL',
                'time' => '10:00 AM - 06:00 PM (IST)'
            ],
            'sustainability-forum' => [
                'title' => 'Sustainability Forum',
                'tagline' => 'Clean energy, climate action, and sustainable business.',
                'date' => 'Jun 20, 2024',
                'venue' => 'BEC, Bangalore',
                'price' => '₹19.00',
                'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Sustainability Forum brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.sustainabilityforum.in',
                'website_url' => url('/events'),
                'organizer' => 'GreenTech Forum',
                'category' => 'Sustainability, Conference',
                'event_id' => 'SUS-2024-BLR',
                'time' => '09:00 AM - 06:00 PM (IST)'
            ],
            'healthcare-innovation-summit' => [
                'title' => 'Healthcare Innovation Summit',
                'tagline' => 'Healthcare leaders, product innovation, and care delivery.',
                'date' => 'Jul 01 - Jul 02, 2024',
                'venue' => 'HICC, Hyderabad',
                'price' => '₹39.00',
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Healthcare Innovation Summit brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.healthinnovation.in',
                'website_url' => url('/events'),
                'organizer' => 'Health India',
                'category' => 'Healthcare, Conference',
                'event_id' => 'HIS-2024-HYD',
                'time' => '09:00 AM - 06:00 PM (IST)'
            ],
        ];
        $event = $eventDetails[$eventSlug] ?? $eventDetails['global-tech-summit-2024'];
        $event['tags'] = collect(explode(',', $event['category'] ?? 'Event'))->map(fn ($value) => trim($value))->filter()->values()->all();
        $event['highlights'] = [
            'Event schedule information',
            'Ticket booking available',
            'Organizer details provided',
        ];
        $eventTabs = collect([
            ['label' => 'About', 'href' => '#event-about', 'show' => true],
        ])->filter(fn ($tab) => $tab['show'])->values();
    }
@endphp

@section('title', 'Event Details - ' . $event['title'])

@section('content')
<main class="px-[44px] pt-6 pb-12 flex-1">
            <!-- Breadcrumbs -->
            <div class="mb-6 flex items-center gap-2 text-[14px] text-[#6A708F]">
                <a href="{{ url('/events') }}" class="hover:text-[#5B35D5] transition">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings') }}" class="hover:text-[#5B35D5] transition">Events</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-[#1F2A6A]">{{ $event['title'] }}</span>
            </div>

            <!-- Top Grid: Banner & Highlights -->
            <div class="mb-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Banner -->
                <div class="relative lg:col-span-2 overflow-hidden rounded-[20px] bg-[#0A0D2A] text-white p-9 shadow-lg">
                    <!-- Background Image & Gradients -->
                    <div class="absolute right-0 top-0 h-full w-2/3 bg-cover bg-center opacity-70 mix-blend-screen" style="background-image: url('{{ $event['image'] }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0A0D2A] via-[#0A0D2A]/90 to-transparent"></div>
                    
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div>
                            <h1 class="mb-2 text-[32px] font-bold tracking-[-0.02em] text-white">{{ $event['title'] }}</h1>
                            <p class="mb-8 text-[16px] text-[#AAB0D1]">{{ $event['tagline'] }}</p>
                            
                            <div class="mb-8 space-y-3 text-[15px] text-[#D0D4EA]">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 2.25v3m7.5-3v3M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                    <span>{{ $event['date'] }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-4.35 6-10.125a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                    </svg>
                                    <span>{{ $event['venue'] }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-3">
                                @foreach (($event['tags'] ?? []) as $tag)
                                    <span class="rounded-lg bg-white/10 px-4 py-1.5 text-[13px] font-medium text-white backdrop-blur-md border border-white/5">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="absolute bottom-0 right-0">
                            <button type="button" onclick="navigator.share ? navigator.share({ title: @js($event['title']), url: window.location.href }) : navigator.clipboard?.writeText(window.location.href)" class="flex items-center gap-2 rounded-xl border border-white/30 bg-white/5 px-6 py-2.5 text-[14px] font-medium text-white transition hover:bg-white/10 backdrop-blur-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                </svg>
                                Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event Highlights -->
                <div class="lg:col-span-1 rounded-[20px] border border-[#E8E3F0] bg-white p-7 shadow-[0_4px_20px_rgba(31,42,107,0.03)]">
                    <h3 class="mb-6 text-[18px] font-bold tracking-[-0.01em] text-[#1F2A6A]">Event Highlights</h3>
                    <ul class="space-y-4 text-[15px] text-[#4E567A]">
                        @foreach (($event['highlights'] ?? ['Event details available']) as $highlight)
                        <li class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[22px] w-[22px] text-[#5B35D5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                            </svg>
                            <span class="font-medium">{{ $highlight }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-8 flex gap-8 border-b border-[#E6E1F0]">
                @foreach ($eventTabs as $tab)
                    <a href="{{ $tab['href'] }}" class="{{ $loop->first ? '-mb-px border-b-2 border-[#5B35D5] font-semibold text-[#5B35D5]' : 'font-medium text-[#4E567A] transition hover:text-[#5B35D5]' }} pb-3.5 text-[15px]">{{ $tab['label'] }}</a>
                @endforeach
            </div>

            <!-- Bottom Layout: About & Details List -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Left: About This Event -->
                <div id="event-about" class="lg:col-span-3 flex flex-col rounded-[20px] border border-[#E8E3F0] bg-white shadow-[0_4px_20px_rgba(31,42,107,0.02)]">
                    <div class="flex-1 p-8">
                        <h3 class="mb-5 text-[22px] font-bold tracking-[-0.01em] text-[#1F2A6A]">About This Event</h3>
                        <p class="mb-8 text-[17px] leading-[1.7] text-[#4E567A]">
                            {!! nl2br(e($event['description'] ?? ($event['title'] . ' brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.'))) !!}
                        </p>
                        <ul class="space-y-5 text-[17px] font-medium text-[#2B3263]">
                            @foreach (($event['highlights'] ?? []) as $highlight)
                                <li class="flex items-center gap-3">
                                    <div class="h-1.5 w-1.5 rounded-full bg-[#5B35D5]"></div>
                                    <span>{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Pricing Footer -->
                    <div id="event-tickets" class="flex items-center justify-between border-t border-[#E8E3F0] p-8">
                        <div>
                            <p class="text-[14px] text-[#4E567A] mb-0.5">Starts from</p>
                            <p class="text-[26px] font-bold tracking-[-0.02em] text-[#1F2A6A]">{{ $event['price'] }}</p>
                        </div>
                        <button onclick="window.location.href='{{ url('/events/tickets/select?event=' . $eventSlug) }}'" class="rounded-xl bg-[#4318FF] px-9 py-3.5 text-[15px] font-semibold text-white transition hover:bg-[#3412C9] shadow-[0_8px_20px_rgba(67,24,255,0.25)]">
                            Book Tickets
                        </button>
                    </div>
                </div>

                <!-- Right: Event Details List -->
                <div class="lg:col-span-2 rounded-[20px] border border-[#E8E3F0] bg-white p-8 shadow-[0_4px_20px_rgba(31,42,107,0.02)]">
                    <div class="flex flex-col space-y-5">
                        
                        <!-- Row 1: Date -->
                        <div id="event-venue" class="flex items-center gap-5 border-b border-[#F1EFF7] pb-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 2.25v3m7.5-3v3M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Date</div>
                            <div class="text-[15px] font-medium text-[#1F2A6A]">{{ $event['date'] }}</div>
                        </div>

                        <!-- Row 2: Time -->
                        <div id="event-website" class="flex items-center gap-5 border-b border-[#F1EFF7] pb-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Time</div>
                            <div class="text-[15px] font-medium text-[#1F2A6A]">{{ $event['time'] }}</div>
                        </div>

                        <!-- Row 3: Venue -->
                        <div class="flex items-center gap-5 border-b border-[#F1EFF7] pb-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Venue</div>
                            <div class="text-[15px] font-medium text-[#1F2A6A] leading-[1.5]">{{ $event['venue'] }}</div>
                        </div>

                        <!-- Row 4: Website -->
                        <div class="flex items-center gap-5 border-b border-[#F1EFF7] pb-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Website</div>
                            @if (! empty($event['website_url']))
                                <a href="{{ $event['website_url'] }}" target="_blank" rel="noopener" class="text-[15px] font-medium text-[#4318FF] hover:underline">{{ $event['website'] }}</a>
                            @else
                                <div class="text-[15px] font-medium text-[#1F2A6A]">{{ $event['website'] }}</div>
                            @endif
                        </div>

                        <!-- Row 5: Organized By -->
                        <div class="flex items-center gap-5 border-b border-[#F1EFF7] pb-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Organized By</div>
                            <div class="text-[15px] font-medium text-[#1F2A6A]">{{ $event['organizer'] }}</div>
                        </div>

                        <!-- Row 6: Category -->
                        <div class="flex items-center gap-5 border-b border-[#F1EFF7] pb-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Category</div>
                            <div class="text-[15px] font-medium text-[#1F2A6A]">{{ $event['category'] }}</div>
                        </div>

                        <!-- Row 7: Event ID -->
                        <div class="flex items-center gap-5">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                                </svg>
                            </div>
                            <div class="w-28 shrink-0 text-[15px] text-[#4E567A]">Event ID</div>
                            <div class="text-[15px] font-medium text-[#1F2A6A]">{{ $event['event_id'] }}</div>
                        </div>

                    </div>
                </div>
            </div>

        </main>
@endsection
