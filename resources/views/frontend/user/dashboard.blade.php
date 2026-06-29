@extends('layouts.user')

@section('title', 'Visitor Dashboard - EproExpo')
@section('page-title', 'Dashboard')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

<section class="visitor-flow-page booth-home-page bg-[#FBFAFF] px-4 py-6 sm:px-8 sm:py-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        @include('frontend.user.dashboard.partials.header-bar')

        <div class="visitor-dashboard-grid">
            <div class="booth-home-main min-w-0 space-y-6">
                @include('frontend.user.dashboard.partials.main-content')
            </div>

            @include('frontend.user.dashboard.partials.right-panel')
        </div>
    </div>
</section>

<div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#071044]/60 p-4 backdrop-blur-sm">
    <div id="qr-modal-card" class="relative w-full max-w-sm scale-95 rounded-3xl border border-gray-100 bg-white p-6 shadow-2xl transition-all duration-300">
        <button type="button" onclick="closeQrModal()" class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition hover:bg-gray-200">
            <i class="ph ph-x"></i>
        </button>

        <div class="mt-2 text-center">
            <span id="modal-ticket-type" class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-indigo-600">Ticket Pass</span>
            <h3 id="modal-title" class="mt-3 truncate text-xl font-bold text-[#0B132C]">Event Title</h3>
            <p id="modal-email" class="mt-1 text-xs text-gray-400">user@example.com</p>

            <div class="mt-6 inline-flex flex-col items-center justify-center rounded-2xl border border-indigo-50 bg-[#FBFAFF] p-4 shadow-inner">
                <img src="" alt="QR Pass" id="modal-qr-img" class="h-44 w-44 rounded-xl bg-white shadow-sm" />
                <p id="modal-ticket-id" class="mt-3 font-mono text-xs font-bold tracking-wider text-[#0B132C]">ORDER_NUMBER</p>
            </div>

            <p class="mt-4 text-xs leading-relaxed text-gray-500">Present this QR code at the registration desk for verification.</p>
        </div>
    </div>
</div>

<script>
    function openQrModal(id, title, type, email) {
        document.getElementById('modal-ticket-id').innerText = id;
        document.getElementById('modal-title').innerText = title;
        document.getElementById('modal-ticket-type').innerText = type;
        document.getElementById('modal-email').innerText = email;

        document.getElementById('modal-qr-img').src =
            'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data=' +
            encodeURIComponent(id + '|' + title + '|' + email);

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
