@extends('layouts.user')

@section('title', 'Visitor Dashboard - EproExpo')
@section('page-title', 'Dashboard')

@section('content')
@php
    $userName = $user->name ?? 'Visitor';
    $userEmail = $user->email ?? '';
@endphp

<div class="mx-auto max-w-[1400px] w-full px-5 py-6 sm:px-8 lg:px-8">
    <!-- Session Messages -->
    @if (session('event_booking_path') && $eventTickets->isEmpty())
        <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h4 class="text-[16px] font-bold text-blue-900">Continue your ticket booking</h4>
                <p class="text-sm text-blue-700 mt-1">You were in the middle of booking an event ticket. Click the button to resume.</p>
            </div>
            <a href="{{ session('event_booking_path') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#5b2eff] px-5 text-[13px] font-bold text-white shadow-sm hover:bg-[#4310d8] transition whitespace-nowrap">
                Continue Booking
            </a>
        </div>
    @endif

    @if (session('exhibition_booking_path') && $exhibitionPasses->isEmpty())
        <div class="mb-6 rounded-2xl border border-indigo-100 bg-indigo-50 p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h4 class="text-[16px] font-bold text-indigo-900">Continue your pass booking</h4>
                <p class="text-sm text-indigo-700 mt-1">You were in the middle of getting a visitor pass. Click the button to resume.</p>
            </div>
            <a href="{{ session('exhibition_booking_path') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#5b2eff] px-5 text-[13px] font-bold text-white shadow-sm hover:bg-[#4310d8] transition whitespace-nowrap">
                Continue Booking
            </a>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[40px] tracking-[-1px] text-[#071044] sm:text-[42px] sm:leading-[48px]">
            Welcome back, {{ $userName }}!
        </h1>
        <p class="mt-2 text-[16px] leading-7 text-[#5A6480] sm:text-[18px]">
            Your event tickets, exhibition passes, and activity agenda are ready.
        </p>
    </div>

    <!-- Overview Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <!-- Widget 1: Total Passes -->
        <div class="bg-white rounded-2xl border border-[#E7EAF3] p-6 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-[#8A94AD] uppercase tracking-wider">Total Passes</p>
                <h3 class="text-2xl font-extrabold text-[#071044] mt-2">{{ $totalTicketsCount }}</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-ticket"></i>
            </div>
        </div>

        <!-- Widget 2: Upcoming Events -->
        <div class="bg-white rounded-2xl border border-[#E7EAF3] p-6 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-[#8A94AD] uppercase tracking-wider">Upcoming Events</p>
                <h3 class="text-2xl font-extrabold text-[#071044] mt-2">{{ $upcomingEvents->count() }}</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-regular fa-calendar"></i>
            </div>
        </div>

        <!-- Widget 3: Upcoming Exhibitions -->
        <div class="bg-white rounded-2xl border border-[#E7EAF3] p-6 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-bold text-[#8A94AD] uppercase tracking-wider">Upcoming Exhibitions</p>
                <h3 class="text-2xl font-extrabold text-[#071044] mt-2">{{ $upcomingExhibitions->count() }}</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-building-columns"></i>
            </div>
        </div>
    </div>

    <!-- Quick Links Row -->
    <div class="mb-10">
        <h2 class="mb-4 text-[20px] font-bold text-[#071044]">Quick Portal Actions</h2>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ url('/events') }}" class="flex h-[56px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                <i class="fa-solid fa-calendar-days text-[18px]"></i>
                Explore Live Events
            </a>

            <a href="{{ route('exhibitions.index') }}" class="flex h-[56px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                <i class="fa-solid fa-store text-[18px]"></i>
                Browse Exhibitions
            </a>

            <a href="{{ route('frontend.user.profile') }}" class="flex h-[56px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                <i class="fa-regular fa-user text-[18px]"></i>
                Edit Profile Settings
            </a>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="bg-white rounded-[26px] border border-[#E7EAF3] p-6 sm:p-8 shadow-sm mb-10">
        <h2 class="text-xl font-bold text-[#071044] mb-6 flex items-center gap-2 border-b border-gray-50 pb-3">
            <i class="fa-solid fa-clock-rotate-left text-[#5b2eff]"></i> Recent Activities
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($recentActivities as $act)
                <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-indigo-150 transition">
                    <div class="h-10 w-10 shrink-0 rounded-full {{ $act['color'] }} flex items-center justify-center text-[12px] shadow-sm">
                        <i class="{{ $act['icon'] }}"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-bold text-[#071044] leading-tight">{{ $act['title'] }}</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $act['desc'] }}</p>
                        <span class="text-[10px] font-medium text-gray-400 mt-1.5 block"><i class="fa-regular fa-clock mr-1"></i> {{ $act['time']->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-2 py-12 text-center text-sm text-gray-450 border border-dashed border-gray-200 rounded-xl">
                    No recent activity found.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- QR Modal component container -->
<div id="qr-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-[#071044]/60 backdrop-blur-sm p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl relative border border-gray-100 transform scale-95 transition-all duration-300" id="qr-modal-card">
        <button onclick="closeQrModal()" class="absolute top-4 right-4 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
            <i class="fa-solid fa-xmark text-md"></i>
        </button>
        
        <div class="text-center mt-2">
            <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-indigo-600" id="modal-ticket-type">Ticket Pass</span>
            <h3 class="mt-3 text-xl font-bold text-[#071044] leading-tight truncate" id="modal-title">Event Title</h3>
            <p class="text-xs text-gray-400 mt-1" id="modal-email">user@example.com</p>
            
            <div class="mt-6 p-4 rounded-2xl bg-[#FBFAFF] border border-indigo-50 inline-flex flex-col items-center justify-center shadow-inner">
                <img src="" alt="QR Pass" id="modal-qr-img" class="h-44 w-44 rounded-xl shadow-sm bg-white" />
                <p class="mt-3 text-xs font-mono font-bold text-[#071044] tracking-wider" id="modal-ticket-id">ORDER_NUMBER</p>
            </div>
            
            <p class="mt-4 text-xs text-gray-500 leading-relaxed">Present this QR code at the registration desk for verification.</p>
        </div>
    </div>
</div>

<script>
    function openQrModal(id, title, type, email) {
        document.getElementById('modal-ticket-id').innerText = id;
        document.getElementById('modal-title').innerText = title;
        document.getElementById('modal-ticket-type').innerText = type;
        document.getElementById('modal-email').innerText = email;
        
        const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data=' + encodeURIComponent(id + '|' + title + '|' + email);
        document.getElementById('modal-qr-img').src = qrUrl;
        
        const modal = document.getElementById('qr-modal');
        const card = document.getElementById('qr-modal-card');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }
    
    function closeQrModal() {
        const modal = document.getElementById('qr-modal');
        const card = document.getElementById('qr-modal-card');
        
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 150);
    }
</script>
@endsection
