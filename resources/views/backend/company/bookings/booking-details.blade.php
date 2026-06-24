@extends('layouts.company')

@section('title', 'Booking Details | eproexpo')
@section('page-title', 'Booking Details')

@section('content')
@php
    $bookingReference = 'EXPO-' . optional($booking->created_at)->format('Y') . '-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT);
    $startDate = $booking->exhibition?->start_date ? \Carbon\Carbon::parse($booking->exhibition->start_date)->format('M d, Y') : null;
    $endDate = $booking->exhibition?->end_date ? \Carbon\Carbon::parse($booking->exhibition->end_date)->format('M d, Y') : null;
    $daysCount = $bookingDays->count();
    $dateRange = $startDate && $endDate ? $startDate . ' - ' . $endDate . ($daysCount ? ' (' . $daysCount . ' Days)' : '') : 'Dates not available';
    $previewImage = $booking->boothProfile?->booth_banner ? asset('storage/' . $booking->boothProfile->booth_banner) : asset('assets/exhibition/images/booth_banner.png');
    $setupStarted = $booking->boothProfile
        || in_array($booking->booth_setup_status, [
            'setup_in_progress',
            'in_progress',
            'ready_to_publish',
            'pending_review',
            'submitted_for_review',
            'published',
            'approved',
            'live',
        ], true);
    $setupAllowed = $booking->payment_status === 'paid' && $booking->booking_status === 'confirmed' && $setupStarted;
@endphp
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="w-full mx-auto space-y-6">
        <div class="mb-8">
            <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight">Booking Details</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 sm:p-8 flex flex-col min-h-[300px] lg:h-[400px]">
                <h2 class="text-xl font-bold text-[#1E1B4B] mb-6">Booth Preview</h2>
                <div class="flex-1 flex items-center justify-center bg-white">
                    <img src="{{ $previewImage }}" alt="Booth Preview" class="max-w-full max-h-full object-contain">
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 sm:p-8 flex flex-col min-h-[300px] lg:h-[400px]">
                <h2 class="text-xl font-bold text-[#1E1B4B] mb-6 sm:mb-8">Exhibition Info</h2>
                <div class="space-y-6 sm:space-y-10">
                    <div class="grid grid-cols-[80px_1fr] sm:grid-cols-[100px_1fr] gap-4 sm:gap-12 items-start">
                        <span class="text-gray-600 text-[14px] sm:text-[15px]">Event</span>
                        <span class="font-bold text-[#3D1B9B] text-[14px] sm:text-[15px]">{{ $booking->exhibition->title ?? 'Exhibition' }}</span>
                    </div>
                    <div class="grid grid-cols-[80px_1fr] sm:grid-cols-[100px_1fr] gap-4 sm:gap-12 items-start">
                        <span class="text-gray-600 text-[14px] sm:text-[15px]">Dates</span>
                        <span class="font-bold text-[#3D1B9B] text-[14px] sm:text-[15px]">{{ $dateRange }}</span>
                    </div>
                    <div class="grid grid-cols-[80px_1fr] sm:grid-cols-[100px_1fr] gap-4 sm:gap-12 items-start">
                        <span class="text-gray-600 text-[14px] sm:text-[15px]">Venue</span>
                        <div class="flex flex-col">
                            <span class="font-bold text-[#3D1B9B] text-[14px] sm:text-[15px]">{{ $booking->exhibition->venue ?? $booking->hall->title ?? 'Venue not available' }}</span>
                            <span class="font-bold text-[#3D1B9B] text-[14px] sm:text-[15px] mt-1">{{ $booking->exhibition->location ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 sm:p-8 w-full">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-4">
                <div><p class="text-[13px] sm:text-[14px] text-gray-600 mb-2">Pavilion</p><p class="font-bold text-[#1E1B4B] text-[14px] sm:text-[15px]">{{ $booking->pavilion->title ?? 'Pavilion' }}</p></div>
                <div><p class="text-[13px] sm:text-[14px] text-gray-600 mb-2">Hall</p><p class="font-bold text-[#1E1B4B] text-[14px] sm:text-[15px]">{{ $booking->hall->title ?? 'Hall' }}</p></div>
                <div><p class="text-[13px] sm:text-[14px] text-gray-600 mb-2">Booth No.</p><p class="font-bold text-[#1E1B4B] text-[14px] sm:text-[15px]">{{ $booking->booth->booth_number ?? '--' }}</p></div>
                <div><p class="text-[13px] sm:text-[14px] text-gray-600 mb-2">Booth Size</p><p class="font-bold text-[#1E1B4B] text-[14px] sm:text-[15px]">{{ $booking->boothSize->title ?? 'Not selected' }}</p></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 sm:p-8 flex flex-col h-full min-h-[260px]">
                <h2 class="text-lg font-bold text-[#1E1B4B] mb-6">Selected Services ({{ $bookingServices->count() }})</h2>
                <div class="space-y-5">
                    @forelse ($bookingServices as $service)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-[18px] h-[18px] bg-[#3D1B9B] rounded flex items-center justify-center mr-3"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                                <span class="font-bold text-[#1E1B4B] text-[14px]">{{ $service->title ?? 'Service' }}</span>
                            </div>
                            <span class="font-bold text-[#1E1B4B] text-[15px]">&#8377;{{ number_format((float) ($service->pivot->total ?? 0)) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-600 text-[14px]">No extra services selected.</p>
                    @endforelse
                </div>
                <a href="{{ route('company.booth-booking.services') }}" class="mt-auto pt-6 text-[#3D1B9B] font-bold text-[14px] hover:underline block">View All Services</a>
            </div>

            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 sm:p-8 flex flex-col h-full">
                <h2 class="text-lg font-bold text-[#1E1B4B] mb-6">Dates & Times</h2>
                <div class="space-y-6">
                    <div><p class="font-bold text-[#3D1B9B] text-[15px] mb-2">Setup Time</p><p class="text-gray-600 text-[14px]">{{ $startDate ?? 'Not available' }} | 8:00 AM - 4:00 PM</p></div>
                    <div><p class="font-bold text-[#3D1B9B] text-[15px] mb-2">Show Time</p><p class="text-gray-600 text-[14px]">{{ $dateRange }} | 10:00 AM - 6:00 PM</p></div>
                    <div><p class="font-bold text-[#3D1B9B] text-[15px] mb-2">Last Day</p><p class="text-gray-600 text-[14px]">{{ $endDate ?? 'Not available' }} | 10:00 AM - 4:00 PM</p></div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 sm:p-8 flex flex-col h-full min-h-[260px]">
                <h2 class="text-lg font-bold text-[#1E1B4B] mb-6">Payment & Status</h2>
                <div class="space-y-5">
                    <div class="flex justify-between items-center"><span class="text-[#1E1B4B] text-[15px]">Payment Status</span><span class="px-4 py-1.5 bg-[#E8F5E9] border border-[#A5D6A7] text-[#2E7D32] text-[13px] font-medium rounded-md">{{ ucfirst($booking->payment_status ?? 'pending') }}</span></div>
                    <div class="flex justify-between items-center"><span class="text-[#1E1B4B] text-[15px]">Booking Status</span><span class="px-4 py-1.5 bg-[#E8F5E9] border border-[#A5D6A7] text-[#2E7D32] text-[13px] font-medium rounded-md">{{ ucfirst($booking->booking_status ?? 'pending') }}</span></div>
                    <div class="pt-2"><p class="text-[#1E1B4B] text-[15px] mb-1">Invoice / Booking ID</p><p class="text-gray-600 text-[14px]">{{ $bookingReference }}</p></div>
                    <div class="pt-1"><p class="text-[#1E1B4B] text-[15px] mb-1">Amount Paid</p><p class="font-bold text-[#1E1B4B] text-[16px]">&#8377;{{ number_format((float) $booking->total_amount, 2) }}</p></div>
                </div>
                <a href="{{ $booking->payment_status === 'paid' ? route('company.bookings.invoice', $booking->id) : '#' }}" target="_blank" class="mt-auto pt-6 text-[#3D1B9B] font-bold text-[14px] hover:underline block">View Payment Receipt</a>
            </div>
        </div>

        <div class="flex flex-col gap-4 sm:flex-row sm:justify-end sm:gap-6 pt-6 mb-8 w-full md:w-2/3 ml-auto">
            @if ($booking->payment_status === 'paid')
                <a href="{{ route('company.bookings.invoice', $booking->id) }}" target="_blank" class="w-full sm:w-1/2 py-3.5 border-2 border-[#E5E7EB] rounded-lg text-[#3D1B9B] font-bold text-[15px] hover:bg-gray-50 flex justify-center items-center transition-colors">Download Invoice <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></a>
            @else
                <button disabled class="w-full sm:w-1/2 py-3.5 border border-gray-200 bg-gray-50 rounded-lg text-gray-400 font-bold text-[15px] flex justify-center items-center cursor-not-allowed">No Invoice</button>
            @endif
            @if ($setupAllowed)
                <a href="{{ route('company.booth-setup.index', $booking) }}" class="w-full sm:w-1/2 py-3.5 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] flex justify-center items-center transition-colors">Continue Setup <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
            @elseif ($booking->payment_status !== 'paid')
                <a href="{{ route('company.booth-booking.payment') }}" class="w-full sm:w-1/2 py-3.5 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] flex justify-center items-center transition-colors">Complete Payment <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
            @endif
        </div>
    </div>
</section>
@endsection
