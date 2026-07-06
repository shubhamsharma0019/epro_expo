@extends('layouts.company')

@section('title', 'Booking Services | eproexpo')
@section('page-title', 'Booking Services')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="w-full mx-auto space-y-6">
        <div class="mb-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('company.bookings.show', $booking) }}" class="mb-3 inline-flex items-center gap-2 text-[14px] font-semibold text-[#3D1B9B] hover:underline">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Booking Details
                </a>
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight">All Services</h1>
                <p class="mt-1 text-[14px] text-gray-600">
                    {{ $readOnly ? 'Services included with this booking.' : 'Review and manage add-on services for this booking.' }}
                </p>
            </div>
            <div class="rounded-xl border border-gray-100 bg-white px-5 py-4 shadow-sm">
                <p class="text-[12px] font-semibold uppercase tracking-wide text-gray-500">Selected</p>
                <p class="text-[22px] font-bold text-[#3D1B9B]">{{ $selectedCount }} / {{ $services->count() }}</p>
                <p class="mt-1 text-[14px] font-semibold text-[#1E1B4B]">{{ $currencySymbol }}{{ number_format($selectedTotal) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <div class="lg:col-span-8 space-y-3">
                @forelse ($services as $service)
                    @php
                        $selected = $bookingServices->get($service->id);
                        $serviceIcon = $service->icon ?: 'fa-regular fa-star';
                    @endphp
                    <div class="rounded-xl border bg-white p-4 sm:p-5 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] {{ $selected ? 'border-[#3D1B9B] bg-[#faf8ff]' : 'border-gray-100' }}">
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-[16px] {{ $selected ? 'bg-[#3D1B9B] text-white' : 'bg-[#f5f2ff] text-[#3D1B9B]' }}">
                                <i class="{{ $serviceIcon }}"></i>
                            </span>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-[16px] font-bold text-[#1E1B4B]">{{ $service->title }}</h2>
                                    @if ($selected)
                                        <span class="rounded-md bg-[#E8F5E9] px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-[#2E7D32]">Selected</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-[14px] leading-6 text-gray-600">
                                    {{ $service->description ?: 'Premium exhibition add-on.' }}
                                </p>
                                @if ($selected && (int) ($selected->pivot->quantity ?? 1) > 1)
                                    <p class="mt-2 text-[13px] font-medium text-gray-500">Quantity: {{ (int) $selected->pivot->quantity }}</p>
                                @endif
                            </div>

                            <div class="shrink-0 text-right">
                                <p class="text-[16px] font-bold text-[#3D1B9B]">
                                    {{ $currencySymbol }}{{ number_format((float) ($selected ? $selected->pivot->total : $service->price)) }}
                                </p>
                                @if ($selected && (float) $selected->pivot->price !== (float) $selected->pivot->total)
                                    <p class="mt-1 text-[12px] text-gray-500">{{ $currencySymbol }}{{ number_format((float) $selected->pivot->price) }} each</p>
                                @endif
                                <div class="mt-3 flex justify-end">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-md border-2 {{ $selected ? 'border-[#3D1B9B] bg-[#3D1B9B] text-white' : 'border-gray-300 bg-white text-transparent' }}">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 bg-white p-8 text-center text-[14px] text-gray-600">
                        No services are available right now.
                    </div>
                @endforelse
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-6 rounded-xl border border-gray-100 bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                    <h2 class="text-lg font-bold text-[#1E1B4B] mb-4">Selected Services ({{ $selectedCount }})</h2>

                    <div class="space-y-4">
                        @forelse ($bookingServices as $service)
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div class="mt-0.5 flex h-[18px] w-[18px] shrink-0 items-center justify-center rounded bg-[#3D1B9B]">
                                        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[14px] font-bold text-[#1E1B4B]">{{ $service->title }}</p>
                                        @if ((int) ($service->pivot->quantity ?? 1) > 1)
                                            <p class="text-[12px] text-gray-500">Qty {{ (int) $service->pivot->quantity }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="shrink-0 text-[14px] font-bold text-[#1E1B4B]">{{ $currencySymbol }}{{ number_format((float) ($service->pivot->total ?? 0)) }}</span>
                            </div>
                        @empty
                            <p class="text-[14px] text-gray-600">No extra services selected for this booking.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <div class="flex items-center justify-between text-[14px]">
                            <span class="text-gray-600">Services Total</span>
                            <span class="font-bold text-[#1E1B4B]">{{ $currencySymbol }}{{ number_format($selectedTotal) }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-[15px] font-bold">
                            <span class="text-[#1E1B4B]">Booking Total</span>
                            <span class="text-[#3D1B9B]">{{ $currencySymbol }}{{ number_format((float) $booking->total_amount, 2) }}</span>
                        </div>
                    </div>

                    @unless ($readOnly)
                        <a href="{{ route('company.booth-booking.services', ['exhibition' => $booking->exhibition?->slug]) }}"
                           class="mt-6 inline-flex h-11 w-full items-center justify-center rounded-lg bg-[#3D1B9B] text-[14px] font-bold text-white hover:bg-[#31167D]">
                            Edit Services
                        </a>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
