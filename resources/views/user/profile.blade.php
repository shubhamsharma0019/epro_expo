@extends('layouts.user')

@section('title', 'User Profile')
@section('page-title', 'Profile')

@section('content')
<main class="px-5 py-6 sm:px-8 lg:px-8">
    <section class="grid gap-6 xl:grid-cols-[340px_minmax(0,1fr)]">
        <aside class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 text-center shadow-[0_18px_50px_rgba(7,16,68,0.08)]">
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-[28px] bg-gradient-to-br from-[#5b2eff] to-[#246BFF] text-[34px] font-semibold text-white">{{ strtoupper(substr(auth()->user()->name ?? 'J', 0, 1)) }}</div>
            <h1 class="mt-5 text-[24px] font-semibold text-[#071044]">{{ auth()->user()->name ?? 'John Doe' }}</h1>
            <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ auth()->user()->email ?? 'john@example.com' }}</p>
            <div class="mt-6 rounded-2xl bg-[#FBFCFF] p-4 ring-1 ring-[#E7EAF3]">
                <p class="text-[12px] font-bold uppercase tracking-[0.12em] text-[#5A6480]">Visitor Status</p>
                <p class="mt-2 text-[18px] font-semibold text-[#071044]">Active Member</p>
            </div>
        </aside>

        <form class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_50px_rgba(7,16,68,0.08)] sm:p-8">
            <span class="inline-flex rounded-full bg-[#F4F0FF] px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#5b2eff]">Profile Details</span>
            <h2 class="mt-5 text-[34px] font-semibold tracking-[-0.04em] text-[#071044]">Manage visitor information.</h2>
            <p class="mt-3 text-[15px] font-medium leading-7 text-[#5A6480]">This information is used for tickets, e-passes, enquiries, and meeting requests.</p>
            <div class="mt-7 grid grid-cols-1 gap-5 md:grid-cols-2">
                @foreach ([['Name', auth()->user()->name ?? 'John Doe'], ['Email', auth()->user()->email ?? 'john@example.com'], ['Phone', auth()->user()->phone ?? '+91 98765 43210'], ['City', 'New Delhi']] as [$label, $value])
                    <label><span class="text-[13px] font-bold text-[#34405F]">{{ $label }}</span><input value="{{ $value }}" class="mt-2 h-12 w-full rounded-xl border border-[#E7EAF3] bg-[#F8F9FD] px-4 text-[14px] font-medium outline-none focus:border-[#5b2eff]"></label>
                @endforeach
            </div>
            <button type="button" class="mt-7 h-12 rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[14px] font-bold text-white shadow-lg shadow-purple-200">Save Profile</button>
        </form>
    </section>
</main>
@endsection
