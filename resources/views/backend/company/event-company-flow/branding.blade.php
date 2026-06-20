@extends('layouts.company-event')

@section('title', 'Event Branding | eproexpo')

@section('content')
@php
    $primaryColor = old('primary_color', $eventBranding->primary_color ?? '#4C10D0');
    $secondaryColor = old('secondary_color', $eventBranding->secondary_color ?? '#00B894');
    $accentColor = old('accent_color', $eventBranding->accent_color ?? '#FF8A00');
    $textColor = '#0F172A';
    $eventTitle = $companyEvent->title ?: 'Untitled Company Event';
    $eventHeadline = old('headline', $eventBranding->headline ?? $eventTitle);
    $eventTagline = old('tagline', $eventBranding->tagline ?? '');
    $ctaLabel = old('cta_label', $eventBranding->cta_label ?? 'Explore Event');
    $eventSummary = $companyEvent->summary ?: $companyEvent->description ?: 'Add an event summary in Basic Details.';
    $eventLocation = collect([$companyEvent->venue_name, $companyEvent->city, $companyEvent->country])->filter()->join(', ') ?: 'Location TBD';
    $eventVenueName = $companyEvent->venue_name ?: 'Venue TBD';
    $eventDate = $companyEvent->starts_at
        ? $companyEvent->starts_at->format('M d') . ($companyEvent->ends_at ? ' - ' . $companyEvent->ends_at->format('d, Y') : ', ' . $companyEvent->starts_at->format('Y'))
        : 'Date TBD';
    $eventDays = $companyEvent->starts_at && $companyEvent->ends_at ? max(1, $companyEvent->starts_at->copy()->startOfDay()->diffInDays($companyEvent->ends_at->copy()->startOfDay()) + 1) : 1;
    $ticketCapacity = (int) ($ticketTypes ?? collect())->sum('quantity_total');
    $eventCapacityValue = (int) ($companyEvent->capacity ?: $ticketCapacity);
    $eventCapacity = $eventCapacityValue > 0 ? number_format($eventCapacityValue) . '+' : '0';
    $speakerCount = ($eventSpeakers ?? collect())->count();
    $speakerDisplay = $speakerCount > 0 ? number_format($speakerCount) . '+' : '0';
    $eventInitials = collect(preg_split('/\s+/', trim($eventTitle)))->filter()->take(3)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('') ?: 'EVT';
    $eventYear = $companyEvent->starts_at?->format('Y') ?? now()->format('Y');
    $logoUrl = $eventBranding?->logo_path ? asset('storage/' . $eventBranding->logo_path) : null;
    $bannerUrl = $eventBranding?->banner_path ? asset('storage/' . $eventBranding->banner_path) : null;
    $bannerLabelLines = collect(preg_split('/\s+/', strtoupper($eventTitle)))->filter();
@endphp

<form method="POST" action="{{ route('company.event-company-flow.branding.update', $companyEvent) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="action" value="continue">
    <input type="hidden" name="primary_color" value="{{ $primaryColor }}">
    <input type="hidden" name="secondary_color" value="{{ $secondaryColor }}">
    <input type="hidden" name="accent_color" value="{{ $accentColor }}">

    <div class="px-4 sm:px-6 md:px-10 py-8 max-w-[1250px]">
        <div class="mb-10">
            <h1 class="text-[24px] font-bold tracking-tight text-[#1C1364] mb-1">Event Branding</h1>
            <p class="text-[14px] text-[#5B6B8A]">Customize how your event looks across the platform.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[380px_1fr] gap-10">
            <div class="flex flex-col gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Event Logo</h3>
                        <div class="border border-gray-200 rounded-[12px] p-4 flex flex-col items-center justify-center mb-3 h-[120px] bg-white">
                            <div id="logo-preview-box" class="w-14 h-14 bg-[#F4F1FF] rounded-lg flex items-center justify-center text-[#4C10D0] font-bold text-[15px] text-center leading-tight overflow-hidden">
                                @if ($logoUrl)
                                    <img src="{{ $logoUrl }}" alt="{{ $eventTitle }} logo" class="w-full h-full object-contain">
                                @else
                                    <span id="logo-preview-text">{{ $eventInitials }}<br>{{ $eventYear }}</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-[11px] text-center text-gray-400 font-medium mb-3">PNG, JPG (Max 2MB)</p>
                        <input type="file" id="logo-file-input" name="logo" class="hidden" accept="image/*">
                        <button type="button" id="logo-upload-btn" class="w-full py-2 border border-[#5B32F6] text-[#5B32F6] text-[13px] font-semibold rounded-[8px] hover:bg-[#F4F1FF] transition-colors">Upload Logo</button>
                    </div>

                    <div>
                        <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Brand Colors</h3>
                        <div class="flex flex-col gap-[14px]">
                            <div class="flex items-center justify-between">
                                <span class="text-[12px] text-gray-600 font-medium">Primary Color</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-[22px] h-[22px] rounded" style="background-color: {{ $primaryColor }}"></div>
                                    <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">{{ strtoupper($primaryColor) }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[12px] text-gray-600 font-medium">Secondary Color</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-[22px] h-[22px] rounded" style="background-color: {{ $secondaryColor }}"></div>
                                    <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">{{ strtoupper($secondaryColor) }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[12px] text-gray-600 font-medium">Accent Color</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-[22px] h-[22px] rounded" style="background-color: {{ $accentColor }}"></div>
                                    <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">{{ strtoupper($accentColor) }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[12px] text-gray-600 font-medium">Text Color</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-[22px] h-[22px] rounded" style="background-color: {{ $textColor }}"></div>
                                    <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">{{ $textColor }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-2">
                    <div>
                        <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Banner Image</h3>
                        <div id="banner-preview-box" class="border border-gray-200 rounded-[12px] overflow-hidden mb-3 h-[85px] bg-[#1A0A4A] relative flex items-center shadow-sm bg-cover bg-center" @if ($bannerUrl) style="background-image: url('{{ $bannerUrl }}')" @endif>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#4C10D0]/80 to-[#2c0980]/50"></div>
                            <span class="relative text-white font-bold text-[10px] leading-[1.2] pl-3">
                                @foreach ($bannerLabelLines as $line)
                                    {{ $line }}@if (! $loop->last)<br>@endif
                                @endforeach
                            </span>
                        </div>
                        <p class="text-[11px] text-center text-gray-400 font-medium mb-3">PNG, JPG (Recommended 1920x640)</p>
                        <input type="file" id="banner-file-input" name="banner" class="hidden" accept="image/*">
                        <button type="button" id="banner-upload-btn" class="w-full py-2 border border-[#5B32F6] text-[#5B32F6] text-[13px] font-semibold rounded-[8px] hover:bg-[#F4F1FF] transition-colors">Change Banner</button>
                    </div>

                    <div>
                        <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Theme Sections</h3>
                        <div class="flex flex-col gap-[10px] mt-1">
                            @foreach (['Header & Banner', 'Event Details', 'Sponsors', 'Footer'] as $section)
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">{{ $section }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Preview Content</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="block">
                            <span class="text-[12px] text-gray-600 font-medium">Headline</span>
                            <input id="headline-input" name="headline" type="text" value="{{ $eventHeadline }}" class="mt-1.5 w-full rounded-lg border border-gray-200 px-3 py-2 text-[13px] font-medium text-[#1C1364] outline-none focus:border-[#5B32F6]">
                        </label>
                        <label class="block">
                            <span class="text-[12px] text-gray-600 font-medium">Tagline</span>
                            <input id="tagline-input" name="tagline" type="text" value="{{ $eventTagline }}" class="mt-1.5 w-full rounded-lg border border-gray-200 px-3 py-2 text-[13px] font-medium text-[#1C1364] outline-none focus:border-[#5B32F6]">
                        </label>
                        <label class="block">
                            <span class="text-[12px] text-gray-600 font-medium">Button Label</span>
                            <input id="cta-label-input" name="cta_label" type="text" value="{{ $ctaLabel }}" class="mt-1.5 w-full rounded-lg border border-gray-200 px-3 py-2 text-[13px] font-medium text-[#1C1364] outline-none focus:border-[#5B32F6]">
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="border border-gray-100 rounded-xl p-4 flex items-center justify-between bg-white shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                        <div class="flex flex-col gap-2">
                            <span class="text-[12px] font-bold text-[#1C1364]">Text</span>
                            <span class="text-[15px] text-[#1C1364] font-medium">Aa</span>
                        </div>
                        <span class="text-[14px] font-bold text-[#1C1364] self-end mb-0.5">16</span>
                    </div>
                    <div class="border border-gray-100 rounded-xl p-4 flex items-center justify-between bg-white shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                        <div class="flex flex-col gap-2">
                            <span class="text-[12px] font-bold text-[#1C1364]">Buttons</span>
                            <div class="w-10 h-8 bg-[#4C10D0] rounded flex items-center justify-center text-white text-[13px] font-medium">Aa</div>
                        </div>
                        <span class="text-[14px] font-bold text-[#1C1364] self-end mb-0.5">32</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col min-w-0">
                <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Live Preview</h3>
                <div class="border border-gray-200 rounded-[16px] overflow-hidden shadow-[0_2px_12px_rgba(0,0,0,0.03)] bg-white h-full flex flex-col min-w-0">
                    <div id="live-banner-preview" class="relative bg-[#1A0A4A] min-h-[260px] sm:h-[260px] px-6 py-6 sm:px-8 sm:py-8 flex flex-col justify-between overflow-hidden shrink-0 bg-cover bg-center" @if ($bannerUrl) style="background-image: url('{{ $bannerUrl }}')" @endif>
                        <div class="absolute inset-0 opacity-50">
                            <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 100 100">
                                <path d="M-10,60 Q40,30 110,80" fill="none" stroke="#A78BFA" stroke-width="0.3"/>
                                <path d="M-10,80 Q50,0 110,60" fill="none" stroke="#A78BFA" stroke-width="0.1"/>
                                <line x1="30" y1="0" x2="70" y2="100" stroke="#A78BFA" stroke-width="0.1"/>
                                <line x1="70" y1="0" x2="30" y2="100" stroke="#A78BFA" stroke-width="0.1"/>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#1A0A4A] to-transparent"></div>
                        </div>

                        <div class="relative z-10 text-white flex flex-col h-full">
                            <div id="live-logo-preview" class="font-bold text-[18px] leading-tight mb-auto">
                                @if ($logoUrl)
                                    <img src="{{ $logoUrl }}" alt="{{ $eventTitle }} logo" class="w-12 h-12 object-contain rounded-md bg-white p-1 shadow-sm">
                                @else
                                    <span id="live-logo-text">{{ $eventInitials }}<br>{{ $eventYear }}</span>
                                @endif
                            </div>
                            <div class="mt-auto">
                                <h2 id="live-headline-preview" class="text-[20px] min-[400px]:text-[24px] sm:text-[28px] font-bold leading-tight mb-2 tracking-wide">{{ str($eventHeadline)->upper() }}</h2>
                                <p class="text-[13px] text-gray-200 mb-5 font-medium">{{ $eventDate }} | {{ $companyEvent->city ?: $eventLocation }}</p>
                                @if ($eventTagline)
                                    <p id="live-tagline-preview" class="mb-4 max-w-[520px] text-[12px] font-medium text-gray-200">{{ $eventTagline }}</p>
                                @else
                                    <p id="live-tagline-preview" class="mb-4 hidden max-w-[520px] text-[12px] font-medium text-gray-200"></p>
                                @endif
                                <button id="live-cta-preview" type="button" style="background-color: {{ $primaryColor }}; color: #FFFFFF;" class="px-6 py-2.5 rounded-[6px] text-[13px] font-semibold transition-opacity hover:opacity-90 border-none shadow-sm">{{ $ctaLabel }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 flex-1 min-w-0">
                        <h3 class="text-[15px] font-bold mb-3" style="color: {{ $primaryColor }}">About the Event</h3>
                        <p class="text-[13px] text-[#5B6B8A] leading-relaxed mb-8">{{ $eventSummary }}</p>

                        <h3 class="text-[15px] font-bold mb-5" style="color: {{ $primaryColor }}">Event Highlights</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
                            <div class="flex items-start gap-3 min-w-0">
                                <svg class="shrink-0 mt-0.5" style="color: {{ $primaryColor }}" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <div class="min-w-0 flex-1">
                                    <div class="text-[13px] font-bold text-[#1C1364] mb-0.5 truncate">{{ $eventDays }} {{ str('Day')->plural($eventDays) }}</div>
                                    <div class="text-[11px] text-[#5B6B8A] truncate">{{ $eventDate }}</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 border-gray-100 pl-0 sm:pl-4 sm:border-l min-w-0">
                                <svg class="shrink-0 mt-0.5" style="color: {{ $primaryColor }}" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <div class="min-w-0 flex-1">
                                    <div class="text-[13px] font-bold text-[#1C1364] mb-0.5 truncate" title="{{ $eventVenueName }}">{{ $eventVenueName }}</div>
                                    <div class="text-[11px] text-[#5B6B8A] truncate" title="{{ $eventLocation }}">{{ $eventLocation }}</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 border-gray-100 min-w-0 sm:border-none sm:pl-0 md:border-l md:pl-4 xl:border-none xl:pl-0 2xl:border-l 2xl:pl-4">
                                <svg class="shrink-0 mt-0.5" style="color: {{ $primaryColor }}" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <div class="min-w-0 flex-1">
                                    <div class="text-[13px] font-bold text-[#1C1364] mb-0.5 truncate">{{ $eventCapacity }}</div>
                                    <div class="text-[11px] text-[#5B6B8A] truncate">Expected Attendees</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-5 flex items-center justify-between shrink-0" style="background-color: {{ $primaryColor }}">
                        <span class="text-[12px] text-gray-200">&copy; {{ $eventYear }} {{ $eventTitle }}. All rights reserved.</span>
                        <div class="flex items-center gap-5 text-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-10">
            <a href="{{ route('company.event-company-flow.basic', $companyEvent) }}" class="px-8 py-3 border border-gray-200 text-[#1C1364] bg-white rounded-lg text-[14px] font-semibold hover:bg-gray-50 transition-colors shadow-sm inline-block">Back</a>
            <button id="save-branding-btn" type="submit" style="background-color: #5B32F6; color: #FFFFFF;" class="px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#4a26d1] transition-colors focus:outline-none">Save & Continue</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('logo-upload-btn')?.addEventListener('click', () => {
        document.getElementById('logo-file-input')?.click();
    });

    document.getElementById('banner-upload-btn')?.addEventListener('click', () => {
        document.getElementById('banner-file-input')?.click();
    });

    document.getElementById('logo-file-input')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (! file) return;

        const imageUrl = URL.createObjectURL(file);
        const logoBox = document.getElementById('logo-preview-box');
        const liveLogo = document.getElementById('live-logo-preview');

        if (logoBox) {
            logoBox.innerHTML = `<img src="${imageUrl}" alt="Logo preview" class="w-full h-full object-contain">`;
        }

        if (liveLogo) {
            liveLogo.innerHTML = `<img src="${imageUrl}" alt="Logo preview" class="w-12 h-12 object-contain rounded-md bg-white p-1 shadow-sm">`;
        }
    });

    document.getElementById('banner-file-input')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (! file) return;

        const imageUrl = URL.createObjectURL(file);
        const previewStyle = `url("${imageUrl}")`;
        const bannerBox = document.getElementById('banner-preview-box');
        const liveBanner = document.getElementById('live-banner-preview');

        if (bannerBox) bannerBox.style.backgroundImage = previewStyle;
        if (liveBanner) liveBanner.style.backgroundImage = previewStyle;
    });

    const bindTextPreview = (inputId, previewId, fallback = '', transform = (value) => value) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        if (! input || ! preview) return;

        input.addEventListener('input', () => {
            const value = input.value.trim() || fallback;
            preview.textContent = transform(value);
            preview.classList.toggle('hidden', value === '');
        });
    };

    bindTextPreview('headline-input', 'live-headline-preview', @js($eventTitle), (value) => value.toUpperCase());
    bindTextPreview('tagline-input', 'live-tagline-preview');
    bindTextPreview('cta-label-input', 'live-cta-preview', 'Explore Event');
</script>
@endpush
