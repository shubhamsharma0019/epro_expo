@extends('layouts.company-flow')

@section('title', 'EproExpo My Bookings')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="mb-8">
        <h1 class="text-[36px] font-semibold leading-[44px] tracking-[-0.8px] text-navy">
            My Bookings
        </h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">
            View and manage all your booth and event bookings.
        </p>
    </div>

    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="overflow-hidden rounded-lg border border-borderColor bg-white shadow-sm">
            <div class="flex min-w-max items-center">
                <button type="button" class="h-[56px] border-b-2 border-purple px-8 text-[15px] font-semibold text-purple">
                    All (4)
                </button>
                <button type="button" class="h-[56px] px-8 text-[15px] font-medium text-[#34405F]">
                    Upcoming (2)
                </button>
                <button type="button" class="h-[56px] px-8 text-[15px] font-medium text-[#34405F]">
                    Completed (1)
                </button>
                <button type="button" class="h-[56px] px-8 text-[15px] font-medium text-[#34405F]">
                    Cancelled (1)
                </button>
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <label class="relative block w-full sm:w-[360px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
                <input type="text" placeholder="Search by Booking ID, Pavilion, Hall, Event..."
                    class="h-[52px] w-full rounded-md border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8]">
            </label>

            <button type="button" class="inline-flex h-[52px] min-w-[120px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">
                <i class="fa-solid fa-filter text-[15px]"></i>
                Filter
            </button>
        </div>
    </div>

    <div class="space-y-5">
        @foreach ([
            [
                'type' => 'exhibition',
                'image' => 'innovation-pavilion.png',
                'title' => 'Innovation Pavilion',
                'hall' => 'Hall 1 - Tech & Innovation',
                'booth' => 'Booth 12A (10m × 3m)',
                'date' => 'May 16 - May 19, 2024',
                'days' => '4 Days',
                'status' => 'Confirmed',
                'statusClass' => 'bg-[#EAF9F0] text-[#16A34A]',
                'id' => 'EXPO2024-INV-12A-001',
                'amount' => '₹657.80',
                'invoice' => true,
                'detailsUrl' => '/company/bookings/1',
            ],
            [
                'type' => 'event',
                'image' => 'banner_bg.png',
                'title' => 'Global Tech Summit 2024',
                'hall' => 'Jio World Convention Centre, Mumbai',
                'booth' => 'General Pass x 2 Tickets',
                'date' => 'May 15 - May 17, 2024',
                'days' => '3 Days',
                'status' => 'Confirmed',
                'statusClass' => 'bg-[#EAF9F0] text-[#16A34A]',
                'id' => 'EVT-240515-000123',
                'amount' => '₹98.00',
                'invoice' => true,
                'detailsUrl' => '/company/bookings/2',
            ],
            [
                'type' => 'exhibition',
                'image' => 'healthcare-pavilion.png',
                'title' => 'Healthcare Pavilion',
                'hall' => 'Hall 2 - Healthcare',
                'booth' => 'Booth 25B (9m × 3m)',
                'date' => 'Jun 10 - Jun 13, 2024',
                'days' => '4 Days',
                'status' => 'Completed',
                'statusClass' => 'bg-[#E8F3FF] text-[#0B7AE8]',
                'id' => 'EXPO2024-HLC-25B-002',
                'amount' => '₹1,099.00',
                'invoice' => true,
                'detailsUrl' => '/company/bookings/3',
            ],
            [
                'type' => 'exhibition',
                'image' => 'business-pavilion.png',
                'title' => 'Business Pavilion',
                'hall' => 'Hall 3 - Business',
                'booth' => 'Booth 18C (10m × 3m)',
                'date' => 'Apr 25 - Apr 28, 2024',
                'days' => '4 Days',
                'status' => 'Cancelled',
                'statusClass' => 'bg-[#FFE9E9] text-[#DC2626]',
                'id' => 'EXPO2024-BUS-18C-003',
                'amount' => '₹499.00',
                'invoice' => false,
                'detailsUrl' => '/company/bookings/4',
            ],
        ] as $booking)
            <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6">
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[190px_minmax(0,1fr)_380px] xl:items-center">
                    <img
                        src="{{ $booking['type'] === 'event' ? asset('images/events/' . $booking['image']) : asset('assets/images/pavilions/' . $booking['image']) }}"
                        alt="{{ $booking['title'] }}"
                        class="h-[138px] w-full rounded-md object-cover xl:w-[170px]"
                    >

                    <div class="min-w-0">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <h2 class="text-[21px] font-semibold text-navy">{{ $booking['title'] }}</h2>
                            <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold {{ $booking['statusClass'] }}">
                                {{ $booking['status'] }}
                            </span>
                        </div>

                        <div class="space-y-3 text-[15px] font-medium text-[#34405F]">
                            <p class="flex items-center gap-3">
                                <i class="fa-regular {{ $booking['type'] === 'event' ? 'fa-map' : 'fa-building' }} w-4 text-purple"></i>
                                {{ $booking['hall'] }}
                            </p>
                            <p class="flex items-center gap-3">
                                <i class="fa-solid {{ $booking['type'] === 'event' ? 'fa-ticket' : 'fa-shop' }} w-4 text-purple"></i>
                                {{ $booking['booth'] }}
                            </p>
                            <p class="flex items-center gap-3">
                                <i class="fa-regular fa-calendar-days w-4 text-purple"></i>
                                {{ $booking['date'] }} <span>&bull;</span> {{ $booking['days'] }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-borderColor pt-5 xl:border-l xl:border-t-0 xl:py-3 xl:pl-7">
                        <p class="text-[14px] font-medium text-[#5A6480]">Booking ID</p>
                        <p class="mt-2 break-words text-[17px] font-semibold text-navy">{{ $booking['id'] }}</p>

                        <div class="my-5 border-t border-borderColor"></div>

                        <p class="text-[14px] font-medium text-[#5A6480]">Amount</p>
                        <p class="mt-2 text-[26px] font-semibold leading-none text-navy">{{ $booking['amount'] }}</p>

                        <div class="mt-5 flex flex-col gap-3">
                            <a href="{{ url($booking['detailsUrl']) }}"
                                class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">
                                View Details
                                <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            </a>

                            @if ($booking['invoice'])
                                <button type="button" class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[15px] font-semibold text-white">
                                    Download Invoice
                                    <i class="fa-solid fa-download text-[13px]"></i>
                                </button>
                            @else
                                <button type="button" disabled class="inline-flex h-[48px] items-center justify-center rounded-md border border-borderColor bg-[#F5F6FA] px-5 text-[15px] font-semibold text-[#A4AABC]">
                                    No Invoice
                                </button>
                            @endif

                            @if ($booking['type'] === 'exhibition' && $booking['status'] === 'Confirmed')
                                <a href="{{ url('/company/profile') }}"
                                    class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md border border-borderColor px-5 text-[15px] font-semibold text-navy">
                                    Booth Microsite
                                    <i class="fa-solid fa-store text-[13px]"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="rounded-b-xl border border-t-0 border-borderColor bg-white px-6 py-5 shadow-sm">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <p class="text-[14px] font-medium text-[#34405F]">
                Showing 1 to 4 of 4 bookings
            </p>

            <div class="flex items-center justify-center gap-3">
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-md border border-borderColor bg-[#F5F6FA] text-[#A4AABC]">
                    <i class="fa-solid fa-chevron-left text-[12px]"></i>
                </button>
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-md border border-purple text-[15px] font-semibold text-purple">
                    1
                </button>
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-md border border-borderColor bg-[#F5F6FA] text-[#A4AABC]">
                    <i class="fa-solid fa-chevron-right text-[12px]"></i>
                </button>
            </div>

            <div class="flex items-center gap-3 text-[14px] font-medium text-[#34405F]">
                <span>Rows per page:</span>
                <button type="button" class="inline-flex h-10 items-center gap-3 rounded-md border border-borderColor px-4 text-navy">
                    10
                    <i class="fa-solid fa-chevron-down text-[11px]"></i>
                </button>
            </div>
        </div>
    </div>

</section>

@endsection
