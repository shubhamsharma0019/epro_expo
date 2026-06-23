@extends('layouts.user')

@section('title', 'My Passes - EproExpo')
@section('page-title', 'My Passes')

@section('content')
<section class="space-y-6 px-5 py-6 sm:px-8">
    <div class="rounded-3xl bg-[#0B132C] px-6 py-7 text-white">
        <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-white/60">{{ now()->format('M d, Y') }}</p>
        <h2 class="mt-3 text-[30px] font-bold">My Passes & Tickets</h2>
        <p class="mt-2 max-w-2xl text-[14px] text-white/70">
            A central location for all your exhibition passes and event tickets.
        </p>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ url('/events/listings') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-[13px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
            Book Event
        </a>
        <a href="{{ route('exhibitions.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[13px] font-semibold text-white transition hover:bg-[#2b1bb8]">
            Get Exhibition Pass
        </a>
    </div>

    @if($passes->isEmpty())
        <div class="rounded-2xl border border-gray-100 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 text-2xl text-gray-400">
                <i class="ph ph-ticket"></i>
            </div>
            <h3 class="text-lg font-bold text-[#0B132C]">No passes or tickets found</h3>
            <p class="mx-auto mt-2 max-w-sm text-[13px] text-gray-500">Get started by booking an upcoming event ticket or register for an exhibition pass.</p>
        </div>
    @else
    <div class="flex flex-wrap gap-2 border-b border-gray-100 pb-4 pass-filter-scroll">
            <button onclick="filterPasses('all')" class="pass-filter-btn h-9 rounded-lg bg-[#3723db] px-4 text-xs font-bold text-white transition" id="btn-filter-all">All Passes ({{ $totalCount }})</button>
            <button onclick="filterPasses('upcoming')" class="pass-filter-btn h-9 rounded-lg border border-gray-200 bg-white px-4 text-xs font-bold text-gray-700 transition hover:bg-gray-50" id="btn-filter-upcoming">Upcoming</button>
            <button onclick="filterPasses('live')" class="pass-filter-btn h-9 rounded-lg border border-gray-200 bg-white px-4 text-xs font-bold text-gray-700 transition hover:bg-gray-50" id="btn-filter-live">Active / Live</button>
            <button onclick="filterPasses('completed')" class="pass-filter-btn h-9 rounded-lg border border-gray-200 bg-white px-4 text-xs font-bold text-gray-700 transition hover:bg-gray-50" id="btn-filter-completed">Completed</button>
        </div>

        <div class="space-y-4" id="passes-container">
            @foreach ($passes as $pass)
                @php
                    $isEvent = $pass['type'] === 'event';
                    $statusClass = $pass['status'] === 'confirmed' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600';
                @endphp
                <div class="pass-card rounded-2xl border border-gray-100 bg-white p-6 shadow-sm" data-category="{{ $pass['category'] }}">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex min-w-0 flex-1 items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-xl {{ $isEvent ? 'bg-blue-50 text-blue-600' : 'bg-indigo-50 text-indigo-600' }}">
                                <i class="{{ $isEvent ? 'ph ph-ticket' : 'ph ph-identification-card' }}"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold {{ $isEvent ? 'bg-blue-50 text-blue-700' : 'bg-indigo-50 text-indigo-700' }}">{{ $pass['pass_type'] }}</span>
                                    <span class="inline-flex rounded-full bg-[#F8F9FC] px-3 py-1 text-[11px] font-semibold text-gray-500">{{ ucfirst($pass['category']) }}</span>
                                </div>
                                <h4 class="truncate text-[16px] font-bold text-[#0B132C]" title="{{ $pass['name'] }}">{{ $pass['name'] }}</h4>
                                <p class="mt-1 text-[13px] text-gray-500">
                                    No: <span class="font-mono font-semibold">{{ $pass['number'] }}</span>
                                    @if($isEvent && $pass['quantity'] > 1)
                                        &bull; Qty: {{ $pass['quantity'] }}
                                    @endif
                                    &bull; {{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}
                                </p>
                            </div>
                        </div>

                        <div class="visitor-pass-actions flex flex-wrap items-center gap-2">
                            <span class="inline-flex rounded-full px-3 py-1 text-[12px] font-semibold {{ $statusClass }}">{{ ucfirst($pass['status']) }}</span>
                            <button onclick="openQrModal('{{ $pass['number'] }}', '{{ addslashes($pass['name']) }}', '{{ $pass['ticket_name'] }}', '{{ $pass['email'] }}')" class="inline-flex h-10 items-center justify-center rounded-xl border border-gray-200 px-4 text-[12px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                                View QR
                            </button>
                            @if($isEvent)
                                <a href="{{ route('frontend.user.tickets.e-ticket', ['id' => $pass['id'], 'download' => 1]) }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-[#3723db] px-4 text-[12px] font-semibold text-white transition hover:bg-[#2b1bb8]">
                                    Download
                                </a>
                            @else
                                <a href="{{ route('frontend.user.tickets.exhibition.show', $pass['id']) }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-gray-200 px-4 text-[12px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                                    View Pass
                                </a>
                                <a href="{{ route('exhibitions.visit', $pass['slug']) }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-[#3723db] px-4 text-[12px] font-semibold text-white transition hover:bg-[#2b1bb8]">
                                    Enter Lobby
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

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
            btn.classList.remove('bg-[#3723db]', 'text-white');
            btn.classList.add('border', 'border-gray-200', 'bg-white', 'text-gray-700', 'hover:bg-gray-50');
        });

        const activeBtn = document.getElementById('btn-filter-' + category);
        if (activeBtn) {
            activeBtn.classList.remove('border', 'border-gray-200', 'bg-white', 'text-gray-700', 'hover:bg-gray-50');
            activeBtn.classList.add('bg-[#3723db]', 'text-white');
        }

        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection
