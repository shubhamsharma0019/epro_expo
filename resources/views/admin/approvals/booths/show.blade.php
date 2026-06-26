@extends('layouts.admin')

@section('title', 'Review Booth')
@section('page-title', 'Review Booth')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <a href="{{ route('admin.booth-approvals.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#3D1B9B] hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Back to approvals
        </a>

        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-[28px] font-bold text-[#0B132C]">Review Booth</h1>
            <p class="mt-2 text-[14px] text-gray-500">{{ $publishRequest->boothBooking->company->company_name ?? 'Company' }} | Booth {{ $publishRequest->boothBooking->booth->booth_number ?? '--' }}</p>
            
            <div class="my-6 rounded-xl bg-gray-50 p-4 text-[14px] text-gray-700">
                Status: <strong class="text-[#0B132C]">{{ ucfirst($publishRequest->status) }}</strong>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <form method="POST" action="{{ route('admin.booth-approvals.approve', $publishRequest) }}">
                    @csrf
                    <button class="w-full sm:w-auto rounded-xl bg-[#3D1B9B] hover:bg-[#2F1480] px-6 py-3 text-sm font-bold text-white shadow-sm transition">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.booth-approvals.reject', $publishRequest) }}" class="flex flex-1 flex-col sm:flex-row gap-3">
                    @csrf
                    <input name="rejection_reason" required placeholder="Rejection reason" class="flex-1 rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-[#3D1B9B] focus:outline-none">
                    <button class="w-full sm:w-auto rounded-xl border border-red-200 bg-white hover:bg-red-50 px-6 py-3 text-sm font-bold text-red-600 transition">Reject</button>
                </form>
            </div>
        </div>
    </section>
@endsection

