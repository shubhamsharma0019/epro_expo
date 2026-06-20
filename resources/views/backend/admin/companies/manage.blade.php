@extends('layouts.admin')

@section('title', 'Manage Company')
@section('page-title', 'Manage Company')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="text-[28px] font-bold text-[#0B132C]">{{ $company->company_name }}</h2>
                <p class="mt-2 text-[14px] text-gray-500">{{ $company->email }} · {{ ucfirst($company->status ?? 'pending') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.companies.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C]">
                    Back to Companies
                </a>
                @if ($isImpersonating)
                    <form method="POST" action="{{ route('admin.companies.stop-impersonation') }}">
                        @csrf
                        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-rose-600 px-5 text-[14px] font-semibold text-white">
                            Exit Company Mode
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.companies.impersonate', $company) }}">
                        @csrf
                        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[14px] font-semibold text-white">
                            Open Company Flow
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">Exhibition Bookings</p>
                <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $bookings->count() }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">Company Events</p>
                <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $events->count() }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Exhibition / Booth Operations</h3>
                <p class="mt-2 text-[13px] text-gray-500">Admin actions use the same company flow pages. Changes save to this company record.</p>
                <div class="mt-5 flex flex-col gap-3">
                    <form method="POST" action="{{ route('admin.companies.impersonate', $company) }}">
                        @csrf
                        <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-[#3723db] px-5 text-[14px] font-semibold text-white">
                            Manage Exhibition Booking
                        </button>
                    </form>
                    <a href="{{ route('admin.booth-bookings.index') }}?search={{ urlencode($company->company_name) }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C]">
                        View Booth Bookings (Admin)
                    </a>
                    <a href="{{ route('admin.pavilions.create') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C]">
                        Add Pavilion (Admin)
                    </a>
                    <a href="{{ route('admin.booths.create') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C]">
                        Add Booth (Admin)
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Event Operations</h3>
                <div class="mt-5 flex flex-col gap-3">
                    <a href="{{ route('admin.events.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C]">
                        View All Events (Admin)
                    </a>
                    <a href="{{ route('admin.event-approvals.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C]">
                        Event Approvals
                    </a>
                </div>
                <div class="mt-6 space-y-3">
                    @forelse ($events as $event)
                        <div class="rounded-xl border border-gray-100 px-4 py-3">
                            <p class="font-semibold text-[#0B132C]">{{ $event->title }}</p>
                            <p class="mt-1 text-[12px] text-gray-500">{{ ucfirst($event->status ?? 'draft') }}</p>
                        </div>
                    @empty
                        <p class="text-[14px] text-gray-500">No events for this company yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
