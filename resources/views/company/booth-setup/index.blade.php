@extends('layouts.company')

@section('title', 'Setup Booth | eproexpo')
@section('page-title', 'Setup Booth')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
<div class="w-full mx-auto max-w-[1400px]">
            @if (session('status'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
            @endif
            
            <!-- Page Header and Progress -->
            <div class="flex justify-between items-start mb-10">
                <div class="flex items-start">
                    <!-- Booth Icon -->
                    <div class="mt-1 mr-4 text-[#3D1B9B]">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L4 9v11a1 1 0 001 1h4v-6h6v6h4a1 1 0 001-1V9l-8-6z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] mb-2 tracking-tight">Setup Your Booth</h1>
                        <p class="text-[#6B7280] text-[15px]">Complete all the steps below to publish your booth and go live.</p>
                    </div>
                </div>
                
                <!-- Overall Progress Card -->
                <div class="w-[360px] border border-gray-200 rounded-xl p-4 shadow-sm bg-white">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[15px] font-bold text-[#1E1B4B]">Overall Progress</span>
                        <span class="text-[15px] font-bold text-[#1E1B4B]" id="overall-progress-text">{{ $progress ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-[#F3F4F6] rounded-full h-2.5">
                        <div class="bg-[#3D1B9B] h-2.5 rounded-full" id="overall-progress-bar" style="width: {{ $progress ?? 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Steps List Container -->
            <div class="border border-gray-200 rounded-2xl bg-white mb-10 flex flex-col overflow-hidden" id="steps-list-container">
                @foreach ($steps as $step)
                    @php
                        $links = [
                            'profile' => route('company.booth-setup.profile.edit', $booking),
                            'branding' => route('company.booth-setup.branding.edit', $booking),
                            'products' => route('company.booth-setup.products.index', $booking),
                            'documents' => route('company.booth-setup.documents.index', $booking),
                            'catalogues' => route('company.booth-setup.catalogues.index', $booking),
                            'media' => route('company.booth-setup.media.index', $booking),
                            'team' => route('company.booth-setup.team-members.index', $booking),
                            'meetings' => route('company.booth-setup.meetings.edit', $booking),
                            'sessions' => route('company.booth-setup.sessions.index', $booking),
                            'preview' => route('company.booth-setup.preview', $booking),
                            'publish' => route('company.booth-setup.publish.show', $booking),
                        ];
                        $statusClasses = [
                            'completed' => 'bg-[#E8F5E9] text-[#2E7D32] border-[#A5D6A7]',
                            'in_progress' => 'bg-[#FFF7ED] text-[#C2410C] border-[#FDBA74]',
                            'pending' => 'bg-[#F3F4F6] text-[#6B7280] border-[#E5E7EB]',
                        ];
                    @endphp
                    <a href="{{ $links[$step->step_key] ?? '#' }}" class="flex items-center justify-between border-b border-gray-100 px-6 py-5 last:border-b-0 hover:bg-[#FBFAFF]">
                        <div class="flex items-center gap-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#F4F0FF] text-[#3D1B9B] font-bold">{{ $step->sort_order }}</span>
                            <div>
                                <h3 class="text-[#1E1B4B] font-bold text-[16px]">{{ $step->step_name }}</h3>
                                <p class="text-[#6B7280] text-[13px]">Connected to booking #{{ $booking->id }}</p>
                            </div>
                        </div>
                        <span class="rounded-md border px-3 py-1 text-[12px] font-bold {{ $statusClasses[$step->status] ?? $statusClasses['pending'] }}">
                            {{ str_replace('_', ' ', ucfirst($step->status)) }}
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- Action Buttons Footer -->
            <div class="flex justify-between items-center pb-12">
                <a href="{{ route('company.bookings.show', $booking) }}" class="flex items-center text-[#3D1B9B] font-bold text-[15px] hover:underline transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Booking
                </a>
                <a href="{{ route('company.booth-setup.profile.edit', $booking) }}" class="px-8 py-3.5 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                    Continue Setup <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
</section>
@endsection
