@extends('layouts.company')

@section('title', 'Live Demos & Sessions | eproexpo')
@section('page-title', 'Live Demos & Sessions')

@php
    $editing = isset($session) && $session;
    $formAction = $editing
        ? route('company.booth-setup.sessions.update', [$booking, $session])
        : route('company.booth-setup.sessions.store', $booking);

    $defaultDate = $booking->exhibition?->start_date ?? now();
    $typeLabels = [
        'live_demo' => 'Live Demo',
        'webinar' => 'Webinar',
        'talk' => 'Talk',
        'qna' => 'Q&A',
    ];
    $typeStyles = [
        'live_demo' => 'bg-[#F5F3FF] border-[#DDD6FE] text-[#6D28D9]',
        'webinar' => 'bg-[#EFF6FF] border-[#BFDBFE] text-[#2563EB]',
        'talk' => 'bg-[#FEF3C7] border-[#FDE68A] text-[#D97706]',
        'qna' => 'bg-[#ECFDF5] border-[#A7F3D0] text-[#059669]',
    ];
    $statusLabels = [
        'upcoming' => 'Upcoming',
        'live' => 'Live',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
    $statusStyles = [
        'upcoming' => 'bg-[#EEF2FF] border-[#C7D2FE] text-[#4338CA]',
        'live' => 'bg-[#ECFDF5] border-[#A7F3D0] text-[#059669]',
        'completed' => 'bg-gray-100 border-gray-200 text-gray-600',
        'cancelled' => 'bg-red-50 border-red-200 text-red-600',
    ];
    $iconStyles = [
        'live_demo' => 'bg-[#F5F3FF] text-[#6D28D9]',
        'webinar' => 'bg-[#EFF6FF] text-[#2563EB]',
        'talk' => 'bg-[#FEF3C7] text-[#D97706]',
        'qna' => 'bg-[#ECFDF5] text-[#059669]',
    ];
    $typeIcons = [
        'live_demo' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        'webinar' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'talk' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0',
        'qna' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0',
    ];
    $tabs = [
        'all' => 'All Sessions',
        'upcoming' => 'Upcoming',
        'live' => 'Live',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    $allowOneToOne = (bool) old('allow_one_to_one', $availability?->allow_one_to_one ?? true);
    $allowOneToMany = (bool) old('allow_one_to_many', $availability?->allow_one_to_many ?? false);
    $allowConference = (bool) old('allow_conference', $availability?->allow_conference ?? false);
    $conferenceCapacity = old('conference_capacity', $availability?->max_capacity && ($availability?->allow_conference ?? false) ? $availability->max_capacity : 50);
    $activeMeetingModes = collect([
        'One-to-One' => $allowOneToOne,
        'One-to-Many' => $allowOneToMany,
        'Conference' => $allowConference,
    ])->filter()->keys();
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-[1400px] mx-auto border border-gray-100 rounded-2xl p-5 bg-white shadow-sm lg:p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between mb-8">
            <div>
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight">Live Demos & Sessions</h1>
            </div>
            <a href="{{ route('company.booth-setup.sessions.create', $booking) }}#sessionForm" class="inline-flex w-full items-center justify-center rounded-lg bg-[#4C1D95] px-6 py-2.5 text-[14px] font-bold text-white transition-colors hover:bg-[#3b1774] sm:w-auto">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Create New Session
            </a>
        </div>

        @if (session('meeting_setup_status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('meeting_setup_status') }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">Please fix the session details.</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="meetingSetup" class="border border-[#DDD6FE] rounded-xl bg-[#FAF5FF] shadow-sm p-6 mb-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between mb-6">
                <div>
                    <h2 class="text-[#1E1B4B] font-bold text-[18px] mb-2">Meeting Setup Preferences</h2>
                    <p class="text-[#6B7280] text-[14px] max-w-2xl">Choose how visitors can book meetings with your team. You can enable one or more formats below. Detailed time slots and availability can be configured on the Meetings step.</p>
                </div>
                @if ($activeMeetingModes->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($activeMeetingModes as $mode)
                            <span class="inline-flex items-center rounded-full border border-[#DDD6FE] bg-white px-3 py-1 text-[12px] font-bold text-[#4C1D95]">{{ $mode }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('company.booth-setup.sessions.meeting-setup.update', $booking) }}" class="space-y-5">
                @csrf

                @if ($errors->has('meeting_setup') || $errors->has('conference_capacity'))
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @if ($errors->has('meeting_setup'))
                                <li>{{ $errors->first('meeting_setup') }}</li>
                            @endif
                            @if ($errors->has('conference_capacity'))
                                <li>{{ $errors->first('conference_capacity') }}</li>
                            @endif
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="relative flex cursor-pointer flex-col rounded-xl border {{ $allowOneToOne ? 'border-[#4C1D95] bg-white ring-1 ring-[#4C1D95]/20' : 'border-gray-200 bg-white' }} p-5 transition-colors hover:border-[#C4B5FD]">
                        <span class="flex items-start justify-between gap-3 mb-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-[#F5F3FF] text-[#4C1D95]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <input type="checkbox" name="allow_one_to_one" value="1" {{ $allowOneToOne ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                        </span>
                        <span class="text-[#1E1B4B] font-bold text-[15px] mb-1">One-to-One</span>
                        <span class="text-[#6B7280] text-[13px] leading-relaxed">Private meeting between one visitor and one company representative.</span>
                    </label>

                    <label class="relative flex cursor-pointer flex-col rounded-xl border {{ $allowOneToMany ? 'border-[#4C1D95] bg-white ring-1 ring-[#4C1D95]/20' : 'border-gray-200 bg-white' }} p-5 transition-colors hover:border-[#C4B5FD]">
                        <span class="flex items-start justify-between gap-3 mb-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-[#EFF6FF] text-[#2563EB]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path></svg>
                            </span>
                            <input type="checkbox" name="allow_one_to_many" value="1" {{ $allowOneToMany ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                        </span>
                        <span class="text-[#1E1B4B] font-bold text-[15px] mb-1">One-to-Many</span>
                        <span class="text-[#6B7280] text-[13px] leading-relaxed">Group meeting where multiple visitors join the same scheduled slot.</span>
                    </label>

                    <label class="relative flex cursor-pointer flex-col rounded-xl border {{ $allowConference ? 'border-[#4C1D95] bg-white ring-1 ring-[#4C1D95]/20' : 'border-gray-200 bg-white' }} p-5 transition-colors hover:border-[#C4B5FD]">
                        <span class="flex items-start justify-between gap-3 mb-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-[#ECFDF5] text-[#059669]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="checkbox" name="allow_conference" value="1" id="allow_conference" {{ $allowConference ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                        </span>
                        <span class="text-[#1E1B4B] font-bold text-[15px] mb-1">Conference</span>
                        <span class="text-[#6B7280] text-[13px] leading-relaxed">Large virtual conference-style session with a higher attendee capacity.</span>
                    </label>
                </div>

                <div id="conferenceCapacityField" class="{{ $allowConference ? '' : 'hidden' }} max-w-sm">
                    <label for="conference_capacity" class="block text-[#4B5563] text-[13px] font-medium mb-2">Conference Attendee Capacity</label>
                    <input id="conference_capacity" name="conference_capacity" type="number" min="2" max="1000" value="{{ $conferenceCapacity }}" placeholder="50" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                    <p class="mt-2 text-[12px] text-[#6B7280]">Required when Conference is enabled.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-t border-[#DDD6FE] pt-5">
                    <a href="{{ route('company.booth-setup.meetings.edit', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Configure meeting availability and time slots</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#4C1D95] px-5 py-2.5 text-[14px] font-bold text-white transition-colors hover:bg-[#3b1774]">
                        Save Meeting Preferences
                    </button>
                </div>
            </form>
        </div>

        <div id="sessionForm" class="border border-gray-100 rounded-xl bg-white shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between gap-4 mb-6">
                <h2 class="text-[#1E1B4B] font-bold text-[18px]">{{ $editing ? 'Edit Session' : 'Create Session' }}</h2>
                @if ($editing)
                    <a href="{{ route('company.booth-setup.sessions.index', $booking) }}#sessionForm" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Cancel Edit</a>
                @endif
            </div>

            <form method="POST" action="{{ $formAction }}" class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                @csrf
                @if ($editing)
                    @method('PUT')
                @endif

                <div class="lg:col-span-5">
                    <label for="title" class="block text-[#4B5563] text-[13px] font-medium mb-2">Session Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $session->title ?? '') }}" placeholder="Product deep dive" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                </div>

                <div class="lg:col-span-3">
                    <label for="type" class="block text-[#4B5563] text-[13px] font-medium mb-2">Session Type</label>
                    <select id="type" name="type" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                        @foreach ($typeLabels as $value => $label)
                            <option value="{{ $value }}" @selected(old('type', $session->type ?? 'live_demo') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="status" class="block text-[#4B5563] text-[13px] font-medium mb-2">Status</label>
                    <select id="status" name="status" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                        @foreach ($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $session->status ?? 'upcoming') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="attendee_limit" class="block text-[#4B5563] text-[13px] font-medium mb-2">Attendee Limit</label>
                    <input id="attendee_limit" name="attendee_limit" type="number" min="1" value="{{ old('attendee_limit', $session->attendee_limit ?? '') }}" placeholder="50" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                </div>

                <div class="lg:col-span-3">
                    <label for="session_date" class="block text-[#4B5563] text-[13px] font-medium mb-2">Date</label>
                    <input id="session_date" name="session_date" type="date" value="{{ old('session_date', isset($session) ? $session->session_date?->format('Y-m-d') : \Carbon\Carbon::parse($defaultDate)->format('Y-m-d')) }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                </div>

                <div class="lg:col-span-2">
                    <label for="start_time" class="block text-[#4B5563] text-[13px] font-medium mb-2">Start Time</label>
                    <input id="start_time" name="start_time" type="time" value="{{ old('start_time', isset($session) && $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '11:00') }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                </div>

                <div class="lg:col-span-2">
                    <label for="end_time" class="block text-[#4B5563] text-[13px] font-medium mb-2">End Time</label>
                    <input id="end_time" name="end_time" type="time" value="{{ old('end_time', isset($session) && $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '11:30') }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                </div>

                <div class="lg:col-span-5">
                    <label for="team_member_id" class="block text-[#4B5563] text-[13px] font-medium mb-2">Speaker / Team Member</label>
                    <select id="team_member_id" name="team_member_id" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                        <option value="">No speaker assigned</option>
                        @foreach ($teamMembers as $member)
                            <option value="{{ $member->id }}" @selected((string) old('team_member_id', $session->team_member_id ?? '') === (string) $member->id)>{{ $member->name }}{{ $member->designation ? ' - '.$member->designation : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="grid-column: 1 / -1;">
                    <label for="description" class="block text-[#4B5563] text-[13px] font-medium mb-2">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Short description for visitors" style="width: 100%; min-height: 96px;" class="block px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">{{ old('description', $session->description ?? '') }}</textarea>

                    <div style="display: flex; justify-content: flex-end; margin-top: 16px;">
                        <button type="submit" style="min-height: 44px; white-space: nowrap;" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#4C1D95] px-5 py-2.5 text-[14px] font-bold leading-none text-white transition-colors hover:bg-[#3b1774]">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            {{ $editing ? 'Update Session' : 'Save Session' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between border-b border-gray-200 mb-6 pb-2">
            <nav class="-mb-2 flex gap-6 overflow-x-auto pb-2">
                @foreach ($tabs as $value => $label)
                    @php $active = ($activeStatus ?? 'all') === $value; @endphp
                    <a href="{{ route('company.booth-setup.sessions.index', ['booking' => $booking, 'status' => $value, 'sort' => $activeSort ?? 'upcoming']) }}" class="shrink-0 border-b-2 {{ $active ? 'border-[#4C1D95] text-[#4C1D95] font-bold' : 'border-transparent text-gray-500 font-medium hover:text-gray-700' }} px-1 pb-3 pt-2 text-[14px]">
                        {{ $label }} ({{ $sessionCounts[$value] ?? 0 }})
                    </a>
                @endforeach
            </nav>
            <form method="GET" action="{{ route('company.booth-setup.sessions.index', $booking) }}" class="flex items-center pb-2">
                <input type="hidden" name="status" value="{{ $activeStatus ?? 'all' }}">
                <label for="sort" class="text-gray-500 text-[13px] mr-2 font-medium">Sort by:</label>
                <select id="sort" name="sort" onchange="this.form.submit()" class="block w-[160px] px-3 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] font-medium focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                    <option value="upcoming" @selected(($activeSort ?? 'upcoming') === 'upcoming')>Upcoming</option>
                    <option value="oldest" @selected(($activeSort ?? 'upcoming') === 'oldest')>Oldest</option>
                    <option value="title" @selected(($activeSort ?? 'upcoming') === 'title')>Title</option>
                    <option value="created" @selected(($activeSort ?? 'upcoming') === 'created')>Recently Created</option>
                </select>
            </form>
        </div>

        <div class="border border-gray-100 rounded-xl bg-white overflow-hidden mb-6">
            <div class="hidden lg:grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                <div class="col-span-4"><span class="text-[#1E1B4B] font-bold text-[14px]">Session Details</span></div>
                <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Date & Time</span></div>
                <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Speaker</span></div>
                <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Type</span></div>
                <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Limit</span></div>
                <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Status</span></div>
                <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Actions</span></div>
            </div>

            @forelse ($sessions as $item)
                @php
                    $type = $item->type ?? 'live_demo';
                    $status = $item->status ?? 'upcoming';
                    $member = $item->teamMember;
                @endphp
                <div class="grid grid-cols-1 gap-4 border-b border-gray-100 p-5 last:border-b-0 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-4 flex items-start pr-2">
                        <div class="w-12 h-12 rounded-xl {{ $iconStyles[$type] ?? $iconStyles['live_demo'] }} flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $typeIcons[$type] ?? $typeIcons['live_demo'] }}"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5 truncate">{{ $item->title }}</h4>
                            <p class="text-[#6B7280] text-[13px] line-clamp-2">{{ $item->description ?: 'No description added.' }}</p>
                        </div>
                    </div>
                    <div class="lg:col-span-2">
                        <p class="text-[#4B5563] text-[13px] mb-1 font-medium">{{ $item->session_date?->format('M d, Y') }}</p>
                        <p class="text-[#6B7280] text-[12px]">{{ $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('h:i A') : '--' }} - {{ $item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('h:i A') : '--' }}</p>
                    </div>
                    <div class="lg:col-span-2">
                        <p class="text-[#4B5563] text-[13px] mb-1 font-medium">{{ $member?->name ?? 'No speaker assigned' }}</p>
                        <p class="text-[#6B7280] text-[12px]">{{ $member?->designation ?? 'Team member not selected' }}</p>
                    </div>
                    <div class="lg:col-span-1 flex lg:justify-center">
                        <span class="inline-flex max-w-full whitespace-nowrap rounded-md border px-3 py-1 text-[11px] font-bold {{ $typeStyles[$type] ?? $typeStyles['live_demo'] }}">{{ $typeLabels[$type] ?? ucfirst($type) }}</span>
                    </div>
                    <div class="lg:col-span-1 lg:text-center">
                        <span class="text-[#4B5563] text-[14px] font-medium">{{ $item->attendee_limit ?: 'Open' }}</span>
                    </div>
                    <div class="lg:col-span-1 flex lg:justify-center">
                        <span class="inline-flex max-w-full whitespace-nowrap rounded-md border px-3 py-1 text-[11px] font-bold {{ $statusStyles[$status] ?? $statusStyles['upcoming'] }}">{{ $statusLabels[$status] ?? ucfirst($status) }}</span>
                    </div>
                    <div class="lg:col-span-1 flex lg:justify-center gap-1 flex-wrap">
                        @php $meetUrl = $item->companyMeeting?->zoom_join_url ?: $item->companyMeeting?->meeting_link; @endphp
                        @if (in_array($status, ['upcoming', 'live'], true))
                            <form method="POST" action="{{ route('company.booth-setup.sessions.create-meet', [$booking, $item]) }}">
                                @csrf
                                <button type="submit" class="px-2 py-1 text-[10px] font-bold rounded border border-indigo-200 text-indigo-700 hover:bg-indigo-50" title="Create Google Meet link">{{ $meetUrl ? 'Meet ready' : 'Create Meet' }}</button>
                            </form>
                            <form method="POST" action="{{ route('company.booth-setup.sessions.start-conference', [$booking, $item]) }}">
                                @csrf
                                <button type="submit" class="px-2 py-1 text-[10px] font-bold rounded bg-green-600 text-white hover:bg-green-700" title="Start conference as host">Start</button>
                            </form>
                        @endif
                        <a href="{{ route('company.booth-setup.sessions.edit', [$booking, $item]) }}#sessionForm" class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50" title="Edit session">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form method="POST" action="{{ route('company.booth-setup.sessions.destroy', [$booking, $item]) }}" onsubmit="return confirm('Delete this session?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50" title="Delete session">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-14 text-center">
                    <div class="w-14 h-14 rounded-xl bg-[#F5F3FF] text-[#4C1D95] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-[#1E1B4B] font-bold text-[16px] mb-1">No sessions found</h3>
                    <p class="text-[#6B7280] text-[14px]">Create a live demo, webinar, talk, or Q&A session for this booth.</p>
                </div>
            @endforelse
        </div>

        <div class="flex flex-col gap-4 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-[#6B7280] text-[14px]">Showing {{ $sessions->count() }} of {{ $sessionCounts['all'] ?? $sessions->count() }} sessions</p>
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center rounded-lg bg-[#F8FAFC] border border-gray-100 px-3 py-2 text-[13px] font-semibold text-[#4B5563]">Upcoming: {{ $sessionCounts['upcoming'] ?? 0 }}</span>
                <span class="inline-flex items-center rounded-lg bg-[#F8FAFC] border border-gray-100 px-3 py-2 text-[13px] font-semibold text-[#4B5563]">Live: {{ $sessionCounts['live'] ?? 0 }}</span>
                <span class="inline-flex items-center rounded-lg bg-[#F8FAFC] border border-gray-100 px-3 py-2 text-[13px] font-semibold text-[#4B5563]">Completed: {{ $sessionCounts['completed'] ?? 0 }}</span>
            </div>
        </div>

        <div class="flex justify-end mt-10 border-t border-gray-100 pt-8">
            <a href="{{ route('company.booth-setup.preview', $booking) }}" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D] sm:w-auto">
                Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const conferenceToggle = document.getElementById('allow_conference');
    const conferenceField = document.getElementById('conferenceCapacityField');

    if (!conferenceToggle || !conferenceField) {
        return;
    }

    const syncConferenceField = () => {
        conferenceField.classList.toggle('hidden', !conferenceToggle.checked);
    };

    conferenceToggle.addEventListener('change', syncConferenceField);
    syncConferenceField();
});
</script>
@endpush
