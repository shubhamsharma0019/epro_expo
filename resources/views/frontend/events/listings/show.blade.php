@extends('layouts.frontend')

@section('title', 'Event Details - ' . $event['title'])

@section('content')
<main class="mx-auto w-full max-w-[1400px] flex-1 px-4 pb-10 pt-6 md:px-[44px] md:pb-12 md:pt-8">
            <!-- Breadcrumbs -->
            <div class="mb-5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[13px] text-[#6A708F] md:mb-6 md:text-[14px]">
                <a href="{{ url('/events') }}" class="hover:text-[#5B35D5] transition">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings') }}" class="hover:text-[#5B35D5] transition">Events</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="min-w-0 max-w-full truncate font-medium text-[#1F2A6A]">{{ $event['title'] }}</span>
            </div>

            <!-- Top Grid: Banner & Highlights -->
            <div class="mb-6 grid grid-cols-1 gap-4 lg:mb-8 lg:grid-cols-3 lg:gap-6">
                <!-- Banner -->
                <div class="relative min-h-[320px] overflow-hidden rounded-[16px] bg-[#0A0D2A] p-5 text-white shadow-lg sm:min-h-[360px] sm:rounded-[20px] sm:p-7 lg:col-span-2 lg:min-h-[380px] lg:p-9">
                    <!-- Background Image & Gradients -->
                    <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-screen sm:right-0 sm:top-0 sm:h-full sm:w-2/3 sm:opacity-70" style="background-image: url('{{ $event['image'] }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-[#0A0D2A] via-[#0A0D2A]/95 to-[#0A0D2A]/80 sm:bg-gradient-to-r sm:from-[#0A0D2A] sm:via-[#0A0D2A]/90 sm:to-transparent"></div>
                    
                    <div class="relative z-10 flex h-full min-h-[280px] flex-col justify-between sm:min-h-[300px]">
                        <div class="min-w-0 pr-0 sm:pr-24">
                            <h1 class="mb-2 break-words text-[24px] font-bold tracking-[-0.02em] text-white sm:text-[28px] lg:text-[32px]">{{ $event['title'] }}</h1>
                            <p class="mb-5 break-words text-[14px] text-[#AAB0D1] sm:mb-8 sm:text-[16px]">{{ $event['tagline'] }}</p>
                            
                            <div class="mb-5 space-y-2.5 text-[14px] text-[#D0D4EA] sm:mb-8 sm:space-y-3 sm:text-[15px]">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 2.25v3m7.5-3v3M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                    <span class="min-w-0 break-words">{{ $event['date'] }}</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-4.35 6-10.125a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                    </svg>
                                    <span class="min-w-0 break-words">{{ $event['venue'] }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 sm:gap-3">
                                @foreach (($event['tags'] ?? []) as $tag)
                                    <span class="rounded-lg border border-white/5 bg-white/10 px-3 py-1 text-[12px] font-medium text-white backdrop-blur-md sm:px-4 sm:py-1.5 sm:text-[13px]">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-5 flex justify-end sm:absolute sm:bottom-0 sm:right-0 sm:mt-0">
                            <button type="button" onclick="navigator.share ? navigator.share({ title: @js($event['title']), url: window.location.href }) : navigator.clipboard?.writeText(window.location.href)" class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/30 bg-white/5 px-5 py-2.5 text-[14px] font-medium text-white transition hover:bg-white/10 backdrop-blur-md sm:w-auto sm:px-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                </svg>
                                Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event Highlights -->
                <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-5 shadow-[0_4px_20px_rgba(31,42,107,0.03)] sm:rounded-[20px] sm:p-7 lg:col-span-1">
                    <h3 class="mb-4 text-[17px] font-bold tracking-[-0.01em] text-[#1F2A6A] sm:mb-6 sm:text-[18px]">Event Highlights</h3>
                    <ul class="space-y-3 text-[14px] text-[#4E567A] sm:space-y-4 sm:text-[15px]">
                        @foreach (($event['highlights'] ?? ['Event details available']) as $highlight)
                        <li class="flex items-start gap-3 sm:items-center sm:gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-[#5B35D5] sm:mt-0 sm:h-[22px] sm:w-[22px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                            </svg>
                            <span class="min-w-0 font-medium">{{ $highlight }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-6 flex gap-5 overflow-x-auto border-b border-[#E6E1F0] md:mb-8 md:gap-8">
                @foreach ($eventTabs as $tab)
                    <a href="{{ $tab['href'] }}" class="{{ $loop->first ? '-mb-px border-b-2 border-[#5B35D5] font-semibold text-[#5B35D5]' : 'font-medium text-[#4E567A] transition hover:text-[#5B35D5]' }} shrink-0 whitespace-nowrap pb-3 text-[14px] sm:pb-3.5 sm:text-[15px]">{{ $tab['label'] }}</a>
                @endforeach
            </div>

            <!-- Bottom Layout: About & Details List -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-5 lg:gap-6">
                <!-- Left: About This Event -->
                <div id="event-about" class="flex flex-col rounded-[16px] border border-[#E8E3F0] bg-white shadow-[0_4px_20px_rgba(31,42,107,0.02)] sm:rounded-[20px] lg:col-span-3">
                    <div class="flex-1 p-5 sm:p-8">
                        <h3 class="mb-4 text-[20px] font-bold tracking-[-0.01em] text-[#1F2A6A] sm:mb-5 sm:text-[22px]">About This Event</h3>
                        <p class="mb-6 break-words text-[15px] leading-[1.7] text-[#4E567A] sm:mb-8 sm:text-[17px]">
                            {!! nl2br(e($event['description'])) !!}
                        </p>
                        <ul class="space-y-4 text-[15px] font-medium text-[#2B3263] sm:space-y-5 sm:text-[17px]">
                            @foreach (($event['highlights'] ?? []) as $highlight)
                                <li class="flex items-start gap-3">
                                    <div class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#5B35D5] sm:mt-2.5"></div>
                                    <span class="min-w-0 break-words">{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>

                        @if (($sessions ?? collect())->isNotEmpty())
                            <div id="event-agenda" class="mt-8 border-t border-[#E8E3F0] pt-6 sm:mt-10 sm:pt-8">
                                <h3 class="mb-4 text-[20px] font-bold tracking-[-0.01em] text-[#1F2A6A] sm:mb-5 sm:text-[22px]">Agenda</h3>
                                <div class="space-y-4 sm:space-y-5">
                                    @foreach ($sessions as $session)
                                        <div class="flex flex-col gap-2 border-b border-[#F1EFF7] pb-4 last:border-b-0 last:pb-0 sm:flex-row sm:gap-5 sm:pb-5">
                                            <div class="shrink-0 text-[13px] font-semibold text-[#5B35D5] sm:w-28 sm:text-[14px]">
                                                {{ $session->starts_at?->format('M d') ?: 'Date TBD' }}<br>
                                                <span class="font-medium text-[#4E567A]">{{ $session->starts_at?->format('h:i A') ?: 'Time TBD' }}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="break-words text-[15px] font-bold text-[#1F2A6A] sm:text-[16px]">{{ $session->title }}</h4>
                                                @if ($session->description)
                                                    <p class="mt-1 break-words text-[14px] leading-[1.6] text-[#4E567A] sm:text-[15px]">{{ $session->description }}</p>
                                                @endif
                                                @if ($session->location)
                                                    <p class="mt-2 break-words text-[13px] font-medium text-[#2B3263] sm:text-[14px]">{{ $session->location }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (($speakers ?? collect())->isNotEmpty())
                            <div id="event-speakers" class="mt-8 border-t border-[#E8E3F0] pt-6 sm:mt-10 sm:pt-8">
                                <h3 class="mb-4 text-[20px] font-bold tracking-[-0.01em] text-[#1F2A6A] sm:mb-5 sm:text-[22px]">Speakers</h3>
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                                    @foreach ($speakers as $speaker)
                                        <div class="rounded-[14px] border border-[#F1EFF7] p-4">
                                            <p class="break-words text-[15px] font-bold text-[#1F2A6A] sm:text-[16px]">{{ $speaker->name }}</p>
                                            @if ($speaker->designation || $speaker->organization)
                                                <p class="mt-1 break-words text-[13px] text-[#4E567A] sm:text-[14px]">
                                                    {{ collect([$speaker->designation, $speaker->organization])->filter()->join(' · ') }}
                                                </p>
                                            @endif
                                            @if ($speaker->bio)
                                                <p class="mt-2 break-words text-[13px] leading-[1.6] text-[#4E567A] sm:text-[14px]">{{ $speaker->bio }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Pricing Footer -->
                    <div id="event-tickets" class="flex flex-col gap-4 border-t border-[#E8E3F0] p-5 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                        <div>
                            <p class="mb-0.5 text-[14px] text-[#4E567A]">Starts from</p>
                            <p class="text-[22px] font-bold tracking-[-0.02em] text-[#1F2A6A] sm:text-[26px]">{{ $event['price'] }}</p>
                        </div>
                        <button onclick="window.location.href='{{ url('/events/tickets/select?event=' . $eventSlug) }}'" class="w-full rounded-xl bg-[#4318FF] px-7 py-3.5 text-[15px] font-semibold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)] transition hover:bg-[#3412C9] sm:w-auto sm:px-9">
                            Book Tickets
                        </button>
                    </div>
                </div>

                <!-- Right: Event Details List -->
                <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-5 shadow-[0_4px_20px_rgba(31,42,107,0.02)] sm:rounded-[20px] sm:p-8 lg:col-span-2">
                    <div class="flex flex-col space-y-4 sm:space-y-5">
                        
                        <!-- Row 1: Date -->
                        <div id="event-venue" class="flex flex-col gap-3 border-b border-[#F1EFF7] pb-4 sm:flex-row sm:items-center sm:gap-5 sm:pb-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 2.25v3m7.5-3v3M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Date</div>
                            </div>
                            <div class="min-w-0 break-words pl-[52px] text-[14px] font-medium text-[#1F2A6A] sm:pl-0 sm:text-[15px]">{{ $event['date'] }}</div>
                        </div>

                        <!-- Row 2: Time -->
                        <div id="event-website" class="flex flex-col gap-3 border-b border-[#F1EFF7] pb-4 sm:flex-row sm:items-center sm:gap-5 sm:pb-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Time</div>
                            </div>
                            <div class="min-w-0 break-words pl-[52px] text-[14px] font-medium text-[#1F2A6A] sm:pl-0 sm:text-[15px]">{{ $event['time'] }}</div>
                        </div>

                        <!-- Row 3: Venue -->
                        <div class="flex flex-col gap-3 border-b border-[#F1EFF7] pb-4 sm:flex-row sm:items-start sm:gap-5 sm:pb-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Venue</div>
                            </div>
                            <div class="min-w-0 break-words pl-[52px] text-[14px] font-medium leading-[1.5] text-[#1F2A6A] sm:pl-0 sm:text-[15px]">{{ $event['venue'] }}</div>
                        </div>

                        <!-- Row 4: Website -->
                        <div class="flex flex-col gap-3 border-b border-[#F1EFF7] pb-4 sm:flex-row sm:items-center sm:gap-5 sm:pb-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Website</div>
                            </div>
                            <div class="min-w-0 pl-[52px] sm:pl-0">
                                @if (! empty($event['website_url']))
                                    <a href="{{ $event['website_url'] }}" target="_blank" rel="noopener" class="break-all text-[14px] font-medium text-[#4318FF] hover:underline sm:text-[15px]">{{ $event['website'] }}</a>
                                @else
                                    <div class="break-words text-[14px] font-medium text-[#1F2A6A] sm:text-[15px]">{{ $event['website'] }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Row 5: Organized By -->
                        <div class="flex flex-col gap-3 border-b border-[#F1EFF7] pb-4 sm:flex-row sm:items-center sm:gap-5 sm:pb-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Organized By</div>
                            </div>
                            <div class="min-w-0 break-words pl-[52px] text-[14px] font-medium text-[#1F2A6A] sm:pl-0 sm:text-[15px]">{{ $event['organizer'] }}</div>
                        </div>

                        <!-- Row 6: Category -->
                        <div class="flex flex-col gap-3 border-b border-[#F1EFF7] pb-4 sm:flex-row sm:items-center sm:gap-5 sm:pb-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Category</div>
                            </div>
                            <div class="min-w-0 break-words pl-[52px] text-[14px] font-medium text-[#1F2A6A] sm:pl-0 sm:text-[15px]">{{ $event['category'] }}</div>
                        </div>

                        <!-- Row 7: Event ID -->
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-5">
                            <div class="flex items-center gap-3 sm:contents">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                                    </svg>
                                </div>
                                <div class="text-[14px] text-[#4E567A] sm:w-28 sm:shrink-0 sm:text-[15px]">Event ID</div>
                            </div>
                            <div class="min-w-0 break-words pl-[52px] text-[14px] font-medium text-[#1F2A6A] sm:pl-0 sm:text-[15px]">{{ $event['event_id'] }}</div>
                        </div>

                    </div>
                </div>
            </div>

        </main>
@endsection
