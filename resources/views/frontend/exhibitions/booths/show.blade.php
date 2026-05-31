@extends('layouts.frontend')

@section('title', 'Company Booth - EproExpo')

@section('content')
@php
    $company = $company ?? str($companySlug ?? 'technova-solutions')->replace('-', ' ')->title();
    $isPassActive = $isPassActive ?? false;
    $booking = $booking ?? null;
    $lockMessage = 'Register / Get Pass to access this feature';
    $profile = $profile ?? null;
    $branding = $branding ?? null;
    $products = collect($products ?? []);
    $documents = collect($documents ?? []);
    $catalogues = collect($catalogues ?? []);
    $mediaItems = collect($mediaItems ?? []);
    $teamMembers = collect($teamMembers ?? []);
    $meetingSlots = collect($meetingSlots ?? []);
    $companyMeetings = collect($companyMeetings ?? []);
    $sessions = collect($sessions ?? []);

    // Resolve visitor booking ID if user is logged in
    $visitor = auth()->check() ? \App\Models\Visitor::where('email', auth()->user()->email)->where('exhibition_id', $booking->exhibition_id ?? null)->first() : null;
    $visitorBookingId = $visitor?->booking_id;

    // Resolve demo video URL dynamically
    $boothVideo = $mediaItems->first(fn($m) => $m->type === 'video' || !empty($m->video_url));
    $demoVideoUrl = $boothVideo 
        ? ($boothVideo->file_path ? asset('storage/' . $boothVideo->file_path) : $boothVideo->video_url) 
        : 'https://www.w3schools.com/html/mov_bbb.mp4';
    
    // Resolve next booths dynamically from current exhibition
    $nextBooths = isset($booking) ? \App\Models\BoothBooking::query()
        ->with(['company', 'boothProfile'])
        ->where('exhibition_id', $booking->exhibition_id)
        ->where('id', '!=', $booking->id)
        ->where('payment_status', 'paid')
        ->whereIn('booking_status', ['confirmed', 'active'])
        ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
        ->take(3)
        ->get()
        ->map(function ($b) {
            $name = $b->boothProfile?->company_name ?: $b->company?->company_name ?: $b->company?->name ?: 'Exhibitor';
            return [
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ];
        })
        : collect();

    $ticketUrl = route('exhibitions.tickets.select', $slug);
    $logoUrl = $profile?->company_logo ? asset('storage/' . $profile->company_logo) : null;
@endphp

<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        @if (session('success'))
            <div class="mb-6 rounded-[14px] border border-emerald-100 bg-emerald-50/50 p-4 text-[14px] font-bold text-emerald-800 backdrop-blur-sm flex items-center gap-2">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-[14px] border border-rose-100 bg-rose-50/50 p-4 text-[14px] font-bold text-rose-800 backdrop-blur-sm flex items-center gap-2">
                <svg class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid gap-6 overflow-hidden rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_44px_rgba(7,16,68,0.08)] lg:grid-cols-[1fr_420px] lg:p-8">
            <div class="min-w-0">
                <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Company booth</p>
                <h1 class="mt-3 text-[38px] font-bold tracking-[-0.03em] text-[#071044] sm:text-[52px]">{{ $company }}</h1>
                <p class="mt-4 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">
                    {{ $profile?->tagline ?: $profile?->about_company ?: 'Visit this company booth to explore products, documents, media, demos, meeting slots and live interactions with the exhibitor team.' }}
                </p>
                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    @foreach ([[$products->count(), 'Products'], [$documents->count() + $catalogues->count(), 'Files'], [match ($booking?->booth_setup_status ?? 'published') { 'pending_review', 'submitted_for_review' => 'Pending Review', 'setup_in_progress', 'ready_to_publish', 'in_progress' => 'In Progress', default => 'Live' }, 'Booth status']] as [$value, $label])
                        <div class="rounded-[12px] bg-[#FBFAFF] p-4">
                            <p class="text-[22px] font-bold text-[#071044]">{{ $value }}</p>
                            <p class="mt-1 text-[13px] font-medium text-[#5A6480]">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($isPassActive)
                        <a href="#meeting" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-bold text-white">Book Meeting</a>
                        <a href="#chat" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#071044] hover:bg-[#F8F7FF]">Live Chat</a>
                    @else
                        <a href="{{ $ticketUrl }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-bold text-white">Register / Get Pass</a>
                        <span class="inline-flex min-h-11 items-center rounded-lg border border-[#EADCFD] bg-[#FBFAFF] px-5 text-[13px] font-bold text-[#5b2eff]">{{ $lockMessage }}</span>
                    @endif
                    <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#071044] hover:bg-[#F8F7FF]">Explore Companies</a>
                </div>
            </div>
            <div class="rounded-[18px] bg-gradient-to-br from-[#071044] to-[#5b2eff] p-6 text-white">
                <div class="grid h-16 w-16 place-items-center overflow-hidden rounded-2xl bg-white/15 text-[28px] font-bold">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $company }}" class="h-full w-full object-cover">
                    @else
                        {{ substr($company, 0, 1) }}
                    @endif
                </div>
                <h2 class="mt-5 text-[22px] font-bold">{{ $teamMembers->first()?->name ?: 'Business desk' }}</h2>
                <p class="mt-3 text-[14px] font-medium leading-6 text-white/76">{{ $teamMembers->first()?->designation ?: 'Sales Desk' }} | {{ $profile?->email ?: $teamMembers->first()?->email ?: 'booth@company.com' }} | {{ $profile?->phone ?: $teamMembers->first()?->phone ?: '+91 98765 43210' }}</p>
                <a href="{{ $isPassActive ? '#chat' : $ticketUrl }}" class="mt-5 inline-flex h-11 items-center justify-center rounded-lg bg-white px-5 text-[13px] font-bold text-[#5b2eff]">{{ $isPassActive ? 'Start Chat' : 'Get Pass to Chat' }}</a>
            </div>
        </div>

        <div class="mt-7 grid gap-6 lg:grid-cols-[1fr_390px]">
            <div class="space-y-6">
                <section class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <h2 class="text-[22px] font-bold text-[#071044]">About company</h2>
                    <p class="mt-3 text-[14px] font-medium leading-7 text-[#5A6480] break-words whitespace-pre-line">{{ $profile?->about_company ?: 'A trusted exhibitor presenting enterprise-ready products for visitor engagement, analytics, automation, and business operations.' }}</p>
                </section>

                <section class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <h2 class="text-[22px] font-bold text-[#071044]">Products</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-3">
                        @forelse ($products as $product)
                            <div class="rounded-[12px] border border-[#E7EAF3] bg-[#FBFAFF] p-4 flex flex-col justify-between">
                                <div>
                                    <div class="h-24 overflow-hidden rounded-lg bg-gradient-to-br from-[#F4F0FF] to-white">
                                        @if ($product->product_image)
                                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <h3 class="mt-4 text-[15px] font-bold text-[#071044]">{{ $product->name }}</h3>
                                    <p class="mt-2 text-[13px] font-medium leading-5 text-[#5A6480] line-clamp-3">{{ $product->short_description ?: 'Product overview, demo, and business use cases.' }}</p>
                                </div>
                                <button type="button"
                                    @if ($isPassActive)
                                        onclick="openVideoModal('{{ $demoVideoUrl }}', '{{ addslashes($product->name) }} Demo')"
                                    @endif
                                    class="mt-4 h-10 w-full rounded-lg {{ $isPassActive ? 'bg-[#F4F0FF] text-[#5b2eff] hover:bg-[#EADCFD] transition-colors cursor-pointer' : 'border border-[#EADCFD] bg-[#FBFAFF] text-[#7A648E]' }} text-[12px] font-bold">
                                    {{ $isPassActive ? 'Watch Demo' : $lockMessage }}
                                </button>
                            </div>
                        @empty
                            <div class="col-span-full py-8 text-center text-[14px] font-semibold text-[#5A6480]">No products published yet.</div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="text-[22px] font-bold text-[#071044]">Visitor decision</h2>
                            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">Like this company? Save it, book a meeting, join sessions, download brochures, or get a pass to unlock premium access.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @if ($isPassActive)
                                <button type="button" id="save-booth-btn" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#F4F0FF] px-5 text-[13px] font-bold text-[#5b2eff] hover:bg-[#EADCFD] transition-colors duration-250">Save Booth</button>
                                <a href="#meeting" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[13px] font-bold text-white hover:shadow-md transition-all duration-200">Book Meeting</a>
                            @else
                                <a href="{{ $ticketUrl }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#F4F0FF] px-5 text-[13px] font-bold text-[#5b2eff] hover:bg-[#EADCFD] transition-colors">Get Pass</a>
                                <a href="{{ $ticketUrl }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[13px] font-bold text-white hover:shadow-md transition-all duration-200">Unlock Visitor Tools</a>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="grid gap-6 md:grid-cols-2">
                    <div class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                        <h2 class="text-[20px] font-bold text-[#071044]">Documents</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($documents as $document)
                                <div class="flex items-center justify-between rounded-lg bg-[#FBFAFF] p-3">
                                    <span class="min-w-0 truncate pr-3 text-[13px] font-bold text-[#34405F]">{{ $document->title }}</span>
                                    <a href="{{ $isPassActive ? asset('storage/' . $document->file_path) : $ticketUrl }}" target="{{ $isPassActive ? '_blank' : '_self' }}" class="shrink-0 text-[12px] font-bold {{ $isPassActive ? 'text-[#5b2eff]' : 'text-[#7A648E]' }} hover:underline">{{ $isPassActive ? 'Download' : 'Locked' }}</a>
                                </div>
                            @empty
                                <p class="text-[13px] font-medium text-[#5A6480] text-center py-2">No documents uploaded.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                        <h2 class="text-[20px] font-bold text-[#071044]">Catalogues</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($catalogues as $catalogue)
                                <div class="flex items-center justify-between rounded-lg bg-[#FBFAFF] p-3">
                                    <span class="min-w-0 truncate pr-3 text-[13px] font-bold text-[#34405F]">{{ $catalogue->title }}</span>
                                    <a href="{{ $isPassActive ? asset('storage/' . $catalogue->file_path) : $ticketUrl }}" target="{{ $isPassActive ? '_blank' : '_self' }}" class="shrink-0 text-[12px] font-bold {{ $isPassActive ? 'text-[#5b2eff]' : 'text-[#7A648E]' }} hover:underline">{{ $isPassActive ? 'Open' : 'Locked' }}</a>
                                </div>
                            @empty
                                <p class="text-[13px] font-medium text-[#5A6480] text-center py-2">No catalogues uploaded.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <h2 class="text-[22px] font-bold text-[#071044]">Media gallery</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-3">
                        @forelse ($mediaItems as $media)
                            @php
                                $isVid = ($media->type === 'video' || !empty($media->video_url));
                                $fallback = $isVid 
                                    ? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=400&q=80' 
                                    : 'https://images.unsplash.com/photo-1542744094-3a31f103e35f?auto=format&fit=crop&w=400&q=80';
                                $mediaThumb = $media->thumbnail 
                                    ? asset('storage/' . $media->thumbnail) 
                                    : (($media->type === 'image' && $media->file_path) ? asset('storage/' . $media->file_path) : $fallback);
                                $mediaUrl = $media->file_path ? asset('storage/' . $media->file_path) : ($media->video_url ?: '#');
                                
                                // Determine if the URL is an external website link
                                $isExternalWebpage = false;
                                if ($isVid && !empty($media->video_url)) {
                                    $url = $media->video_url;
                                    if (!str_contains($url, 'youtube.com') && !str_contains($url, 'youtu.be') && !str_contains($url, 'vimeo.com') && !str_contains($url, 'mov_bbb.mp4') && !str_ends_with(strtolower($url), '.mp4') && !str_ends_with(strtolower($url), '.webm') && !str_ends_with(strtolower($url), '.ogg')) {
                                        $isExternalWebpage = true;
                                    }
                                }
                            @endphp
                            @if ($isPassActive)
                                @if ($isExternalWebpage)
                                    <a href="{{ $mediaUrl }}" target="_blank" class="block rounded-[12px] bg-[#071044] p-4 text-white hover:opacity-90 transition-opacity">
                                @elseif ($isVid)
                                    <button type="button" onclick="openVideoModal('{{ $mediaUrl }}', '{{ addslashes($media->title) }}')" class="w-full text-left block rounded-[12px] bg-[#071044] p-4 text-white hover:opacity-90 transition-opacity">
                                @else
                                    <button type="button" onclick="openImageModal('{{ $mediaUrl }}', '{{ addslashes($media->title) }}')" class="w-full text-left block rounded-[12px] bg-[#071044] p-4 text-white hover:opacity-90 transition-opacity">
                                @endif
                            @else
                                <div class="rounded-[12px] bg-[#071044] p-4 text-white">
                            @endif
                                <div class="relative h-24 overflow-hidden rounded-lg bg-white/10">
                                    @if ($mediaThumb)
                                        <img src="{{ $mediaThumb }}" alt="{{ $media->title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="grid h-full w-full place-items-center bg-white/5 text-white/40 text-[12px] font-bold">
                                            {{ ($media->type ?? $media->media_type) === 'video' || $media->video_url ? 'Video' : 'Image' }}
                                        </div>
                                    @endif
                                    @if ($media->type === 'video' || $media->video_url)
                                        <div class="absolute inset-0 grid place-items-center bg-black/30">
                                            <div class="grid h-8 w-8 place-items-center rounded-full bg-white/80 text-[#071044]">
                                                <svg class="ml-0.5 h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-3 truncate text-[13px] font-bold" title="{{ $media->title }}">{{ $media->title }}</p>
                                <p class="mt-2 text-[12px] font-medium text-white/68">
                                    {{ $isPassActive ? (($media->type === 'video' || $media->video_url) ? 'Watch Video' : 'View Image') : 'Pass required' }}
                                </p>
                            @if ($isPassActive)
                                @if ($isExternalWebpage)
                                    </a>
                                @else
                                    </button>
                                @endif
                            @else
                                </div>
                            @endif
                        @empty
                            <div class="col-span-full py-8 text-center text-[14px] font-semibold text-[#5A6480]">No media items uploaded.</div>
                        @endforelse
                    </div>
                </section>
            </div>

            <aside class="space-y-6">
                <div class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <h2 class="text-[20px] font-bold text-[#071044]">Conference section</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($sessions->take(4) as $session)
                            <div class="rounded-lg bg-[#FBFAFF] p-3">
                                <p class="text-[12px] font-bold text-[#5b2eff]">{{ optional($session->session_date)->format('M d') }} | {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') : '' }}</p>
                                <p class="mt-1 text-[13px] font-medium text-[#34405F]">{{ $session->title }}</p>
                                <button class="mt-3 text-[12px] font-bold {{ $isPassActive ? 'text-[#5b2eff]' : 'text-[#7A648E]' }}">{{ $isPassActive ? 'Join Session' : 'Pass Required' }}</button>
                            </div>
                        @empty
                            <p class="text-[13px] font-medium text-[#5A6480] text-center py-2">No sessions scheduled.</p>
                        @endforelse
                    </div>
                </div>

                @if ($teamMembers->isNotEmpty())
                    <div class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                        <h2 class="text-[20px] font-bold text-[#071044]">Team</h2>
                        <div class="mt-4 space-y-3">
                            @foreach ($teamMembers->take(4) as $member)
                                <div class="flex items-center gap-3 rounded-lg bg-[#FBFAFF] p-3">
                                    <div class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-lg bg-[#F4F0FF] text-[13px] font-bold text-[#5b2eff]">
                                        @if ($member->photo)
                                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ substr($member->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-[13px] font-bold text-[#34405F]">{{ $member->name }}</p>
                                        <p class="truncate text-[12px] font-medium text-[#5A6480]">{{ $member->designation }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    <h2 class="text-[20px] font-bold text-[#071044]">Next booths</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($nextBooths as $nb)
                            <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $nb['slug']]) }}" class="flex items-center justify-between rounded-lg bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#34405F] hover:bg-[#F4F0FF] hover:text-[#5b2eff] transition-colors">
                                <span>{{ $nb['name'] }}</span>
                                <span>Open</span>
                            </a>
                        @empty
                            <p class="text-[13px] font-medium text-[#5A6480] text-center py-2">No other booths registered.</p>
                        @endforelse
                    </div>
                </div>

                <form id="enquiry" action="{{ route('exhibitions.visitor.enquiry.send', [$slug, $companySlug]) }}" method="POST" class="rounded-[16px] border border-[#E7EAF3] bg-white p-6">
                    @csrf
                    <h2 class="text-[20px] font-bold text-[#071044]">Send enquiry</h2>
                    <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">Ask the exhibitor team about products, pricing, demos and availability.</p>
                    @unless ($isPassActive)
                        <p class="mt-3 rounded-lg border border-[#EADCFD] bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#5b2eff]">{{ $lockMessage }}</p>
                    @endunless
                    @php
                        $userFullName = auth()->check() ? (auth()->user()->first_name ? auth()->user()->first_name . ' ' . auth()->user()->last_name : auth()->user()->name) : '';
                        $userEmail = auth()->check() ? auth()->user()->email : '';
                    @endphp
                    <input type="text" name="name" value="{{ $userFullName }}" placeholder="Your name" class="mt-4 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
                    <input type="email" name="email" value="{{ $userEmail }}" placeholder="Your email" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
                    <input type="text" name="subject" placeholder="Subject" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
                    <textarea name="message" placeholder="Your message" class="mt-3 min-h-[100px] w-full rounded-lg border border-[#E7EAF3] p-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}></textarea>
                    
                    <button type="submit" class="mt-4 h-11 w-full rounded-lg {{ $isPassActive ? 'bg-[#5b2eff] text-white hover:bg-[#4310d8]' : 'bg-[#F4F0FF] text-[#5b2eff]' }} text-[14px] font-bold" {{ $isPassActive ? '' : 'disabled' }}>
                        {{ $isPassActive ? 'Send Enquiry' : 'Register / Get Pass' }}
                    </button>
                </form>

                <form id="meeting" action="{{ route('exhibitions.visitor.meetings.book', [$slug, $companySlug]) }}" method="POST" class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                    @csrf
                    <h2 class="text-[20px] font-bold text-[#071044]">Book meeting</h2>
                    @unless ($isPassActive)
                        <p class="mt-3 rounded-lg border border-[#EADCFD] bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#5b2eff]">{{ $lockMessage }}</p>
                    @endunless
                    <input type="text" name="visitor_name" value="{{ $userFullName }}" placeholder="Your name" class="mt-4 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
                    <input type="email" name="visitor_email" value="{{ $userEmail }}" placeholder="Email" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
                    @if ($companyMeetings->isNotEmpty())
                        <select name="company_meeting_id" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
                            @foreach ($companyMeetings->take(8) as $meeting)
                                <option value="{{ $meeting->id }}">{{ optional($meeting->start_time)->format('M d | H:i') }} - {{ optional($meeting->end_time)->format('H:i') }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="preferred_time" placeholder="Preferred time (No slots available)" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" disabled>
                        <input type="hidden" name="company_meeting_id" value="">
                    @endif
                    <textarea name="message" placeholder="Meeting note" class="mt-3 min-h-[120px] w-full rounded-lg border border-[#E7EAF3] p-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? '' : 'disabled' }}></textarea>
                    <button type="submit" class="mt-4 h-11 w-full rounded-lg {{ $isPassActive ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white hover:shadow-lg' : 'bg-[#F4F0FF] text-[#5b2eff]' }} text-[14px] font-bold" {{ $isPassActive && $companyMeetings->isNotEmpty() ? '' : 'disabled' }}>{{ $isPassActive ? 'Request Meeting' : 'Register / Get Pass' }}</button>
                </form>
            </aside>
        </div>
    </div>
</section>

<!-- Video Player Modal -->
<div id="media-video-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="relative w-full max-w-[800px] rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-[#E7EAF3] pb-4">
            <h3 id="media-video-title" class="text-[18px] font-bold text-[#071044] truncate pr-4">Video Player</h3>
            <button onclick="closeMediaVideoModal()" class="grid h-8 w-8 place-items-center rounded-full bg-[#F4F0FF] text-[#5b2eff] hover:bg-[#EADCFD] transition-colors shrink-0">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div id="media-video-container" class="mt-4 overflow-hidden rounded-xl bg-black flex justify-center items-center">
            <!-- Video/iframe will be injected here -->
        </div>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div id="media-image-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="relative w-full max-w-[800px] rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-[#E7EAF3] pb-4">
            <h3 id="media-image-title" class="text-[18px] font-bold text-[#071044] truncate pr-4">Image Viewer</h3>
            <button onclick="closeMediaImageModal()" class="grid h-8 w-8 place-items-center rounded-full bg-[#F4F0FF] text-[#5b2eff] hover:bg-[#EADCFD] transition-colors shrink-0">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mt-4 flex justify-center overflow-hidden rounded-xl bg-[#FBFAFF] p-2">
            <img id="media-image-display" src="" alt="View Image" class="max-h-[70vh] object-contain rounded-lg">
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('exhibition-api.js') }}"></script>
<script>
    // Video Player Modal handlers
    function openVideoModal(url, title) {
        const modal = document.getElementById('media-video-modal');
        const modalTitle = document.getElementById('media-video-title');
        const container = document.getElementById('media-video-container');
        
        if (!modal || !container) return;

        modalTitle.textContent = title || 'Video Player';
        
        let html = '';
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let videoId = '';
            if (url.includes('youtu.be/')) {
                videoId = url.split('youtu.be/')[1].split(/[?#]/)[0];
            } else if (url.includes('v=')) {
                videoId = url.split('v=')[1].split('&')[0];
            } else if (url.includes('/embed/')) {
                videoId = url.split('/embed/')[1].split(/[?#]/)[0];
            }
            html = `<iframe class="w-full aspect-video rounded-lg" style="height: 450px;" src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        } else if (url.includes('vimeo.com')) {
            let videoId = url.split('vimeo.com/')[1].split(/[?#]/)[0];
            html = `<iframe class="w-full aspect-video rounded-lg" style="height: 450px;" src="https://player.vimeo.com/video/${videoId}?autoplay=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
        } else if (url.endsWith('.mp4') || url.endsWith('.webm') || url.endsWith('.ogg') || url.includes('mov_bbb.mp4')) {
            html = `<video class="w-full rounded-lg" style="max-height: 450px;" controls autoplay><source src="${url}">Your browser does not support the video tag.</video>`;
        } else {
            // Sample video with external link fallback
            html = `
                <div class="flex flex-col items-center justify-center p-6 bg-white w-full">
                    <video class="w-full rounded-lg mb-4" style="max-height: 350px;" controls autoplay><source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"></video>
                    <p class="text-[14px] font-medium text-[#5A6480] text-center mb-4">Playing product overview. You can also view the external resource directly:</p>
                    <a href="${url}" target="_blank" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#5b2eff] px-6 text-[14px] font-bold text-white hover:bg-[#4310d8] transition-colors shadow-sm">Visit Website <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i></a>
                </div>
            `;
        }
        
        container.innerHTML = html;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMediaVideoModal() {
        const modal = document.getElementById('media-video-modal');
        const container = document.getElementById('media-video-container');
        if (modal) modal.classList.add('hidden');
        if (container) container.innerHTML = '';
        document.body.classList.remove('overflow-hidden');
    }

    // Image Lightbox Modal handlers
    function openImageModal(url, title) {
        const modal = document.getElementById('media-image-modal');
        const modalTitle = document.getElementById('media-image-title');
        const imgElement = document.getElementById('media-image-display');
        
        if (!modal || !imgElement) return;

        modalTitle.textContent = title || 'Image Viewer';
        imgElement.src = url;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMediaImageModal() {
        const modal = document.getElementById('media-image-modal');
        const imgElement = document.getElementById('media-image-display');
        if (modal) modal.classList.add('hidden');
        if (imgElement) imgElement.src = '';
        document.body.classList.remove('overflow-hidden');
    }

    // Close modals on clicking backdrop
    document.addEventListener('DOMContentLoaded', () => {
        const videoModal = document.getElementById('media-video-modal');
        if (videoModal) {
            videoModal.addEventListener('click', function(e) {
                if (e.target === this) closeMediaVideoModal();
            });
        }
        
        const imageModal = document.getElementById('media-image-modal');
        if (imageModal) {
            imageModal.addEventListener('click', function(e) {
                if (e.target === this) closeMediaImageModal();
            });
        }

        // Bookmark (Save Booth) handling logic
        const saveBoothBtn = document.getElementById('save-booth-btn');
        const bookingId = localStorage.getItem('lastBookingId') || '{{ $visitorBookingId ?? '' }}';
        const targetId = 'booking-{{ $booking->id ?? '' }}';

        if (saveBoothBtn && bookingId && targetId !== 'booking-') {
            let isBookmarked = false;

            // Load initial bookmark state
            ExhibitionAPI.getBookmarks(bookingId).then(bookmarks => {
                isBookmarked = bookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == targetId);
                updateBtnUI(isBookmarked);
            }).catch(err => {
                console.error('Error fetching bookmark state:', err);
            });

            // Toggle bookmark on click
            saveBoothBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                saveBoothBtn.disabled = true;
                try {
                    const res = await ExhibitionAPI.toggleBookmark(bookingId, 'exhibitor', targetId);
                    if (res) {
                        isBookmarked = res.status === 'added';
                        updateBtnUI(isBookmarked);
                    }
                } catch (err) {
                    console.error('Error toggling bookmark:', err);
                } finally {
                    saveBoothBtn.disabled = false;
                }
            });

            function updateBtnUI(saved) {
                if (saved) {
                    saveBoothBtn.textContent = 'Saved';
                    saveBoothBtn.className = 'inline-flex h-11 items-center justify-center rounded-lg bg-emerald-50 border border-emerald-100 px-5 text-[13px] font-bold text-emerald-700 transition-colors duration-250';
                } else {
                    saveBoothBtn.textContent = 'Save Booth';
                    saveBoothBtn.className = 'inline-flex h-11 items-center justify-center rounded-lg bg-[#F4F0FF] px-5 text-[13px] font-bold text-[#5b2eff] hover:bg-[#EADCFD] transition-colors duration-250';
                }
            }
        }
    });
</script>
@endpush
@endsection
