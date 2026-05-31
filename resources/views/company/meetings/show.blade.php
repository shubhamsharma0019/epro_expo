@extends('layouts.company')

@section('title', 'Meeting Details')
@section('page-title', 'Meeting Details')

@section('content')
<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <div class="flex items-center justify-between mb-4">
            <span class="rounded-md px-3 py-1.5 text-[13px] font-semibold 
                {{ $meeting->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : ($meeting->status === 'confirmed' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700') }}">
                {{ ucfirst($meeting->status) }}
            </span>
            <a href="{{ route('company.meetings.index') }}" class="text-sm font-semibold text-purple hover:underline">
                Back to Meetings
            </a>
        </div>
        
        <h1 class="mt-5 text-[32px] font-semibold text-navy">
            {{ $meeting->companyMeeting ? $meeting->companyMeeting->title : 'Meeting Appointment' }}
        </h1>
        
        <div class="mt-7 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Attendee</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">{{ $meeting->visitor_name }}</p>
                <p class="text-[13px] text-gray-500">{{ $meeting->visitor_email }}</p>
            </div>
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Time Slot</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">
                    {{ $meeting->companyMeeting ? \Carbon\Carbon::parse($meeting->companyMeeting->start_time)->format('M d, Y, h:i A') : 'N/A' }}
                </p>
            </div>
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Attendee Message</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">{{ $meeting->message ?: '--' }}</p>
            </div>
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Description</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">
                    {{ $meeting->companyMeeting ? $meeting->companyMeeting->description : '--' }}
                </p>
            </div>
        </div>
        
        @if ($meeting->status === 'confirmed' && $meeting->companyMeeting && $meeting->companyMeeting->meeting_link)
            <div class="mt-7 rounded-lg border border-[#D1D5DB] bg-[#F9FAFB] p-6">
                <h3 class="text-[16px] font-semibold text-navy mb-3">
                    <i class="fa-solid fa-video text-[#2D8CFF] mr-2"></i> Zoom Meeting Link
                </h3>
                <a href="{{ $meeting->companyMeeting->meeting_link }}" target="_blank" class="text-[15px] font-medium text-[#2D8CFF] hover:underline break-all">
                    {{ $meeting->companyMeeting->meeting_link }}
                </a>
            </div>
        @endif
        
        @if ($meeting->status === 'pending')
            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}">
                    @csrf
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="inline-flex h-[50px] items-center justify-center rounded-md bg-gradient-to-r from-success to-green-600 px-7 text-[15px] font-semibold text-white">
                        Confirm Meeting
                    </button>
                </form>
                <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="inline-flex h-[50px] items-center justify-center rounded-md border border-red-200 px-7 text-[15px] font-semibold text-red-600 hover:bg-red-50">
                        Reject
                    </button>
                </form>
            </div>
        @endif
    </div>
</section>
@endsection
