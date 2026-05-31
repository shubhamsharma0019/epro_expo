@extends('layouts.frontend')

@section('title', 'Visitor Pass Confirmed - EproExpo')

@section('content')
<section class="bg-[#FBFAFF] px-5 py-10 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1050px] rounded-[22px] border border-[#E7EAF3] bg-white p-8 text-center shadow-[0_18px_44px_rgba(7,16,68,0.08)]">
        <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-[#F4F0FF] text-[28px] font-bold text-[#5b2eff]">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="mt-5 text-[34px] font-bold text-[#071044]">Visitor pass confirmed</h1>
        <p class="mx-auto mt-3 max-w-[700px] text-[15px] font-medium leading-7 text-[#5A6480]">Your Business Pass for Global Tech Expo 2026 is ready. Use your QR visitor pass to enter the lobby, explore companies, open halls, visit booths, join sessions and access protected visitor tools.</p>

        <div class="mx-auto mt-7 grid max-w-[820px] gap-4 text-left md:grid-cols-3">
            @foreach ([['Pass ID', 'EXP-20486'], ['Pass type', 'Business Pass'], ['Dates', 'June 12 - 14, 2026']] as [$label, $value])
                <div class="rounded-[14px] bg-[#FBFAFF] p-5">
                    <p class="text-[12px] font-bold uppercase tracking-[0.08em] text-[#5A6480]">{{ $label }}</p>
                    <p class="mt-2 text-[16px] font-bold text-[#071044]">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('exhibitions.tickets.e-ticket', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[14px] font-bold text-white">View QR Pass</a>
            <a href="{{ route('exhibitions.visit', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-7 text-[14px] font-bold text-[#071044]">Visit Exhibition</a>
            <a href="{{ route('exhibitions.visitor.dashboard', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-7 text-[14px] font-bold text-[#071044]">Visitor Dashboard</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    localStorage.setItem('exhibitionPass', JSON.stringify({
        passId: 'EXP-20486',
        exhibitionName: 'Global Tech Expo 2026',
        passType: 'Business Pass',
        dates: 'June 12 - June 14, 2026',
        pavilion: 'Innovation Pavilion',
        access: 'Lobby + Companies + Public Booths',
        ticketUrl: "{{ route('exhibitions.tickets.e-ticket', $slug) }}",
        entryUrl: "{{ route('exhibitions.visit', $slug) }}"
    }));
});
</script>
@endpush
