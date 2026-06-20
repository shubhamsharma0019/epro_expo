@extends('layouts.company')

@section('title', 'Publish Booth | eproexpo')
@section('page-title', 'Publish Booth')

@section('content')
@php
    $readiness = $readiness ?? ['ready' => false, 'steps' => collect(), 'missing' => collect()];
    $stepsList = collect($readiness['steps'] ?? []);
    $missing = collect($readiness['missing'] ?? []);
    $summaryCounts = $summaryCounts ?? [];
    $availabilitySummary = $availabilitySummary ?? [];
    $profile = $booking->boothProfile;
    $branding = $booking->boothBranding;
    $companyName = $profile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?: 'Company booth';
    $boothLocation = 'Booth ' . ($booking->booth?->booth_number ?: 'N/A') . ' | ' . ($booking->hall?->title ?: 'Hall not assigned');
    $bannerUrl = $branding?->booth_banner
        ? asset('storage/' . $branding->booth_banner)
        : ($profile?->booth_banner ? asset('storage/' . $profile->booth_banner) : asset('assets/exhibition/images/booth_banner.png'));
    $publishStatus = $publishRequest?->status;
    $isLive = in_array($booking->booth_setup_status, ['published', 'approved', 'live'], true);
    $isSubmitted = $isLive;
    $readinessCopy = $isLive
        ? 'Your booth is live now.'
        : ($readiness['ready']
            ? 'Great! Your booth is ready to be activated.'
            : 'Complete the pending requirements before activating your booth.');
    $stepMeta = [
        'profile' => ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'copy' => 'Company information is complete.'],
        'branding' => ['icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343', 'copy' => 'Branding settings are applied.'],
        'products' => ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'copy' => ($summaryCounts['products'] ?? 0) . ' products added.'],
        'documents' => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586', 'copy' => ($summaryCounts['documents'] ?? 0) . ' documents uploaded.'],
        'catalogues' => ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13', 'copy' => ($summaryCounts['catalogues'] ?? 0) . ' catalogues uploaded.'],
        'media' => ['icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586', 'copy' => ($summaryCounts['media'] ?? 0) . ' media files added.'],
        'team' => ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z', 'copy' => ($summaryCounts['team'] ?? 0) . ' team members added.'],
        'meetings' => ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7', 'copy' => ($summaryCounts['meeting_slots'] ?? 0) . ' meeting slots available.'],
        'sessions' => ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764', 'copy' => ($summaryCounts['sessions'] ?? 0) . ' sessions created.'],
        'preview' => ['icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'copy' => 'Booth preview is ready.'],
        'publish' => ['icon' => 'M5 13l4 4L19 7', 'copy' => 'Activate booth and make it live.'],
    ];
    $stepLinks = [
        'profile' => route('company.booth-setup.profile.edit', $booking),
        'branding' => route('company.booth-setup.branding.edit', $booking),
        'products' => route('company.booth-setup.products.index', $booking),
        'documents' => route('company.booth-setup.documents.index', $booking),
        'catalogues' => route('company.booth-setup.catalogues.index', $booking),
        'media' => route('company.booth-setup.media.index', $booking),
        'team' => route('company.booth-setup.team-members.index', $booking),
        'meetings' => route('company.booth-setup.meetings.edit', $booking),
        'sessions' => route('company.booth-setup.sessions.index', $booking),
        'preview' => route('company.booth-setup.preview', $booking),
    ];
@endphp

<div class="p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-[1400px] mx-auto bg-white border border-gray-100 rounded-2xl p-5 shadow-sm lg:p-8">
        <div class="mb-8">
            <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Publish Booth</h1>
            <p class="text-[#6B7280] text-[15px]">Complete all requirements below before activating your booth.</p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ $errors->first('publish') ?: $errors->first() }}</div>
        @endif

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col h-full">
                <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Booth Readiness</h3>

                <div class="flex-1 space-y-4">
                    @foreach ($stepsList->reject(fn ($step) => $step->step_key === 'publish') as $step)
                        @php
                            $completed = $step->status === 'completed';
                            $meta = $stepMeta[$step->step_key] ?? ['icon' => 'M5 13l4 4L19 7', 'copy' => ucfirst(str_replace('_', ' ', $step->status))];
                        @endphp
                        <a href="{{ $stepLinks[$step->step_key] ?? '#' }}" class="flex items-center justify-between gap-4 pb-4 border-b border-gray-50">
                            <div class="flex items-center min-w-0">
                                <div class="w-8 h-8 rounded-full {{ $completed ? 'bg-[#10B981]' : 'bg-[#F59E0B]' }} flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $meta['icon'] }}"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-[#1E1B4B] font-bold text-[13px]">{{ $step->step_name }}</h4>
                                    <p class="text-[#6B7280] text-[12px]">{{ $meta['copy'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center {{ $completed ? 'text-[#10B981]' : 'text-[#F59E0B]' }}">
                                <span class="font-bold text-[13px] mr-1.5">{{ $completed ? 'Completed' : ucfirst(str_replace('_', ' ', $step->status)) }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="{{ $completed ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' : 'M8.257 3.099c.765-1.36 2.72-1.36 3.486 0l6.518 11.59c.75 1.334-.213 2.986-1.742 2.986H3.48c-1.53 0-2.492-1.652-1.743-2.986l6.52-11.59zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V8a1 1 0 112 0v3a1 1 0 01-1 1z' }}" clip-rule="evenodd"></path></svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="{{ $readiness['ready'] ? 'bg-[#ECFDF5] border-[#A7F3D0]' : 'bg-amber-50 border-amber-200' }} border rounded-lg p-4 mt-6 flex items-center">
                    <div class="{{ $readiness['ready'] ? 'bg-[#10B981]' : 'bg-[#F59E0B]' }} text-white rounded-full w-5 h-5 flex items-center justify-center mr-3 flex-shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $readiness['ready'] ? 'M5 13l4 4L19 7' : 'M12 9v3m0 4h.01' }}"></path></svg>
                    </div>
                    <span class="{{ $readiness['ready'] ? 'text-[#059669]' : 'text-[#B45309]' }} font-bold text-[14px]">{{ $readinessCopy }}</span>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col h-full">
                <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Booth Preview</h3>

                <div class="mb-5">
                    <img src="{{ $bannerUrl }}" alt="{{ $companyName }} booth preview" class="w-full h-[220px] object-cover rounded-lg">
                </div>

                <h4 class="text-[#1E1B4B] font-bold text-[16px] mb-1">{{ $companyName }}</h4>
                <p class="text-[#6B7280] text-[13px] mb-6">{{ $boothLocation }}</p>

                <div class="flex-1 space-y-0">
                    @foreach ([['Products', 'products'], ['Documents', 'documents'], ['Catalogues', 'catalogues'], ['Media', 'media'], ['Team Members', 'team'], ['Sessions', 'sessions']] as [$label, $key])
                        <div class="flex justify-between items-center py-3 {{ $loop->last ? '' : 'border-b border-gray-50' }}">
                            <span class="text-[#4B5563] text-[13px]">{{ $label }}</span>
                            <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                <span class="mr-2">{{ $summaryCounts[$key] ?? 0 }}</span>
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('company.booth-setup.preview', $booking) }}" class="w-full mt-6 py-2.5 border border-[#4C1D95] text-[#4C1D95] font-bold text-[14px] rounded-lg hover:bg-[#F5F3FF] transition-colors text-center">
                    View Preview
                </a>
            </div>

            <div class="col-span-12 lg:col-span-3 flex flex-col justify-between h-full">
                <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm mb-6">
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Publishing Tips</h3>
                    <ul class="space-y-3">
                        @foreach (['Ensure all information is accurate and up to date.', 'High-quality images and videos attract more visitors.', 'Add compelling product descriptions.', 'Configure meetings availability to receive requests.', 'Promote your live sessions for better engagement.'] as $tip)
                            <li class="flex items-start">
                                <span class="text-[#4C1D95] font-bold mr-2 text-[16px] leading-none mt-0.5">&bull;</span>
                                <span class="text-[#4B5563] text-[12px] leading-relaxed">{{ $tip }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Selected Summary</h3>

                    <div class="space-y-4 mb-4">
                        <div>
                            <p class="text-[#6B7280] text-[12px] mb-1">Dates</p>
                            <div class="flex justify-between items-center gap-3">
                                <span class="text-[#1E1B4B] text-[13px] font-medium">{{ $availabilitySummary['dates'] ?? 'Not configured' }}</span>
                                <span class="text-[#6B7280] text-[12px]">{{ $availabilitySummary['days'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[#6B7280] text-[12px] mb-1">Daily Slots</p>
                            <p class="text-[#1E1B4B] text-[13px] font-medium">{{ $availabilitySummary['daily_slots'] ?? 0 }} Slots</p>
                        </div>
                        <div>
                            <p class="text-[#6B7280] text-[12px] mb-1">Slot Duration</p>
                            <p class="text-[#1E1B4B] text-[13px] font-medium">{{ $availabilitySummary['slot_duration'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[#6B7280] text-[12px] mb-1">Total Availability</p>
                            <p class="text-[#1E1B4B] text-[13px] font-medium">{{ $availabilitySummary['total_availability'] ?? '-' }}</p>
                        </div>
                    </div>

                    <p class="text-[#6B7280] text-[11px]">All times in {{ $availabilitySummary['timezone'] ?? 'Asia/Kolkata' }}</p>
                </div>

                <div class="mt-6">
                    @if ($isSubmitted)
                        <a href="/company/dashboard" class="w-full bg-[#4C1D95] text-white py-4 rounded-xl font-bold text-[16px] flex items-center justify-center hover:bg-[#3b1774] transition-colors shadow-lg shadow-indigo-200">
                            View Dashboard
                        </a>
                    @else
                        <form method="POST" action="{{ route('company.booth-setup.publish.submit', $booking) }}">
                            @csrf
                            <button type="submit" @disabled(! $readiness['ready']) class="w-full {{ $readiness['ready'] ? 'bg-[#4C1D95] hover:bg-[#3b1774]' : 'bg-gray-300 cursor-not-allowed' }} text-white py-4 rounded-xl font-bold text-[16px] flex items-center justify-center transition-colors shadow-lg shadow-indigo-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349a5.259 5.259 0 00-1.542-3.717l-2.718-2.718a5.25 5.25 0 00-3.712-1.538H6.75A3.375 3.375 0 003.375 4.5v15"></path></svg>
                                Activate Booth
                            </button>
                        </form>
                    @endif
                    <p class="text-[#6B7280] text-[12px] text-center mt-3">
                        {{ $isSubmitted ? ($isLive ? 'Your booth is already live.' : 'Your booth has already been activated.') : 'Once activated, your booth will go live immediately.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
