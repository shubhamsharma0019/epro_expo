@extends('layouts.exhibition')

@section('title', 'Visitor Dashboard - EproExpo')

@section('content')
@php
    $slug = $slug ?? 'innovation-expo';
    
    // Resolve active visitor pass dynamically from database
    $exhibition = \App\Models\Exhibition::where('slug', $slug)->first();
    $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
    $visitor = null;
    if ($bookingId) {
        $visitor = \App\Models\Visitor::where('booking_id', $bookingId)->first();
    }
    if (!$visitor && auth()->check() && $exhibition) {
        $visitor = \App\Models\Visitor::where('exhibition_id', $exhibition->id)
            ->where('email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->first();
    }
    if (!$visitor && $exhibition) {
        $visitor = \App\Models\Visitor::where('exhibition_id', $exhibition->id)->orderBy('created_at', 'desc')->first();
    }
    
    $isPassActive = $visitor ? ($visitor->payment_status === 'completed') : false;
    $exhTitle = $exhibition ? ($exhibition->title ?: $exhibition->name) : 'Innovation Expo 2026';
    $passId = $visitor ? $visitor->booking_id : 'VIS-2026-1048';
    
    if ($exhibition && $exhibition->start_date && $exhibition->end_date) {
        $dateStr = $exhibition->start_date->format('M d') . ' - ' . $exhibition->end_date->format('d, Y');
    } else {
        $dateStr = 'June 12 - June 14, 2026';
    }
@endphp

<section class="max-w-[1550px] px-5 py-6 sm:px-8 lg:px-10 lg:py-8">
    <h1 class="mb-2 text-[34px] font-semibold leading-[40px] tracking-[-1px] text-[#071044] sm:text-[42px] sm:leading-[48px] lg:text-[50px] lg:leading-[56px] lg:tracking-[-1.5px]">
        Welcome back, {{ $visitor ? $visitor->first_name : 'John' }}!
    </h1>

    <p class="mb-8 text-[16px] leading-7 text-[#5A6480] sm:text-[18px]">
        Your visitor pass, saved booths, meetings and sessions are ready for the exhibition.
    </p>

    <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] p-7">
            <div class="mb-5 text-[16px] font-medium text-[#071044]">Active Visitor Pass</div>
            <div class="mb-2 text-[22px] font-semibold text-[#071044]">{{ $exhTitle }}</div>
            <div class="space-y-2 text-[16px] leading-5 text-[#5A6480]">
                <p>{{ $isPassActive ? 'Pass active' : 'Guest preview' }}</p>
                <p>Visitor ID: {{ $passId }}</p>
                <p>{{ $dateStr }}</p>
            </div>
        </div>

        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] p-7">
            <div class="mb-6 text-[16px] font-medium text-[#071044]">Saved Booths</div>
            <div class="text-[36px] font-semibold leading-none text-[#071044]">8</div>
        </div>

        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] p-7">
            <div class="mb-6 text-[16px] font-medium text-[#071044]">Meetings</div>
            <div class="text-[36px] font-semibold leading-none text-[#071044]">3</div>
        </div>

        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] p-7">
            <div class="mb-6 text-[16px] font-medium text-[#071044]">Sessions Joined</div>
            <div class="whitespace-nowrap text-[35px] font-semibold leading-none tracking-[-0.5px] text-[#071044] xl:text-[clamp(31px,2.4vw,35px)]">5</div>
        </div>
    </div>

    <div class="grid grid-cols-1 items-start gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="min-w-0">
            <h2 class="mb-4 text-[19px] font-semibold text-[#071044]">Quick Actions</h2>

            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="flex h-[48px] items-center justify-center gap-3 whitespace-nowrap rounded-md border border-[#E7EAF3] px-4 text-[13px] font-medium text-[#5b2eff] shadow-sm">
                    <i class="fa-solid fa-store text-[20px]"></i>
                    Explore Companies
                </a>

                <a href="{{ route('exhibitions.visitor.saved', $slug) }}" class="flex h-[48px] items-center justify-center gap-3 whitespace-nowrap rounded-md border border-[#E7EAF3] px-4 text-[13px] font-medium text-[#5b2eff] shadow-sm">
                    <i class="fa-regular fa-bookmark text-[20px]"></i>
                    Saved Booths
                </a>

                <a href="{{ route('exhibitions.visitor.meetings', $slug) }}" class="flex h-[48px] items-center justify-center gap-3 whitespace-nowrap rounded-md border border-[#E7EAF3] px-4 text-[13px] font-medium text-[#5b2eff] shadow-sm">
                    <i class="fa-regular fa-calendar-check text-[20px]"></i>
                    My Meetings
                </a>

                <a href="{{ route('exhibitions.visitor.qr-pass', $slug) }}" class="flex h-[48px] items-center justify-center gap-3 whitespace-nowrap rounded-md border border-[#E7EAF3] px-4 text-[13px] font-medium text-[#5b2eff] shadow-sm">
                    <i class="fa-solid fa-qrcode text-[20px]"></i>
                    QR Pass
                </a>
            </div>

            <h2 class="mb-4 text-[19px] font-semibold text-[#071044]">Recommended Companies</h2>

            @foreach ([['TechNova Solutions', 'Hall A - Booth A12', 'AI demo at 2:00 PM', 'Saved'], ['GreenLoop Energy', 'Hall B - Booth B04', 'Meeting slot available', 'Open']] as [$company, $location, $meta, $status])
                <div class="mb-4 flex min-h-[88px] flex-col items-start justify-between gap-4 rounded-md border border-[#E7EAF3] px-5 py-4 sm:px-6 lg:flex-row lg:items-center lg:gap-8">
                    <div class="min-w-0">
                        <h3 class="mb-3 text-[16px] font-medium text-[#071044]">{{ $company }}</h3>
                        <div class="flex flex-col gap-2 text-[13px] font-normal text-[#5A6480] sm:flex-row sm:flex-wrap sm:gap-x-8 lg:gap-x-16">
                            <span>{{ $location }}</span>
                            <span class="flex items-center gap-3">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $meta }}
                            </span>
                        </div>
                    </div>
                    <div class="shrink-0 rounded-md border border-[#C7F0D4] bg-[#EEFDF3] px-4 py-2 text-[12px] font-medium text-[#16A34A]">{{ $status }}</div>
                </div>
            @endforeach

            <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="mt-5 flex items-center gap-3 text-[14px] font-medium text-[#5b2eff]">
                View All Companies
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="min-w-0 space-y-5 xl:pt-0">
            <div class="rounded-lg border border-[#E7EAF3] p-6">
                <h2 class="mb-8 text-[19px] font-semibold text-[#071044]">Visitor Access</h2>
                <div class="space-y-8">
                    <div class="flex items-center justify-between text-[14px] text-[#071044]">
                        <span>Pass Status</span>
                        <span class="font-medium">{{ $isPassActive ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[14px] text-[#071044]">
                        <span>Unread Notifications</span>
                        <span class="font-medium">6</span>
                    </div>
                    <div class="flex items-center justify-between text-[14px] text-[#071044]">
                        <span>Protected Tools</span>
                        <span class="font-medium">{{ $isPassActive ? 'Unlocked' : 'Locked' }}</span>
                    </div>
                </div>
                <a href="{{ route('exhibitions.visitor.qr-pass', $slug) }}" class="mt-9 flex items-center gap-3 text-[14px] font-medium text-[#5b2eff]">
                    View QR Pass
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="rounded-lg border border-[#E7EAF3] p-6">
                <h2 class="mb-3 text-[19px] font-semibold text-[#071044]">Today's Sessions</h2>
                <div class="mb-7 space-y-3 text-[13px] leading-5 text-[#5A6480]">
                    <p><strong class="text-[#071044]">12:30 PM</strong> Product launch demos</p>
                    <p><strong class="text-[#071044]">03:00 PM</strong> AI in exhibitions webinar</p>
                    <p><strong class="text-[#071044]">05:30 PM</strong> VIP networking session</p>
                </div>
                <a href="{{ route('exhibitions.visitor.sessions', $slug) }}" class="flex h-[48px] items-center gap-4 rounded-md border border-[#E7EAF3] px-6 text-[13px] font-medium text-[#5b2eff]">
                    <i class="fa-regular fa-circle-play text-[20px]"></i>
                    {{ $isPassActive ? 'Join Session' : 'Register / Get Pass' }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
