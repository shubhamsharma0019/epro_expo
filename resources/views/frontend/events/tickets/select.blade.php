@extends('layouts.frontend')

@section('title', 'Select Tickets - ' . (isset($dbEvent) ? $dbEvent->title : 'Global Tech Summit 2024'))

@section('content')
@php
    $eventSlugForOrder = isset($dbEvent) ? $dbEvent->slug : ($slug ?? 'global-tech-summit-2024');
    $eventTicketDuration = 'Event Duration';

    if (isset($dbEvent) && $dbEvent->starts_at) {
        $eventDays = $dbEvent->ends_at
            ? max(1, $dbEvent->starts_at->copy()->startOfDay()->diffInDays($dbEvent->ends_at->copy()->startOfDay()) + 1)
            : 1;
        $eventTicketDuration = $eventDays . ' ' . str('Day')->plural($eventDays);
    }
@endphp
<main class="px-4 md:px-[44px] pt-6 pb-12 flex-1 max-w-[1200px] w-full mx-auto">
            <!-- Breadcrumbs -->
            <div class="mb-8 flex items-center gap-2 text-[14px] text-[#6A708F]">
                <a href="{{ url('/events') }}" class="hover:text-[#5B35D5] transition">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings') }}" class="hover:text-[#5B35D5] transition">Events</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                @if (isset($dbEvent))
                    <a href="{{ route('events.listings.show', $dbEvent->slug) }}" class="hover:text-[#5B35D5] transition">{{ $dbEvent->title }}</a>
                @else
                    <a href="{{ url('/events/listings/global-tech-summit-2024') }}" class="hover:text-[#5B35D5] transition">Global Tech Summit 2024</a>
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-[#1F2A6A]">Select Tickets</span>
            </div>



            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column: Tickets List -->
                <div class="lg:col-span-7">
                    <div class="mb-6">
                        <h2 class="text-[22px] font-bold text-[#1F2A6A]">Select Your Tickets</h2>
                        <p class="mt-2 text-[15px] text-[#4E567A]">Choose the ticket that suits you.</p>
                    </div>

                    <div class="space-y-4">
                        @if (isset($dbEvent))
                            @foreach ($dbEvent->ticketTypes as $ticketType)
                                @php $key = Str::slug($ticketType->name); @endphp
                                <div id="card-{{ $key }}" onclick="selectPass('{{ $key }}')" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] cursor-pointer">
                                    <div class="flex items-start gap-5">
                                        <div id="radio-{{ $key }}" class="h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition mt-1"></div>
                                        <div id="icon-wrapper-{{ $key }}" class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#5B35D5] transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-[16px] font-bold text-[#1F2A6A]">{{ $ticketType->name }}</h4>
                                            <p class="mt-1.5 text-[14px] text-[#4E567A]">{{ $ticketType->description ?? 'Access to event sessions' }}</p>
                                            <div class="mt-2 flex items-center gap-1.5 text-[13px] text-[#6A708F]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <span>{{ $eventTicketDuration }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-row items-center justify-between sm:flex-col sm:items-end gap-3 border-t border-gray-100 pt-3 sm:border-t-0 sm:pt-0">
                                        <span class="text-[18px] font-bold text-[#1F2A6A]">{{ $ticketType->currency }} {{ number_format($ticketType->price, 2) }}</span>
                                        <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                                            <button onclick="updateQty('{{ $key }}', -1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-l-lg">&minus;</button>
                                            <span id="qty-{{ $key }}" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">0</span>
                                            <button onclick="updateQty('{{ $key }}', 1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-r-lg">&plus;</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- General Pass -->
                            <div id="card-general" onclick="selectPass('general')" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#5B35D5] bg-[#FBFAFE] p-5 shadow-[0_2px_10px_rgba(91,53,213,0.05)] transition cursor-pointer">
                                <div class="flex items-start gap-5">
                                    <div id="radio-general" class="flex h-5 w-5 items-center justify-center rounded-full border-2 border-[#5B35D5] bg-white transition mt-1">
                                        <div class="h-2.5 w-2.5 rounded-full bg-[#5B35D5]"></div>
                                    </div>
                                    <div id="icon-wrapper-general" class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#5B35D5] text-white transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[16px] font-bold text-[#1F2A6A]">General Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#4E567A]">Access to all sessions</p>
                                        <div class="mt-2 flex items-center gap-1.5 text-[13px] text-[#6A708F]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <span>1 Day</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row items-center justify-between sm:flex-col sm:items-end gap-3 border-t border-gray-100 pt-3 sm:border-t-0 sm:pt-0">
                                    <span class="text-[18px] font-bold text-[#1F2A6A]">₹49.00</span>
                                    <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                                        <button onclick="updateQty('general', -1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-l-lg">&minus;</button>
                                        <span id="qty-general" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">2</span>
                                        <button onclick="updateQty('general', 1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-r-lg">&plus;</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Premium Pass -->
                            <div id="card-premium" onclick="selectPass('premium')" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] cursor-pointer">
                                <div class="flex items-start gap-5">
                                    <div id="radio-premium" class="h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition mt-1"></div>
                                    <div id="icon-wrapper-premium" class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#5B35D5] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[16px] font-bold text-[#1F2A6A]">Premium Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#4E567A]">Access to all sessions + Workshop</p>
                                        <div class="mt-2 flex items-center gap-1.5 text-[13px] text-[#6A708F]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <span>1 Day</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row items-center justify-between sm:flex-col sm:items-end gap-3 border-t border-gray-100 pt-3 sm:border-t-0 sm:pt-0">
                                    <span class="text-[18px] font-bold text-[#1F2A6A]">₹99.00</span>
                                    <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                                        <button onclick="updateQty('premium', -1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-l-lg">&minus;</button>
                                        <span id="qty-premium" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">0</span>
                                        <button onclick="updateQty('premium', 1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-r-lg">&plus;</button>
                                    </div>
                                </div>
                            </div>

                            <!-- VIP Pass -->
                            <div id="card-vip" onclick="selectPass('vip')" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] cursor-pointer">
                                <div class="flex items-start gap-5">
                                    <div id="radio-vip" class="h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition mt-1"></div>
                                    <div id="icon-wrapper-vip" class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#5B35D5] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6v.75h2a.25.25 0 0 1 .25.25v1.5a.25.25 0 0 1-.25.25h-4.5a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h3a2.25 2.25 0 0 1 2.25 2.25v1.5A2.25 2.25 0 0 1 13.5 15h-1.5v.75a.75.75 0 0 1-1.5 0V15h-2a.25.25 0 0 1-.25-.25v-1.5a.25.25 0 0 1 .25-.25h4.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25h-3A2.25 2.25 0 0 1 7.5 9.75v-1.5A2.25 2.25 0 0 1 9.75 6h1.5V5.25a.75.75 0 0 1 1.5 0V6Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[16px] font-bold text-[#1F2A6A]">VIP Pass</h4>
                                        <p class="mt-1.5 text-[14px] leading-tight text-[#4E567A]">Access to all sessions + Workshop<br>+ VIP Lounge</p>
                                        <div class="mt-2 flex items-center gap-1.5 text-[13px] text-[#6A708F]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <span>1 Day</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row items-center justify-between sm:flex-col sm:items-end gap-3 border-t border-gray-100 pt-3 sm:border-t-0 sm:pt-0">
                                    <span class="text-[18px] font-bold text-[#1F2A6A]">₹149.00</span>
                                    <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                                        <button onclick="updateQty('vip', -1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-l-lg">&minus;</button>
                                        <span id="qty-vip" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">0</span>
                                        <button onclick="updateQty('vip', 1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-r-lg">&plus;</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Student Pass -->
                            <div id="card-student" onclick="selectPass('student')" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] cursor-pointer">
                                <div class="flex items-start gap-5">
                                    <div id="radio-student" class="h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition mt-1"></div>
                                    <div id="icon-wrapper-student" class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#5B35D5] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[16px] font-bold text-[#1F2A6A]">Student Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#4E567A]">Access for students with valid ID</p>
                                        <div class="mt-2 flex items-center gap-1.5 text-[13px] text-[#6A708F]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <span>1 Day</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row items-center justify-between sm:flex-col sm:items-end gap-3 border-t border-gray-100 pt-3 sm:border-t-0 sm:pt-0">
                                    <span class="text-[18px] font-bold text-[#1F2A6A]">₹29.00</span>
                                    <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                                        <button onclick="updateQty('student', -1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-l-lg">&minus;</button>
                                        <span id="qty-student" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">0</span>
                                        <button onclick="updateQty('student', 1, event)" class="flex h-9 w-9 items-center justify-center text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5] rounded-r-lg">&plus;</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-5">
                    <div class="rounded-[20px] border border-[#E8E3F0] bg-[#FAFAFC] p-8 sticky top-8">
                        <h3 class="mb-7 text-[20px] font-bold text-[#1F2A6A]">Order Summary</h3>
                        
                        <div class="space-y-6 border-b border-[#E8E3F0] pb-7">
                            @if (isset($dbEvent))
                                @foreach ($dbEvent->ticketTypes as $ticketType)
                                    @php $key = Str::slug($ticketType->name); @endphp
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-[15px] font-semibold text-[#2B3263]">{{ $ticketType->name }}</h4>
                                            <p class="mt-1.5 text-[14px] text-[#6A708F]">{{ $ticketType->currency }} {{ number_format($ticketType->price, 2) }} &times; <span id="summary-qty-{{ $key }}">0</span></p>
                                        </div>
                                        <span class="text-[15px] font-bold text-[#1F2A6A]" id="summary-total-{{ $key }}">₹0.00</span>
                                    </div>
                                @endforeach
                            @else
                                <!-- Summary Item: General -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#2B3263]">General Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#6A708F]">₹49.00 &times; <span id="summary-qty-general">2</span></p>
                                    </div>
                                    <span class="text-[15px] font-bold text-[#1F2A6A]" id="summary-total-general">₹98.00</span>
                                </div>
                                
                                <!-- Summary Item: Premium -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#2B3263]">Premium Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#6A708F]">₹99.00 &times; <span id="summary-qty-premium">0</span></p>
                                    </div>
                                    <span class="text-[15px] font-bold text-[#1F2A6A]" id="summary-total-premium">₹0.00</span>
                                </div>
                                
                                <!-- Summary Item: VIP -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#2B3263]">VIP Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#6A708F]">₹149.00 &times; <span id="summary-qty-vip">0</span></p>
                                    </div>
                                    <span class="text-[15px] font-bold text-[#1F2A6A]" id="summary-total-vip">₹0.00</span>
                                </div>
                                
                                <!-- Summary Item: Student -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#2B3263]">Student Pass</h4>
                                        <p class="mt-1.5 text-[14px] text-[#6A708F]">₹29.00 &times; <span id="summary-qty-student">0</span></p>
                                    </div>
                                    <span class="text-[15px] font-bold text-[#1F2A6A]" id="summary-total-student">₹0.00</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-7 space-y-5">
                            <div class="flex items-center justify-between">
                                <span class="text-[15px] font-medium text-[#4E567A]">Total Tickets</span>
                                <span class="text-[16px] font-bold text-[#1F2A6A]" id="total-tickets">2</span>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-[16px] font-bold text-[#1F2A6A]">Total Amount</span>
                                <span class="text-[26px] font-extrabold text-[#1F2A6A]" id="total-amount">₹98.00</span>
                            </div>
                        </div>
                        
                        <button onclick="proceedToNext()" class="mt-8 w-full rounded-xl bg-[#4318FF] py-4 text-[16px] font-bold text-white transition hover:bg-[#3412C9] shadow-[0_8px_20px_rgba(67,24,255,0.25)]">
                            Continue
                        </button>
                    </div>
                </div>
            </div>

        </main>
@endsection


@push('scripts')
<script>
@if (isset($dbEvent))
const prices = {
    @foreach ($dbEvent->ticketTypes as $ticketType)
        '{{ Str::slug($ticketType->name) }}': {{ $ticketType->price }},
    @endforeach
};
const quantities = {
    @foreach ($dbEvent->ticketTypes as $ticketType)
        '{{ Str::slug($ticketType->name) }}': 0,
    @endforeach
};
const maxQuantities = {
    @foreach ($dbEvent->ticketTypes as $ticketType)
        '{{ Str::slug($ticketType->name) }}': {{ max(0, (int) ($ticketType->quantity_total ?? 0) - (int) ($ticketType->quantity_sold ?? 0)) ?: 'Number.MAX_SAFE_INTEGER' }},
    @endforeach
};
const currencyLabel = '{{ $dbEvent->ticketTypes->first()?->currency ?? 'INR' }}';
@else
const prices = {
            general: 49.00,
            premium: 99.00,
            vip: 149.00,
            student: 29.00
        };
        const quantities = {
            general: 2,
            premium: 0,
            vip: 0,
            student: 0
        };
        const maxQuantities = {
            general: Number.MAX_SAFE_INTEGER,
            premium: Number.MAX_SAFE_INTEGER,
            vip: Number.MAX_SAFE_INTEGER,
            student: Number.MAX_SAFE_INTEGER
        };
        const currencyLabel = "₹";
@endif

        function selectPass(type) {
            // Make passes mutually exclusive (radio button behavior)
            for (const key in quantities) {
                if (key !== type && quantities[key] > 0) {
                    quantities[key] = 0;
                    updateUI(key);
                }
            }
            
            // If this pass has 0 quantity, set it to 1
            if (quantities[type] === 0) {
                quantities[type] = 1;
            }
            
            updateUI(type);
            calculateTotals();
        }

        function updateQty(type, delta, event) {
            if (event) event.stopPropagation();
            
            if (quantities[type] + delta < 0) return;
            if (delta > 0 && quantities[type] >= maxQuantities[type]) return;
            
            // If we are adding a ticket to a new type, zero out the others
            if (delta > 0) {
                for (const key in quantities) {
                    if (key !== type && quantities[key] > 0) {
                        quantities[key] = 0;
                        updateUI(key);
                    }
                }
            }
            
            quantities[type] += delta;
            updateUI(type);
            calculateTotals();
        }
        
        function updateUI(type) {
            // Update counter in list
            if (document.getElementById(`qty-${type}`)) {
                document.getElementById(`qty-${type}`).innerText = quantities[type];
            }
            
            // Update order summary
            if (document.getElementById(`summary-qty-${type}`)) {
                document.getElementById(`summary-qty-${type}`).innerText = quantities[type];
            }
            if (document.getElementById(`summary-total-${type}`)) {
                document.getElementById(`summary-total-${type}`).innerText = currencyLabel + " " + (prices[type] * quantities[type]).toFixed(2);
            }
            
            // Update UI styling for active/inactive ticket card
            const card = document.getElementById(`card-${type}`);
            const radio = document.getElementById(`radio-${type}`);
            const iconWrapper = document.getElementById(`icon-wrapper-${type}`);
            
            if (quantities[type] > 0) {
                if (card) card.className = "flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#5B35D5] bg-[#FBFAFE] p-5 shadow-[0_2px_10px_rgba(91,53,213,0.05)] transition cursor-pointer";
                if (radio) {
                    radio.innerHTML = '<div class="h-2.5 w-2.5 rounded-full bg-[#5B35D5]"></div>';
                    radio.className = "flex h-5 w-5 items-center justify-center rounded-full border-2 border-[#5B35D5] bg-white transition";
                }
                if (iconWrapper) iconWrapper.className = "flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#5B35D5] text-white transition";
            } else {
                if (card) card.className = "flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] cursor-pointer";
                if (radio) {
                    radio.innerHTML = '';
                    radio.className = "h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition";
                }
                if (iconWrapper) iconWrapper.className = "flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#5B35D5] transition";
            }
        }

        function calculateTotals() {
            let totalQty = 0;
            let totalAmt = 0;
            for(const key in quantities) {
                totalQty += quantities[key];
                totalAmt += quantities[key] * prices[key];
            }
            if (document.getElementById("total-tickets")) {
                document.getElementById("total-tickets").innerText = totalQty;
            }
            if (document.getElementById("total-amount")) {
                document.getElementById("total-amount").innerText = currencyLabel + " " + totalAmt.toFixed(2);
            }
        }
        
        function proceedToNext() {
            let totalQty = 0;
            let totalAmt = 0;
            let activePass = null;
            
            for(const key in quantities) {
                if (quantities[key] > 0) {
                    totalQty += quantities[key];
                    totalAmt += quantities[key] * prices[key];
                    activePass = key;
                }
            }
            
            if (totalQty === 0) {
                alert("Please select at least one ticket to continue.");
                return;
            }
            
            // Save to localStorage to pass data to the next screen
            let passName = activePass.charAt(0).toUpperCase() + activePass.slice(1) + " Pass";
            @if (isset($dbEvent))
                @foreach ($dbEvent->ticketTypes as $ticketType)
                    if (activePass === '{{ Str::slug($ticketType->name) }}') {
                        passName = '{{ $ticketType->name }}';
                    }
                @endforeach
            @endif

            const orderData = {
                eventSlug: '{{ $eventSlugForOrder }}',
                passType: activePass,
                passName: passName,
                quantity: totalQty,
                price: prices[activePass],
                priceCurrency: currencyLabel,
                totalAmount: totalAmt
            };
            localStorage.setItem("eventOrder", JSON.stringify(orderData));
            
            const targetUrl = "{{ url('/events/tickets/attendee-details') }}?event=" + encodeURIComponent(orderData.eventSlug);
            window.location.href = targetUrl;
        }
        
        // Initial setup
        for(const key in quantities) {
            updateUI(key);
        }
        calculateTotals();
</script>
@endpush
