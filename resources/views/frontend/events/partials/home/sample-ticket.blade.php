<div class="rounded-[8px] border border-[#F0EEF8] bg-white px-5 py-5 shadow-[0_12px_28px_rgba(31,42,106,0.055)]">
    <h2 class="mb-5 text-[20px] font-extrabold leading-none tracking-[-0.01em] text-[#191D4D]">Sample E-Ticket</h2>

    @if ($sampleTicket)
        <div class="relative overflow-hidden rounded-[15px] border-2 border-[#D8D2F0] bg-white shadow-[0_7px_16px_rgba(31,42,106,0.045)]">
            <span class="absolute left-[-13px] top-[58%] z-20 h-8 w-8 -translate-y-1/2 rounded-full border-2 border-[#D8D2F0] bg-white"></span>
            <span class="absolute right-[27%] top-[-15px] z-20 hidden h-8 w-8 rounded-full border-2 border-[#D8D2F0] bg-white lg:block"></span>
            <span class="absolute bottom-[-15px] right-[27%] z-20 hidden h-8 w-8 rounded-full border-2 border-[#D8D2F0] bg-white lg:block"></span>
            <span class="absolute bottom-[46px] left-0 right-0 z-10 h-px bg-[#D8D2F0] lg:hidden"></span>

            <div class="grid min-h-[286px] lg:grid-cols-[1fr_27%]">
                <div class="px-7 pb-[72px] pt-6 sm:px-9">
                    <div class="flex items-center gap-3">
                        <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-9 w-9 rounded-[13px] text-[17px]" title-class="text-[21px] text-[#071044]" subtitle-class="text-[9px] text-[#8A94AD]" />
                    </div>

                    <h3 class="mt-6 text-[22px] font-extrabold leading-tight tracking-[-0.01em] text-[#171B47]">{{ $sampleTicket['title'] }}</h3>

                    <div class="mt-7 grid gap-x-10 gap-y-5 text-[11px] font-extrabold text-[#3D4469] sm:grid-cols-2">
                        <p><span class="mb-1.5 block text-[10px] font-extrabold text-[#656B8A]">Date</span>{{ $sampleTicket['date'] }}</p>
                        <p><span class="mb-1.5 block text-[10px] font-extrabold text-[#656B8A]">Time</span>{{ $sampleTicket['time'] }}</p>
                        <p><span class="mb-1.5 block text-[10px] font-extrabold text-[#656B8A]">Type</span>{{ $sampleTicket['type'] }}</p>
                        <p class="hidden sm:block"></p>
                        <p><span class="mb-1.5 block text-[10px] font-extrabold text-[#656B8A]">Ticket Holder</span>{{ $sampleTicket['holder'] }}</p>
                        <p><span class="mb-1.5 block text-[10px] font-extrabold text-[#656B8A]">Order ID</span>{{ $sampleTicket['orderId'] }}</p>
                    </div>
                </div>

                <div class="relative flex min-h-[220px] flex-col items-center justify-center border-t-2 border-dashed border-[#B9A8F3] px-5 pb-[72px] pt-7 lg:border-l-2 lg:border-t-0">
                    <x-shared.qr-ticket-card
                        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&margin=8&data={{ urlencode($sampleTicket['qrData']) }}"
                        alt="{{ $sampleTicket['title'] }} ticket QR code"
                        label="SCAN AT ENTRY"
                        size-class="h-[118px] w-[118px]"
                        card-class="rounded-[22px] px-4 pb-5 pt-4 shadow-[0_10px_24px_rgba(31,42,106,0.08)]"
                    />
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 grid overflow-hidden rounded-b-[15px] bg-gradient-to-r from-[#642DFF] to-[#4318D7] lg:grid-cols-[1fr_27%]">
                <p class="px-7 py-3 text-[11px] font-semibold leading-4 text-white sm:px-9">
                    Thank you for your booking!<br>
                    Join us on time and enjoy the event.
                </p>
                <span class="hidden border-l-2 border-dashed border-white/45 lg:block"></span>
            </div>
        </div>
    @else
        <div class="rounded-[15px] border border-dashed border-[#D8D2F0] bg-[#FBFCFF] px-6 py-10 text-center">
            <p class="text-[14px] font-extrabold text-[#171B47]">No event ticket preview yet</p>
            <p class="mt-2 text-[12px] font-semibold text-[#59617F]">Publish an event to generate a preview ticket here.</p>
        </div>
    @endif
</div>
