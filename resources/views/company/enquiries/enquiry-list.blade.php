@extends('layouts.company')

@section('title', 'Enquiries')
@section('page-title', 'Enquiries')

@section('content')
<section class="max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="company-page-title font-semibold text-navy">Manage Enquiries</h1>
        <p class="company-page-subtitle mt-3 font-medium text-[#34405F]">Review visitor and buyer enquiries from your exhibition booth.</p>
    </div>

    <div class="space-y-4">
        @forelse ($enquiries as $enquiry)
            <a href="{{ route('company.enquiries.show', $enquiry->id) }}" class="block rounded-xl border border-borderColor bg-white p-5 shadow-sm hover:border-purple">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-[19px] font-semibold text-navy">{{ $enquiry->name }}</h2>
                        <p class="mt-2 text-[15px] font-medium text-[#34405F]">{{ $enquiry->subject ?: 'General Enquiry' }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $enquiry->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold 
                        {{ $enquiry->status === 'new' ? 'bg-blue-50 text-blue-700' : ($enquiry->status === 'open' ? 'bg-yellow-50 text-yellow-700' : 'bg-green-50 text-green-700') }}">
                        {{ ucfirst($enquiry->status) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="rounded-xl border border-borderColor bg-white p-8 text-center text-gray-500">
                No enquiries received yet.
            </div>
        @endforelse
    </div>
</section>
@endsection
