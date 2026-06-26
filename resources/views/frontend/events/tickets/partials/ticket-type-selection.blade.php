@php
    $eventTicketDuration = $eventTicketDuration ?? 'Event Duration';
@endphp
<div id="ticket-selection-section" class="mb-8">
    <div class="mb-6">
        <h2 class="text-[22px] font-bold text-[#1F2A6A]">Select Your Tickets</h2>
        <p class="mt-2 text-[15px] text-[#4E567A]">Choose your ticket type, then fill in attendee details below.</p>
    </div>

    <div id="ticket-cards-container" class="space-y-4">
        @if (isset($dbEvent) && $dbEvent->ticketTypes->isNotEmpty())
            @foreach ($dbEvent->ticketTypes as $ticketType)
                @php $key = Str::slug($ticketType->name); @endphp
                <div id="card-{{ $key }}" onclick="selectPass('{{ $key }}')" class="flex cursor-pointer flex-col gap-4 rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-5">
                        <div id="radio-{{ $key }}" class="mt-1 h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition"></div>
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
                    <div class="flex flex-row items-center justify-between gap-3 border-t border-gray-100 pt-3 sm:flex-col sm:items-end sm:border-t-0 sm:pt-0">
                        <span class="text-[18px] font-bold text-[#1F2A6A]">{{ $ticketType->currency }} {{ number_format($ticketType->price, 2) }}</span>
                        <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                            <button type="button" onclick="updateQty('{{ $key }}', -1, event)" class="flex h-9 w-9 items-center justify-center rounded-l-lg text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5]">&minus;</button>
                            <span id="qty-{{ $key }}" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">0</span>
                            <button type="button" onclick="updateQty('{{ $key }}', 1, event)" class="flex h-9 w-9 items-center justify-center rounded-r-lg text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5]">&plus;</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div id="card-general" onclick="selectPass('general')" class="flex cursor-pointer flex-col gap-4 rounded-xl border border-[#5B35D5] bg-[#FBFAFE] p-5 shadow-[0_2px_10px_rgba(91,53,213,0.05)] transition sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-5">
                    <div id="radio-general" class="mt-1 flex h-5 w-5 items-center justify-center rounded-full border-2 border-[#5B35D5] bg-white transition">
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
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between gap-3 border-t border-gray-100 pt-3 sm:flex-col sm:items-end sm:border-t-0 sm:pt-0">
                    <span class="text-[18px] font-bold text-[#1F2A6A]">₹49.00</span>
                    <div class="flex items-center rounded-lg border border-[#E8E3F0] bg-white">
                        <button type="button" onclick="updateQty('general', -1, event)" class="flex h-9 w-9 items-center justify-center rounded-l-lg text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5]">&minus;</button>
                        <span id="qty-general" class="flex h-9 w-10 items-center justify-center border-x border-[#E8E3F0] text-[15px] font-semibold text-[#1F2A6A]">1</span>
                        <button type="button" onclick="updateQty('general', 1, event)" class="flex h-9 w-9 items-center justify-center rounded-r-lg text-[18px] text-[#6A708F] transition hover:bg-[#F4F0FF] hover:text-[#5B35D5]">&plus;</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
