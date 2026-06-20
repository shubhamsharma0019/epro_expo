@extends('layouts.company')

@section('title', 'Enquiry Details')
@section('page-title', 'Enquiry Details')

@section('content')
<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <div class="flex items-center justify-between">
            <span class="rounded-md px-3 py-1.5 text-[13px] font-semibold 
                {{ $enquiry->status === 'new' ? 'bg-blue-50 text-blue-700' : ($enquiry->status === 'open' ? 'bg-yellow-50 text-yellow-700' : 'bg-green-50 text-green-700') }}">
                {{ ucfirst($enquiry->status) }}
            </span>
            <a href="{{ route('company.enquiries.index') }}" class="text-sm font-semibold text-purple hover:underline">
                Back to Enquiries
            </a>
        </div>
        
        <h1 class="mt-5 text-[32px] font-semibold text-navy">{{ $enquiry->subject ?: 'General Enquiry' }}</h1>
        <p class="mt-3 text-[15px] font-medium text-[#5A6480]">
            From <strong>{{ $enquiry->name }}</strong> ({{ $enquiry->email }}{{ $enquiry->phone ? ' | ' . $enquiry->phone : '' }})
        </p>
        
        <div class="mt-7 rounded-lg border border-borderColor bg-[#F8F9FD] p-5 text-[15px] font-medium leading-7 text-[#34405F]">
            {{ $enquiry->message }}
        </div>

        @if ($enquiry->status === 'replied')
            <div class="mt-6 rounded-lg bg-green-50 border border-green-200 p-4 text-[14px] text-green-800 font-medium">
                <i class="fa-solid fa-circle-check mr-2"></i> You have replied to this enquiry.
            </div>
        @endif

        <form method="POST" action="{{ route('company.enquiries.reply', $enquiry->id) }}" class="mt-6">
            @csrf
            <textarea name="message" rows="5" required placeholder="Write reply..." class="w-full rounded-md border border-borderColor px-4 py-3 text-[15px] font-medium outline-none focus:border-purple"></textarea>
            @error('message')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
            <button type="submit" class="mt-5 inline-flex h-[50px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[15px] font-semibold text-white hover:from-[#4b1eff] hover:to-[#3300c8] transition-all">
                Send Reply
            </button>
        </form>
    </div>
</section>
@endsection
