@php
    $ticketImage = $ticket['imageUrl'] ?? ($assetBase . '/' . $ticket['image']);
    $ticketHref = $ticket['href'] ?? url('/events/tickets/e-ticket');
@endphp

<article class="grid gap-4 border-b border-[#F0EEF8] bg-white p-3 last:border-b-0 sm:grid-cols-[100px_1fr] lg:grid-cols-[100px_1fr_92px_132px] lg:items-start">
    <img src="{{ $ticketImage }}" alt="{{ $ticket['title'] }}" class="h-[86px] w-full rounded-[6px] object-cover shadow-[0_5px_12px_rgba(31,42,106,0.09)] sm:w-[100px]">
    <div class="min-w-0">
        <div class="flex flex-wrap items-start justify-between gap-3 lg:block">
            <h3 class="text-[14px] font-extrabold leading-tight text-[#232752]">{{ $ticket['title'] }}</h3>
            <span class="{{ $ticket['status'] === 'Confirmed' ? 'bg-[#E8FFF1] text-[#1AA75A]' : 'bg-[#FFF3DF] text-[#D58A17]' }} inline-flex rounded-[4px] px-2.5 py-1 text-[10px] font-extrabold lg:hidden">{{ $ticket['status'] }}</span>
        </div>
        <p class="mt-1.5 text-[11px] font-extrabold leading-4 text-[#3D4469]">{{ $ticket['time'] }}</p>
        <p class="mt-2.5 text-[12px] font-semibold text-[#4E567A]">{{ $ticket['type'] }}</p>
        <p class="mt-2.5 text-[11px] font-extrabold text-[#5B5F7B]">Order ID: {{ $ticket['orderId'] }}</p>
    </div>
    <div class="hidden pt-1 lg:block">
        <span class="{{ $ticket['status'] === 'Confirmed' ? 'bg-[#E8FFF1] text-[#1AA75A]' : 'bg-[#FFF3DF] text-[#D58A17]' }} inline-flex rounded-[4px] px-2.5 py-1 text-[10px] font-extrabold">{{ $ticket['status'] }}</span>
    </div>
    <div class="flex flex-col gap-2 sm:col-start-2 lg:col-start-auto lg:pt-3">
        <a href="{{ $ticketHref }}" class="rounded-[6px] border border-[#CFC7F1] bg-white px-4 py-2 text-center text-[11px] font-extrabold text-[#5b2eff] shadow-[0_4px_10px_rgba(31,42,106,0.035)] transition hover:border-[#B9A8F3] hover:bg-[#F8F6FF]">View Ticket</a>
        <button class="rounded-[6px] border border-[#E7EAF3] bg-white px-4 py-2 text-[11px] font-extrabold text-[#3D4469] shadow-[0_4px_10px_rgba(31,42,106,0.025)] transition hover:border-[#CFC7F1] hover:bg-[#F8F6FF]">Add to Calendar</button>
    </div>
</article>
