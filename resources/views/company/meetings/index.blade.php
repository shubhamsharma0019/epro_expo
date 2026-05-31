@extends('layouts.company')

@section('title', 'Meetings')
@section('page-title', 'Meetings')

@section('content')
<section class="max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Manage Meetings</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Track scheduled buyer meetings and booth appointments.</p>
    </div>

    <div class="space-y-4">
        @forelse ($meetings as $meeting)
            @php
                $time = $meeting->companyMeeting ? \Carbon\Carbon::parse($meeting->companyMeeting->start_time)->format('M d, h:i A') : '';
                $title = $meeting->companyMeeting ? $meeting->companyMeeting->title : 'Meeting Appointment';
            @endphp
            <a href="{{ route('company.meetings.show', $meeting->id) }}" class="block rounded-xl border border-borderColor bg-white p-5 shadow-sm hover:border-purple">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-[19px] font-semibold text-navy">{{ $title }}</h2>
                        <p class="mt-2 text-[15px] font-medium text-[#34405F]">
                            {{ $meeting->visitor_name }} <span class="mx-2">&bull;</span> {{ $time }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Requested: {{ $meeting->created_at->format('M d, Y') }}</p>
                    </div>
                    <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold 
                        {{ $meeting->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : ($meeting->status === 'confirmed' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700') }}">
                        {{ ucfirst($meeting->status) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="rounded-xl border border-borderColor bg-white p-8 text-center text-gray-500">
                No meetings scheduled yet.
            </div>
        @endforelse
    </div>
</section>
@endsection
