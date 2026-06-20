@extends('layouts.user')

@section('title', 'My Passes - EproExpo')
@section('page-title', 'My Passes')

@section('content')
<div class="mx-auto max-w-[1400px] w-full px-5 py-6 sm:px-8 lg:px-8">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[34px] font-semibold leading-[40px] tracking-[-1px] text-[#071044] sm:text-[42px] sm:leading-[48px]">
                My Passes & Tickets
            </h1>
            <p class="mt-2 text-[16px] leading-7 text-[#5A6480]">
                A central location for all your exhibition passes and event tickets.
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ url('/events') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-700 px-5 text-sm font-bold transition">
                Book Event
            </a>
            <a href="{{ route('exhibitions.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-indigo-55 hover:bg-indigo-100 text-[#5b2eff] border border-indigo-200 px-5 text-sm font-bold transition">
                Get Exhibition Pass
            </a>
        </div>
    </div>

    <!-- Passes Grid/List -->
    @if($passes->isEmpty())
        <div class="bg-white rounded-[26px] border border-[#E7EAF3] p-12 text-center shadow-sm">
            <div class="h-16 w-16 mx-auto bg-gray-50 text-gray-400 rounded-full flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-ticket"></i>
            </div>
            <h3 class="text-lg font-bold text-[#071044]">No passes or tickets found</h3>
            <p class="text-sm text-gray-500 max-w-sm mx-auto mt-2">Get started by booking an upcoming event ticket or register for a free exhibition pass.</p>
        </div>
    @else
        <!-- Filter Tabs -->
        <div class="mb-6 flex flex-wrap gap-2 border-b border-gray-150 pb-4">
            <button onclick="filterPasses('all')" class="pass-filter-btn h-9 rounded-lg px-4 text-xs font-bold text-white transition bg-[#5b2eff]" id="btn-filter-all">All Passes ({{ $totalCount }})</button>
            <button onclick="filterPasses('upcoming')" class="pass-filter-btn h-9 rounded-lg bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-700 px-4 text-xs font-bold transition" id="btn-filter-upcoming">Upcoming</button>
            <button onclick="filterPasses('live')" class="pass-filter-btn h-9 rounded-lg bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-700 px-4 text-xs font-bold transition" id="btn-filter-live">Active / Live</button>
            <button onclick="filterPasses('completed')" class="pass-filter-btn h-9 rounded-lg bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-700 px-4 text-xs font-bold transition" id="btn-filter-completed">Completed</button>
        </div>

        <div class="grid grid-cols-1 gap-6" id="passes-container">
            @foreach ($passes as $pass)
                @php
                    $isEvent = $pass['type'] === 'event';
                    $icon = $isEvent ? 'fa-solid fa-ticket' : 'fa-solid fa-id-card';
                    $badgeBg = $isEvent ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-indigo-50 text-indigo-700 border-indigo-100';
                    $statusClass = $pass['status'] === 'confirmed' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-gray-500 bg-gray-50 border-gray-150';
                    
                    // Priority category color for UI badge helper
                    $catClass = '';
                    if ($pass['category'] === 'upcoming') {
                        $catClass = 'bg-amber-50 text-amber-800 border-amber-200';
                    } elseif ($pass['category'] === 'live') {
                        $catClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                    } else {
                        $catClass = 'bg-gray-100 text-gray-650 border-gray-200';
                    }
                @endphp
                <div class="pass-card relative bg-white rounded-2xl border border-gray-150 p-6 flex flex-col md:flex-row gap-6 items-center justify-between shadow-sm hover:shadow-md transition w-full min-w-0" 
                     data-category="{{ $pass['category'] }}">
                    
                    <!-- Pass Details -->
                    <div class="flex items-center gap-4 w-full md:w-auto min-w-0 flex-1">
                        <div class="h-14 w-14 shrink-0 rounded-2xl {{ $isEvent ? 'bg-blue-50 text-blue-600' : 'bg-indigo-50 text-indigo-600' }} flex items-center justify-center text-xl">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <span class="inline-flex rounded-full border px-2.5 py-0.5 text-[10px] font-bold {{ $badgeBg }}">{{ $pass['pass_type'] }}</span>
                                <span class="inline-flex rounded-full border px-2.5 py-0.5 text-[10px] font-bold {{ $catClass }}">{{ ucfirst($pass['category']) }}</span>
                            </div>
                            <h4 class="text-lg font-bold text-[#071044] truncate" title="{{ $pass['name'] }}">{{ $pass['name'] }}</h4>
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="font-bold text-gray-700">No:</span> <span class="font-mono font-bold">{{ $pass['number'] }}</span> 
                                @if($isEvent && $pass['quantity'] > 1)
                                    &bull; <span class="font-bold text-gray-700">Qty:</span> {{ $pass['quantity'] }}
                                @endif
                                &bull; <i class="fa-regular fa-calendar-alt ml-1"></i> {{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Pass Actions -->
                    <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end shrink-0 border-t md:border-t-0 pt-4 md:pt-0 border-gray-100">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Status</p>
                            <p class="text-xs font-extrabold border px-2.5 py-0.5 rounded-full mt-1 inline-block {{ $statusClass }}">
                                {{ ucfirst($pass['status']) }}
                            </p>
                        </div>
                        
                        <div class="flex gap-2 w-full sm:w-auto">
                            <!-- View QR button -->
                            <button onclick="openQrModal('{{ $pass['number'] }}', '{{ addslashes($pass['name']) }}', '{{ $pass['ticket_name'] }}', '{{ $pass['email'] }}')" 
                                    class="flex-1 sm:flex-initial inline-flex h-10 items-center justify-center rounded-xl border {{ $isEvent ? 'border-blue-200 text-blue-600 hover:bg-blue-50' : 'border-indigo-200 text-indigo-600 hover:bg-indigo-50' }} bg-white px-4 text-xs font-bold shadow-sm transition">
                                <i class="fa-solid fa-qrcode mr-1.5"></i> View QR
                            </button>
                            
                            <!-- E-ticket details / Lobby link -->
                            @if($isEvent)
                                <a href="{{ route('frontend.user.tickets.e-ticket', ['id' => $pass['id'], 'download' => 1]) }}" 
                                   class="flex-1 sm:flex-initial inline-flex h-10 items-center justify-center rounded-xl bg-[#5b2eff] px-4 text-xs font-bold text-white shadow-sm hover:bg-[#4310d8] transition">
                                    Download <i class="fa-solid fa-download ml-1.5"></i>
                                </a>
                            @else
                                <a href="{{ route('exhibitions.visit', $pass['slug']) }}" 
                                   class="flex-1 sm:flex-initial inline-flex h-10 items-center justify-center rounded-xl bg-[#5b2eff] px-4 text-xs font-bold text-white shadow-sm hover:bg-[#4310d8] transition">
                                    Enter Lobby <i class="fa-solid fa-arrow-right ml-1.5"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- QR Modal Component -->
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

    function filterPasses(category) {
        const cards = document.querySelectorAll('.pass-card');
        const buttons = document.querySelectorAll('.pass-filter-btn');
        
        // Update button styles
        buttons.forEach(btn => {
            btn.classList.remove('bg-[#5b2eff]', 'text-white');
            btn.classList.add('bg-gray-50', 'border', 'border-gray-200', 'text-gray-700', 'hover:bg-gray-100');
        });
        
        const activeBtn = document.getElementById('btn-filter-' + category);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-50', 'border', 'border-gray-200', 'text-gray-700', 'hover:bg-gray-100');
            activeBtn.classList.add('bg-[#5b2eff]', 'text-white');
        }
        
        // Show/hide cards
        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection
