@extends('layouts.user')

@section('title', 'User Profile')
@section('page-title', 'Profile')

@section('content')
<section class="space-y-6 px-4 py-6 sm:px-8">
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-[13px] font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
        <aside class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm">
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-[28px] bg-[#3723db] text-[34px] font-semibold text-white">
                {{ strtoupper(substr($user->name ?? 'J', 0, 1)) }}
            </div>
            <h2 class="mt-5 text-[22px] font-bold text-[#0B132C]">{{ $user->name }}</h2>
            <p class="mt-2 break-all text-[14px] text-gray-500">{{ $user->email }}</p>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-[#F8F9FC] p-4">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">Event Tickets</p>
                    <p class="mt-2 text-[24px] font-bold text-[#0B132C]">{{ $eventTicketCount }}</p>
                </div>
                <div class="rounded-2xl bg-[#F8F9FC] p-4">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">Exhibition Passes</p>
                    <p class="mt-2 text-[24px] font-bold text-[#0B132C]">{{ $passCount }}</p>
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('frontend.user.profile.update') }}" class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <span class="inline-flex rounded-full bg-[#F4F2FF] px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#3723db]">Profile Details</span>
            <h2 class="mt-5 text-[28px] font-bold text-[#0B132C] sm:text-[34px]">Manage visitor information</h2>
            <p class="mt-3 text-[15px] leading-7 text-gray-500">This information is used for tickets, e-passes, enquiries, and meeting requests.</p>
            <div class="mt-7 grid grid-cols-1 gap-5 md:grid-cols-2">
                <label class="block min-w-0">
                    <span class="text-[13px] font-bold text-[#34405F]">Name</span>
                    <input name="name" value="{{ old('name', $user->name) }}" required class="mt-2 h-12 w-full min-w-0 rounded-xl border border-gray-200 bg-[#F8F9FC] px-4 text-[14px] font-medium outline-none focus:border-[#3723db]">
                </label>
                <label class="block min-w-0">
                    <span class="text-[13px] font-bold text-[#34405F]">Email</span>
                    <input value="{{ $user->email }}" disabled class="mt-2 h-12 w-full min-w-0 rounded-xl border border-gray-200 bg-gray-100 px-4 text-[14px] font-medium text-gray-500">
                </label>
                <label class="block min-w-0">
                    <span class="text-[13px] font-bold text-[#34405F]">Phone</span>
                    <input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-2 h-12 w-full min-w-0 rounded-xl border border-gray-200 bg-[#F8F9FC] px-4 text-[14px] font-medium outline-none focus:border-[#3723db]">
                </label>
            </div>
            <button type="submit" class="mt-7 h-12 rounded-xl bg-[#3723db] px-7 text-[14px] font-bold text-white transition hover:bg-[#2b1bb8]">Save Profile</button>
        </form>
    </div>
</section>
@endsection
