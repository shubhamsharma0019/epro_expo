@extends('layouts.admin')

@section('title', 'Review Event')
@section('page-title', 'Review Event')

@section('content')
    @php
        $event = $publishRequest->companyEvent;
        $location = $event
            ? ($event->venue_name ?: trim(($event->city ?: '') . ($event->country ? ', ' . $event->country : '')) ?: 'Location TBD')
            : 'Location TBD';
    @endphp

    <section class="space-y-6 px-5 py-6 sm:px-8">
        <a href="{{ route('admin.event-approvals.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#3D1B9B] hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Back to approvals
        </a>

        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="text-[28px] font-bold text-[#0B132C]">{{ $event?->title ?? 'Review Event' }}</h1>
                    <p class="mt-2 text-[14px] text-gray-500">{{ $publishRequest->company?->company_name ?? 'Company' }} | {{ $location }}</p>
                </div>
                <span class="inline-flex rounded-full bg-[#F4F1FF] px-4 py-2 text-sm font-bold text-[#4C10D0]">{{ ucfirst(str_replace('_', ' ', $publishRequest->status)) }}</span>
            </div>

            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-gray-50 p-4">
                    <div class="text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-400">Dates</div>
                    <div class="mt-2 text-sm font-semibold text-[#0B132C]">{{ $event?->starts_at?->format('M d, Y') ?? 'Date TBD' }}</div>
                </div>
                <div class="rounded-xl bg-gray-50 p-4">
                    <div class="text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-400">Category</div>
                    <div class="mt-2 text-sm font-semibold text-[#0B132C]">{{ $event?->category ?? 'Category TBD' }}</div>
                </div>
                <div class="rounded-xl bg-gray-50 p-4">
                    <div class="text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-400">Ticket Types</div>
                    <div class="mt-2 text-sm font-semibold text-[#0B132C]">{{ $event?->ticketTypes?->count() ?? 0 }}</div>
                </div>
            </div>

            <div class="mb-6 rounded-xl border border-gray-100 p-5">
                <h2 class="mb-2 text-base font-bold text-[#0B132C]">Summary</h2>
                <p class="text-sm leading-6 text-gray-600">{{ $event?->summary ?: 'No summary provided.' }}</p>
            </div>

            <div class="flex flex-col gap-4 md:flex-row md:flex-wrap">
                @if ($publishRequest->status === 'pending')
                <form method="POST" action="{{ route('admin.event-approvals.approve', $publishRequest) }}">
                    @csrf
                    <button class="w-full rounded-xl bg-[#3D1B9B] hover:bg-[#2F1480] px-6 py-3 text-sm font-bold text-white shadow-sm transition md:w-auto">Approve</button>
                </form>
                @endif
                @if ($publishRequest->status === 'approved' && ($event?->publish_status ?? 'unpublished') !== 'published')
                <form method="POST" action="{{ route('admin.event-approvals.publish', $publishRequest) }}">
                    @csrf
                    <button class="w-full rounded-xl bg-green-700 hover:bg-green-800 px-6 py-3 text-sm font-bold text-white shadow-sm transition md:w-auto">Publish Live</button>
                </form>
                @endif
                @if (($event?->publish_status ?? '') === 'published')
                <form method="POST" action="{{ route('admin.event-approvals.unpublish', $publishRequest) }}">
                    @csrf
                    <button class="w-full rounded-xl border border-amber-300 bg-white hover:bg-amber-50 px-6 py-3 text-sm font-bold text-amber-700 shadow-sm transition md:w-auto">Unpublish</button>
                </form>
                @endif
                @if ($publishRequest->status === 'pending')
                <form method="POST" action="{{ route('admin.event-approvals.reject', $publishRequest) }}" class="flex flex-1 flex-col gap-3 md:flex-row">
                    @csrf
                    <input name="review_notes" required placeholder="Reason for rejection" class="flex-1 rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-[#3D1B9B] focus:outline-none">
                    <button class="w-full rounded-xl border border-red-200 bg-white hover:bg-red-50 px-6 py-3 text-sm font-bold text-red-600 transition md:w-auto">Reject</button>
                </form>
                @endif
            </div>
        </div>
    </section>
@endsection

