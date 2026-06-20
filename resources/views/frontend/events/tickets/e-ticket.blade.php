@extends('layouts.frontend')

@section('title', 'E-Ticket - Global Tech Summit 2024')

@section('content')
<main class="flex-1 px-4 md:px-[32px] pt-[18px] pb-12">
            <section class="mx-auto w-full max-w-[1080px]">
                <a href="{{ url('/events/profile/my-tickets') }}"
                    class="mb-[12px] inline-flex items-center gap-3 text-[15px] font-medium text-[#182064] hover:text-[#3B19E6] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to My Bookings
                </a>

                <div class="mb-[22px]">
                    <h1 class="text-[28px] leading-[1.15] font-extrabold tracking-[-0.035em] text-[#071044]">
                        E-Ticket / QR Code
                    </h1>
                    <p class="mt-[8px] text-[18px] font-medium text-[#1E2A67]">
                        View your e-ticket with QR code.
                    </p>
                </div>

                <div id="ticketCard" class="overflow-hidden rounded-[13px] border border-[#3B47C8] bg-white">
                    <div class="grid grid-cols-1 md:grid-cols-[1fr_330px] min-h-[292px]">
                        <div class="relative overflow-hidden bg-[#06154B] px-6 py-8 md:px-[43px] md:py-[48px] text-white">
                            <div class="absolute inset-0 opacity-70"
                                style="background: radial-gradient(circle at 76% 0%, rgba(75,46,255,.35), transparent 38%), radial-gradient(circle at 12% 88%, rgba(26,62,166,.65), transparent 42%), linear-gradient(135deg, #071044 0%, #06195c 56%, #061044 100%);"></div>

                            <div class="relative z-10">
                                <h2 class="text-[30px] leading-tight font-extrabold tracking-[-0.035em]">
                                    Global Tech Summit 2024
                                </h2>

                                <div class="mt-[30px] space-y-[18px] text-[22px] font-semibold tracking-[-0.02em]">
                                    <div class="flex items-center gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[22px] w-[22px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" />
                                        </svg>
                                        <span>May 15 - May 17, 2024</span>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[23px] w-[23px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.438 7-11a7 7 0 1 0-14 0c0 6.562 7 11 7 11Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                                        </svg>
                                        <span>Jio World Convention Centre, Mumbai</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative flex items-center justify-center border-t md:border-t-0 md:border-l border-dashed border-[#D9DDF4] bg-[#FBFCFF] px-6 py-8 md:px-[42px] md:py-[38px]">
                            <x-shared.qr-ticket-card
                                src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=12&data=EVT-240515-000123%7CGlobal-Tech-Summit-2024%7CJohn-Doe"
                                alt="Ticket QR code"
                                size-class="h-[210px] w-[210px]"
                            />
                        </div>
                    </div>

                    <div class="px-6 py-6 md:px-[34px] md:py-[27px]">
                        <div class="grid grid-cols-1 sm:grid-cols-[310px_1fr] gap-y-[12px] sm:gap-y-[20px] text-[15px] sm:text-[19px] leading-relaxed sm:leading-none">
                            <div class="font-medium text-[#293477]">Booking ID</div>
                            <div class="font-extrabold tracking-[-0.03em] text-[#071044]">EVT-240515-000123</div>

                            <div class="font-medium text-[#293477]">Name</div>
                            <div class="font-bold text-[#071044]">John Doe</div>

                            <div class="font-medium text-[#293477]">Email</div>
                            <div class="font-bold text-[#071044]">john.doe@example.com</div>

                            <div class="font-medium text-[#293477]">Ticket Type</div>
                            <div class="font-bold text-[#071044]">General Pass</div>

                            <div class="font-medium text-[#293477]">Ticket Count</div>
                            <div class="font-bold text-[#071044]">2</div>
                        </div>

                        <div class="mt-[35px] border-t border-[#D9DDF4] pt-[25px] text-center text-[15px] sm:text-[18px] font-bold text-[#071044]">
                            Show this QR code at the venue entrance.
                        </div>
                    </div>
                </div>

                <div class="mt-[34px] grid grid-cols-1">
                    <button id="downloadTicket"
                        class="flex h-[66px] items-center justify-center gap-4 rounded-[8px] border border-[#5131E8] bg-white text-[18px] font-extrabold text-[#3A19E6] transition hover:bg-[#F7F4FF]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[24px] w-[24px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 21h16" />
                        </svg>
                        Download Ticket
                    </button>
                </div>
            </section>
        </main>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('#sidebar [data-nav-item]');
            links.forEach((link) => {
                const label = link.textContent.trim();
                link.classList.remove('is-active', 'bg-[#F3EEFF]', 'text-[#5B35D5]');
                link.classList.add('text-[#3B406A]');
                link.removeAttribute('aria-current');

                if (label === 'My Bookings') {
                    link.classList.add('is-active', 'bg-[#F3EEFF]', 'text-[#5B35D5]');
                    link.classList.remove('text-[#3B406A]');
                    link.setAttribute('aria-current', 'page');
                }
            });

            document.getElementById('downloadTicket').addEventListener('click', function () {
                window.print();
            });

        });
</script>
@endpush
