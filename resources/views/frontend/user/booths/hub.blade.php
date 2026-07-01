@extends('layouts.visitor-booth-hub')

@section('title', $companyName . ' — Booth Hub')

@section('page-styles')
<style>
    .hub-hero-bg {
        background-image: url('{{ $heroBannerUrl ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1400&q=80' }}');
        background-size: cover;
        background-position: center right;
    }
    .hub-accordion-panel {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.3s ease;
    }
    .hub-accordion-panel.is-open {
        grid-template-rows: 1fr;
    }
    .hub-accordion-panel > .hub-accordion-inner {
        overflow: hidden;
    }
    .hub-accordion-trigger.is-active {
        border-color: #c4b5fd;
        box-shadow: 0 4px 14px rgba(76, 51, 195, 0.12);
    }
    .hub-accordion-trigger.is-active .hub-chevron {
        transform: rotate(180deg);
    }
</style>
@endsection

@section('content')
@php
    $about = $profile?->about_company ?: $profile?->welcome_text ?: $profile?->tagline ?: 'Explore company details, products, brochures and live sessions from this exhibitor booth.';
    $videoItem = $mediaItems->first(fn ($m) => !empty($m->video_url) || ($m->type ?? '') === 'video');
    $videoUrl = $videoItem?->video_url ?: $profile?->video_url;
    $firstName = explode(' ', $user->name ?? 'Visitor')[0];
    $allowOneToOne = $meetingAvailability?->allow_one_to_one ?? true;
    $allowOneToMany = $meetingAvailability?->allow_one_to_many ?? false;
    $defaultMeetingDate = $exhibition->start_date && now()->lt($exhibition->start_date)
        ? $exhibition->start_date->format('Y-m-d')
        : now()->addDay()->format('Y-m-d');
@endphp

@if (session('success') || session('error'))
<div class="max-w-[1536px] mx-auto px-4 sm:px-6 pt-4">
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-[13px] font-semibold text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] font-semibold text-red-800">{{ session('error') }}</div>
    @endif
</div>
@endif

<div class="max-w-[1536px] mx-auto px-4 sm:px-6 py-6 flex flex-col xl:flex-row gap-6">

    {{-- LEFT SIDEBAR --}}
    <aside class="hidden xl:flex w-full xl:w-[230px] shrink-0 flex-col gap-6">
        <div>
            <h3 class="text-[15px] font-bold text-slate-900 mb-4 ml-3">My Account</h3>
            <ul class="flex flex-col gap-2.5">
                <li>
                    <a href="{{ route('frontend.user.profile') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-slate-500 hover:bg-white hover:text-primary hover:shadow-sm rounded-xl transition-all font-semibold text-[14px]">
                        <i class="fa-regular fa-user fa-fw text-[18px]"></i>
                        <span>Profile Information</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.user.passes') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-slate-500 hover:bg-white hover:text-primary hover:shadow-sm rounded-xl transition-all font-semibold text-[14px]">
                        <i class="fa-solid fa-ticket-simple fa-fw text-[18px]"></i>
                        <span>My Passes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.user.passes') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-slate-500 hover:bg-white hover:text-primary hover:shadow-sm rounded-xl transition-all font-semibold text-[14px]">
                        <i class="fa-regular fa-file-lines fa-fw text-[18px]"></i>
                        <span>My Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.user.meetings') }}" class="flex items-center gap-3.5 px-3 py-2.5 text-slate-500 hover:bg-white hover:text-primary hover:shadow-sm rounded-xl transition-all font-semibold text-[14px]">
                        <i class="fa-solid fa-users fa-fw text-[18px]"></i>
                        <span>My Meetings</span>
                    </a>
                </li>
                <li>
                    <button type="button" data-hub-accordion="brochures" class="w-full flex items-center gap-3.5 px-3 py-2.5 text-slate-500 hover:bg-white hover:text-primary hover:shadow-sm rounded-xl transition-all font-semibold text-[14px] text-left">
                        <i class="fa-solid fa-download fa-fw text-[18px]"></i>
                        <span>My Downloads</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl p-5 mt-auto shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-3">
                <i class="fa-solid fa-headset text-primary text-[16px]"></i>
                <h4 class="font-bold text-[14px] text-slate-800">Need Help?</h4>
            </div>
            <p class="text-[11px] text-slate-500 mb-4 leading-relaxed font-medium">Contact our support team for assistance.</p>
            <a href="{{ route('frontend.user.dashboard') }}" class="bg-primary text-white text-[12px] font-bold py-2 px-4 rounded-lg flex justify-center items-center gap-2 hover:bg-[#3b279c] transition-colors shadow-sm">
                Chat Now <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </div>
    </aside>

    {{-- CENTER CONTENT --}}
    <main class="flex-1 flex flex-col min-w-0 gap-6">

        {{-- Hero Banner --}}
        <div class="bg-gradient-to-r from-[#170f49] to-[#2e1d7a] rounded-2xl h-[340px] relative overflow-hidden shadow-card flex items-center px-10 md:px-12 border border-indigo-900/50">
            <div class="absolute inset-0 right-0 hub-hero-bg"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#0c0529] via-[#0c0529]/80 to-transparent w-[70%]"></div>

            <div class="relative z-10 w-full md:max-w-[80%] lg:max-w-[60%] pt-4">
                <h1 class="text-[30px] md:text-[34px] font-bold text-white mb-3">Welcome Back, {{ $firstName }}! <span class="text-[28px]">👋</span></h1>
                <p class="text-[14px] md:text-[15px] font-medium text-indigo-100/90 mb-10 leading-relaxed max-w-[100%] md:max-w-[85%]">
                    Discover events, connect with exhibitors <br class="hidden sm:inline"> and make the most of your experience.
                </p>

                <div class="flex items-center gap-8 md:gap-14 bg-[#1b1049]/60 backdrop-blur-md border border-white/10 rounded-2xl px-6 md:px-10 py-5 md:py-6 inline-flex flex-wrap shadow-lg">
                    <div class="flex flex-col items-start relative after:content-[''] after:absolute after:right-[-1rem] md:after:right-[-1.75rem] after:top-1/2 after:-translate-y-1/2 after:h-[70%] after:w-px after:bg-white/10">
                        <span class="text-[26px] md:text-[32px] font-bold text-white leading-tight mb-0.5">{{ str_pad((string) $stats['upcoming_events'], 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-[12px] font-medium text-indigo-200/90 tracking-wide">Upcoming Events</span>
                    </div>
                    <div class="flex flex-col items-start relative after:content-[''] after:absolute after:right-[-1rem] md:after:right-[-1.75rem] after:top-1/2 after:-translate-y-1/2 after:h-[70%] after:w-px after:bg-white/10">
                        <span class="text-[26px] md:text-[32px] font-bold text-white leading-tight mb-0.5">{{ str_pad((string) $stats['meetings'], 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-[12px] font-medium text-indigo-200/90 tracking-wide">My Meetings</span>
                    </div>
                    <div class="flex flex-col items-start pl-2">
                        <span class="text-[26px] md:text-[32px] font-bold text-white leading-tight mb-0.5">{{ str_pad((string) $stats['saved_items'], 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-[12px] font-medium text-indigo-200/90 tracking-wide">Saved Items</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Products & Services --}}
        <div class="bg-white rounded-2xl shadow-card p-4 md:p-6 border border-gray-100" id="products">
            <div class="flex justify-between items-center mb-4 md:mb-5">
                <h2 class="text-[16px] md:text-[18px] font-bold text-slate-900">Our Products & Services</h2>
                <a href="#products" class="text-[12px] font-bold text-primary hover:underline">View All</a>
            </div>
            @if ($products->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($products->take(4) as $product)
                <div class="flex gap-3 bg-white p-3 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                    @if ($product->product_image)
                        <img src="{{ asset('storage/' . $product->product_image) }}" class="w-[76px] h-[84px] object-cover rounded-lg shadow-sm group-hover:opacity-90 shrink-0" alt="{{ $product->name }}">
                    @else
                        <div class="w-[76px] h-[84px] bg-gradient-to-br from-slate-700 to-indigo-900 rounded-lg shadow-sm flex items-center justify-center text-indigo-300 text-[32px] shrink-0 group-hover:opacity-90">
                            <i class="fa-solid fa-box"></i>
                        </div>
                    @endif
                    <div class="flex flex-col justify-center py-0.5 min-w-0">
                        <h4 class="text-[14px] font-bold text-slate-900 mb-1 group-hover:text-primary transition-colors">{{ $product->name }}</h4>
                        <p class="text-[11px] text-slate-500 mb-2 leading-snug pr-0.5 line-clamp-2 font-medium">{{ $product->short_description ?: 'High performance solutions from ' . $companyName }}</p>
                        <button type="button" data-hub-accordion="company-details" class="text-[11px] font-bold text-primary flex items-center gap-1.5 mt-auto text-left">Learn More <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i></button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-[13px] text-slate-500">No products published for this booth yet.</p>
            @endif
        </div>

        {{-- Feature Cards + Accordion --}}
        <div class="flex flex-col gap-4" id="boothHubAccordions">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <button type="button" data-hub-accordion="company-details" class="hub-accordion-trigger bg-white rounded-xl shadow-card p-5 border border-gray-100 flex flex-col hover:-translate-y-1 transition-all cursor-pointer group text-left">
                    <div class="w-10 h-10 rounded-full bg-white border-2 border-indigo-50 shadow-sm flex items-center justify-center text-primary mb-3.5 group-hover:bg-primary group-hover:text-white transition-colors">
                        <i class="fa-regular fa-building text-[16px]"></i>
                    </div>
                    <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 group-hover:text-primary transition-colors">Company Details</h4>
                    <p class="text-[10px] text-slate-500 mb-4 leading-[1.5] flex-1 font-medium">Learn more about our company, vision, mission and team.</p>
                    <span class="text-[11px] font-bold text-primary flex items-center gap-1.5 mt-auto">View Details <i class="fa-solid fa-chevron-down hub-chevron text-[9px] transition-transform"></i></span>
                </button>

                <button type="button" data-hub-accordion="brochures" class="hub-accordion-trigger bg-white rounded-xl shadow-card p-5 border border-gray-100 flex flex-col hover:-translate-y-1 transition-all cursor-pointer group text-left">
                    <div class="w-10 h-10 rounded-full bg-white border-2 border-indigo-50 shadow-sm flex items-center justify-center text-primary mb-3.5 group-hover:bg-primary group-hover:text-white transition-colors">
                        <i class="fa-regular fa-file-pdf text-[16px]"></i>
                    </div>
                    <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 group-hover:text-primary transition-colors">Brochures</h4>
                    <p class="text-[10px] text-slate-500 mb-4 leading-[1.5] flex-1 font-medium">Download our company profile, product catalog and more.</p>
                    <span class="text-[11px] font-bold text-primary flex items-center gap-1.5 mt-auto">Download Now <i class="fa-solid fa-chevron-down hub-chevron text-[9px] transition-transform"></i></span>
                </button>

                <button type="button" data-hub-accordion="company-video" class="hub-accordion-trigger bg-white rounded-xl shadow-card p-5 border border-gray-100 flex flex-col hover:-translate-y-1 transition-all cursor-pointer group text-left">
                    <div class="w-10 h-10 rounded-full bg-white border-2 border-indigo-50 shadow-sm flex items-center justify-center text-primary mb-3.5 group-hover:bg-primary group-hover:text-white transition-colors">
                        <i class="fa-regular fa-circle-play text-[16px]"></i>
                    </div>
                    <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 group-hover:text-primary transition-colors">Company Video</h4>
                    <p class="text-[10px] text-slate-500 mb-4 leading-[1.5] flex-1 font-medium">Watch our video to know more about our solutions and success stories.</p>
                    <span class="text-[11px] font-bold text-primary flex items-center gap-1.5 mt-auto">Watch Now <i class="fa-solid fa-chevron-down hub-chevron text-[9px] transition-transform"></i></span>
                </button>

                <button type="button" data-hub-accordion="live-session" class="hub-accordion-trigger bg-white rounded-xl shadow-card p-5 border border-gray-100 flex flex-col hover:-translate-y-1 transition-all cursor-pointer group text-left">
                    <div class="w-10 h-10 rounded-full bg-[#c4b5fd] border-2 border-[#c4b5fd] shadow-sm flex items-center justify-center text-white mb-3.5 group-hover:bg-primary group-hover:border-primary transition-colors">
                        <i class="fa-solid fa-headset text-[16px]"></i>
                    </div>
                    <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 group-hover:text-primary transition-colors">Live Session (1 to 1)</h4>
                    <p class="text-[10px] text-slate-500 mb-4 leading-[1.5] flex-1 font-medium">Schedule a 1 to 1 meeting with our experts at your convenience.</p>
                    <span class="text-[11px] font-bold text-primary flex items-center gap-1.5 mt-auto">Request Meeting <i class="fa-solid fa-chevron-down hub-chevron text-[9px] transition-transform"></i></span>
                </button>

                <button type="button" data-hub-accordion="conference" class="hub-accordion-trigger bg-white rounded-xl shadow-card p-5 border border-gray-100 flex flex-col hover:-translate-y-1 transition-all cursor-pointer group text-left">
                    <div class="w-10 h-10 rounded-full bg-white border-2 border-indigo-50 shadow-sm flex items-center justify-center text-primary mb-3.5 group-hover:bg-primary group-hover:text-white transition-colors">
                        <i class="fa-solid fa-desktop text-[16px]"></i>
                    </div>
                    <h4 class="text-[13px] font-bold text-slate-800 mb-1.5 group-hover:text-primary transition-colors">Conference</h4>
                    <p class="text-[10px] text-slate-500 mb-4 leading-[1.5] flex-1 font-medium">Join our live sessions and webinars to learn, engage and grow.</p>
                    <span class="text-[11px] font-bold text-primary flex items-center gap-1.5 mt-auto">View Schedule <i class="fa-solid fa-chevron-down hub-chevron text-[9px] transition-transform"></i></span>
                </button>
            </div>

            <div id="hubAccordionPanel" class="hub-accordion-panel">
                <div class="hub-accordion-inner">
                    <div class="bg-white rounded-2xl shadow-card border border-gray-100 p-6">

                        <div data-hub-panel="company-details" class="hidden">
                            <h2 class="text-[17px] font-bold text-slate-900 mb-2">About {{ $companyName }}</h2>
                            <p class="text-[14px] text-slate-600 leading-7">{{ strip_tags($about) }}</p>
                        </div>

                        <div data-hub-panel="brochures" class="hidden">
                            <h2 class="text-[17px] font-bold text-slate-900 mb-3">Brochures & Downloads</h2>
                            @forelse ($documents as $doc)
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0 text-[13px] font-semibold text-primary hover:underline">
                                    {{ $doc->title }}
                                    <i class="fa-solid fa-download text-[11px]"></i>
                                </a>
                            @empty
                                <p class="text-[13px] text-slate-500">No brochures available yet.</p>
                            @endforelse
                        </div>

                        <div data-hub-panel="company-video" class="hidden">
                            <h2 class="text-[17px] font-bold text-slate-900 mb-3">Company Video</h2>
                            @if ($videoUrl)
                                <div class="aspect-video rounded-xl overflow-hidden bg-black">
                                    <iframe src="{{ $videoUrl }}" class="w-full h-full" allowfullscreen></iframe>
                                </div>
                            @else
                                <p class="text-[13px] text-slate-500">No company video published yet.</p>
                            @endif
                        </div>

                        <div data-hub-panel="live-session" class="hidden">
                            <h2 class="text-[17px] font-bold text-slate-900 mb-2">Live Session (1 to 1)</h2>
                            <p class="text-[14px] text-slate-600 leading-7 mb-4">Request a private meeting with {{ $companyName }}. Your request will be sent to the exhibitor for approval.</p>
                            <form method="POST" action="{{ route('frontend.user.exhibitions.booths.meetings.request', [$slug, $hallSlug, $boothId]) }}" class="space-y-3 max-w-xl">
                                @csrf
                                <input type="text" name="meeting_topic" value="{{ old('meeting_topic') }}" placeholder="Meeting topic" required class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <input type="text" name="visitor_name" value="{{ old('visitor_name', $user->name) }}" placeholder="Your name" required class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                    <input type="email" name="visitor_email" value="{{ old('visitor_email', $user->email) }}" placeholder="Email" required class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                </div>
                                <select name="meeting_type" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                    @if ($allowOneToOne)
                                        <option value="one-to-one" @selected(old('meeting_type', 'one-to-one') === 'one-to-one')>One-to-One</option>
                                    @endif
                                    @if ($allowOneToMany)
                                        <option value="one-to-many" @selected(old('meeting_type') === 'one-to-many')>One-to-Many</option>
                                    @endif
                                    @if (! $allowOneToOne && ! $allowOneToMany)
                                        <option value="one-to-one">One-to-One</option>
                                    @endif
                                </select>
                                @if ($meetingSlots->isNotEmpty())
                                    <select name="booth_meeting_slot_id" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                        <option value="">Choose a slot or use preferred date/time</option>
                                        @foreach ($meetingSlots as $slot)
                                            <option value="{{ $slot->id }}" @selected(old('booth_meeting_slot_id') == $slot->id)>
                                                {{ $slot->date?->format('M d') }} · {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <input type="date" name="preferred_date" value="{{ old('preferred_date', $defaultMeetingDate) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                    <input type="time" name="preferred_time" value="{{ old('preferred_time', '10:00') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[13px] outline-none focus:border-primary">
                                </div>
                                <textarea name="message" placeholder="Message / agenda (optional)" class="w-full min-h-[90px] rounded-lg border border-gray-200 p-4 text-[13px] outline-none focus:border-primary">{{ old('message') }}</textarea>
                                <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white text-[13px] font-bold py-2.5 px-5 rounded-lg hover:bg-[#3b279c] transition-colors">
                                    Send Meeting Request <i class="fa-solid fa-paper-plane text-[10px]"></i>
                                </button>
                            </form>
                        </div>

                        <div data-hub-panel="conference" class="hidden">
                            <h2 class="text-[17px] font-bold text-slate-900 mb-3">Conference Sessions</h2>
                            @forelse ($sessions as $session)
                                @php
                                    $isRegistered = in_array($session->id, $registeredSessionIds ?? [], true);
                                    $bookingId = $sessionBookingIds[$session->id] ?? null;
                                    $joinUrl = $session->companyMeeting?->zoom_join_url ?: $session->companyMeeting?->meeting_link;
                                    $isLive = $session->status === 'live';
                                @endphp
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 py-3 border-b border-gray-50 last:border-0">
                                    <div>
                                        <p class="text-[14px] font-bold text-slate-800 flex items-center gap-2">
                                            {{ $session->title }}
                                            @if ($isLive)
                                                <span class="text-[10px] font-bold uppercase text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Live</span>
                                            @endif
                                        </p>
                                        <p class="text-[12px] text-slate-500">
                                            {{ $session->session_date?->format('M d, Y') }}
                                            @if($session->start_time) · {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} @endif
                                            @if($session->attendee_limit) · {{ $session->attendee_limit }} seats @endif
                                        </p>
                                        @if ($session->description)
                                            <p class="text-[12px] text-slate-500 mt-1">{{ Str::limit($session->description, 120) }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2 shrink-0">
                                        @if ($isLive && $joinUrl)
                                            <a href="{{ $joinUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-green-600 text-white text-[12px] font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                                Join Conference <i class="fa-solid fa-video text-[10px]"></i>
                                            </a>
                                        @elseif ($bookingId)
                                            <form method="POST" action="{{ route('frontend.user.meetings.join', $bookingId) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white text-[12px] font-bold py-2 px-4 rounded-lg hover:bg-[#3b279c] transition-colors">
                                                    Request to Join <i class="fa-solid fa-handshake text-[10px]"></i>
                                                </button>
                                            </form>
                                        @elseif ($isRegistered)
                                            <span class="inline-flex items-center gap-1.5 text-[12px] font-bold text-green-700 bg-green-50 px-3 py-2 rounded-lg">
                                                <i class="fa-solid fa-check"></i> Registered
                                            </span>
                                        @else
                                            <form method="POST" action="{{ route('frontend.user.exhibitions.booths.sessions.register', [$slug, $hallSlug, $boothId, $session->id]) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white text-[12px] font-bold py-2 px-4 rounded-lg hover:bg-[#3b279c] transition-colors">
                                                    Register <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-[13px] text-slate-500">No sessions scheduled yet.</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const panel = document.getElementById('hubAccordionPanel');
                const triggers = document.querySelectorAll('[data-hub-accordion]');
                const panels = document.querySelectorAll('[data-hub-panel]');
                let activeId = null;

                const openPanel = (id) => {
                    panels.forEach((el) => el.classList.toggle('hidden', el.dataset.hubPanel !== id));
                    triggers.forEach((btn) => btn.classList.toggle('is-active', btn.dataset.hubAccordion === id));
                    panel.classList.add('is-open');
                    activeId = id;
                    panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                };

                const closePanel = () => {
                    panels.forEach((el) => el.classList.add('hidden'));
                    triggers.forEach((btn) => btn.classList.remove('is-active'));
                    panel.classList.remove('is-open');
                    activeId = null;
                };

                triggers.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.hubAccordion;
                        if (activeId === id) {
                            closePanel();
                        } else {
                            openPanel(id);
                        }
                    });
                });

                @if (old('meeting_topic') || $errors->has('meeting_topic'))
                    openPanel('live-session');
                @elseif (session('success') && str_contains(session('success'), 'registered'))
                    openPanel('conference');
                @endif
            });
        </script>
    </main>

    {{-- RIGHT SIDEBAR --}}
    <aside class="w-full xl:w-[280px] shrink-0 flex flex-col gap-6">
        <div class="bg-white rounded-2xl shadow-card p-6 border border-gray-100 flex flex-col items-center text-center">
            <div class="w-full flex justify-between items-center mb-4">
                <h3 class="font-bold text-[14px] text-slate-800">Profile Overview</h3>
            </div>
            <div class="w-[72px] h-[72px] rounded-full p-1 border-2 border-indigo-100 mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=334155" class="w-full h-full rounded-full object-cover" alt="{{ $user->name }}">
            </div>
            <h2 class="text-[18px] font-bold text-slate-900 mb-1">{{ $user->name }}</h2>
            <p class="text-[12px] text-slate-500 font-medium mb-5">Visitor</p>
            <a href="{{ route('frontend.user.profile') }}" class="w-full py-2 rounded-lg border border-gray-200 text-primary text-[13px] font-bold hover:bg-gray-50 transition-colors">View Profile</a>
        </div>

        <div class="bg-white rounded-2xl shadow-card p-5 border border-gray-100">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-bold text-[14px] text-slate-800">Upcoming Schedule</h3>
                <a href="{{ route('frontend.user.meetings') }}" class="text-[12px] font-bold text-primary hover:underline">View All</a>
            </div>

            <div class="flex flex-col gap-4">
                @forelse ($scheduleItems as $item)
                <div class="flex gap-3 items-start">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-primary flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid {{ $item['icon'] ?? 'fa-calendar-check' }} text-[14px]"></i>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[13px] font-bold text-slate-800 mb-1 leading-tight">{{ $item['title'] }}</h4>
                        <p class="text-[11px] text-slate-500 mb-0.5 font-medium">{{ $item['datetime'] }}</p>
                        <p class="text-[11px] text-slate-400">{{ $item['location'] }}</p>
                    </div>
                </div>
                @if (! $loop->last)<div class="w-full h-px bg-gray-100"></div>@endif
                @empty
                <p class="text-[12px] text-slate-500">No upcoming items yet.</p>
                @endforelse
            </div>
        </div>

        <a href="{{ $backUrl }}" class="text-center py-3 text-[13px] font-bold text-slate-600 hover:text-primary border border-gray-200 rounded-xl bg-white shadow-card transition-colors">
            ← Back to Hall Layout
        </a>
    </aside>
</div>
@endsection
