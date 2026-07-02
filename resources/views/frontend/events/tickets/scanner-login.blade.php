@extends('layouts.frontend')

@section('title', 'Ticket Scanner Login')

@section('content')
<main class="mx-auto w-full max-w-[520px] flex-1 px-4 pb-12 pt-10 md:px-[32px]">
    <div class="rounded-[20px] border border-[#E8E3F0] bg-white p-8 shadow-[0_8px_30px_rgba(31,42,107,0.06)]">
        <h1 class="text-[28px] font-extrabold text-[#071044]">Ticket Scanner</h1>
        <p class="mt-2 text-[15px] text-[#4E567A]">Sign in with scanner credentials to verify and check in visitor tickets.</p>

        @if (session('success'))
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('warning'))
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[14px] font-medium text-amber-700">{{ session('warning') }}</div>
        @endif
        @if (session('status'))
            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[14px] font-medium text-slate-700">{{ session('status') }}</div>
        @endif

        @if ($scannerUsername ?? null)
            <div class="mt-6 rounded-xl bg-[#F8FAFF] p-5 text-[15px] text-[#1F2A6A]">
                <p><span class="font-bold">Signed in as:</span> {{ $scannerUsername }}</p>
                <p class="mt-2 text-[14px] text-[#4E567A]">Scan a visitor ticket QR code to verify entry.</p>
            </div>
            <form method="POST" action="{{ route('ticket-scanner.logout') }}" class="mt-6">
                @csrf
                <button type="submit"
                    class="inline-flex h-[52px] w-full items-center justify-center rounded-xl border border-[#907BFF] bg-white px-5 text-[15px] font-bold text-[#4320D6] transition hover:bg-[#F7F4FF]">
                    Sign Out
                </button>
            </form>
        @else
            <form method="POST" action="{{ $scannerLoginUrl ?? route('ticket-scanner.login.submit') }}" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="redirect" value="{{ $redirect ?? request('redirect') }}">

                <div>
                    <label for="username" class="mb-2 block text-[14px] font-semibold text-[#1F2A6A]">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus
                        class="h-[48px] w-full rounded-xl border border-[#D8DCEB] px-4 text-[15px] text-[#071044] outline-none transition focus:border-[#4318FF] focus:ring-2 focus:ring-[#4318FF]/15">
                    @error('username')
                        <p class="mt-2 text-[13px] font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-[14px] font-semibold text-[#1F2A6A]">Password</label>
                    <input id="password" name="password" type="password" required
                        class="h-[48px] w-full rounded-xl border border-[#D8DCEB] px-4 text-[15px] text-[#071044] outline-none transition focus:border-[#4318FF] focus:ring-2 focus:ring-[#4318FF]/15">
                </div>

                <div>
                    <label for="scan_location" class="mb-2 block text-[14px] font-semibold text-[#1F2A6A]">Scan Location / Gate</label>
                    <input id="scan_location" name="scan_location" type="text" value="{{ old('scan_location', session('ticket_scanner_location')) }}" placeholder="e.g. Main Gate, Hall A Entry"
                        class="h-[48px] w-full rounded-xl border border-[#D8DCEB] px-4 text-[15px] text-[#071044] outline-none transition focus:border-[#4318FF] focus:ring-2 focus:ring-[#4318FF]/15">
                </div>

                <button type="submit"
                    class="inline-flex h-[52px] w-full items-center justify-center rounded-xl bg-[#4318FF] px-5 text-[15px] font-bold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)] transition hover:bg-[#3412C9]">
                    Sign In
                </button>
            </form>
        @endif
    </div>
</main>
@endsection
