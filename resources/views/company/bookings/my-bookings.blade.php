@extends('layouts.company')

@section('title', 'EproExpo My Bookings')

@section('content')

<section class="max-w-[1500px] px-4 py-6 sm:px-8 sm:py-8 lg:px-10 lg:py-10">

    <div class="mb-6 sm:mb-8">
        <h1 class="text-[28px] font-semibold leading-tight tracking-[-0.8px] text-navy sm:text-[36px] sm:leading-[44px]">
            My Bookings
        </h1>
    </div>

    @php
        $allBookings = collect($allBookings ?? $bookings);
        $activeStatus = $activeStatus ?? 'all';
        $search = $search ?? '';
        $totalCount = $bookings->count();
        $allCount = $allBookings->count();
        $upcomingCount = $allBookings->filter(function ($b) {
            $startDate = $b->exhibition->start_date ?? null;
            return $startDate && $startDate->isFuture() && $b->booking_status !== 'cancelled' && $b->admin_status !== 'rejected';
        })->count();
        $completedCount = $allBookings->filter(function ($b) {
            $endDate = $b->exhibition->end_date ?? null;
            return $endDate && $endDate->isPast() && $b->booking_status !== 'cancelled' && $b->admin_status !== 'rejected';
        })->count();
        $cancelledCount = $allBookings->filter(function ($b) {
            return $b->booking_status === 'cancelled' || $b->admin_status === 'rejected';
        })->count();
        $tabClass = fn (string $status) => $activeStatus === $status
            ? 'border-b-2 border-purple font-semibold text-purple'
            : 'font-medium text-[#34405F] hover:text-purple';
        $tabUrl = fn (string $status) => route('company.bookings.index', array_filter([
            'status' => $status === 'all' ? null : $status,
            'search' => $search,
        ]));
    @endphp

    <div class="mb-6 flex flex-col gap-4">
        <div class="flex flex-col gap-3 rounded-lg border border-borderColor bg-white p-3 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:pr-3 sm:pl-0">
            <div class="min-w-0 overflow-x-auto [-webkit-overflow-scrolling:touch]">
                <div class="flex min-w-max items-center">
                <a href="{{ $tabUrl('all') }}" class="inline-flex h-[48px] min-w-[96px] items-center justify-center px-4 text-center text-[14px] sm:h-[56px] sm:min-w-[110px] sm:px-6 sm:text-[15px] {{ $tabClass('all') }}">
                    All ({{ $allCount }})
                </a>
                <a href="{{ $tabUrl('upcoming') }}" class="inline-flex h-[48px] min-w-[120px] items-center justify-center px-4 text-center text-[14px] sm:h-[56px] sm:min-w-[150px] sm:px-6 sm:text-[15px] {{ $tabClass('upcoming') }}">
                    Upcoming ({{ $upcomingCount }})
                </a>
                <a href="{{ $tabUrl('completed') }}" class="inline-flex h-[48px] min-w-[120px] items-center justify-center px-4 text-center text-[14px] sm:h-[56px] sm:min-w-[150px] sm:px-6 sm:text-[15px] {{ $tabClass('completed') }}">
                    Completed ({{ $completedCount }})
                </a>
                <a href="{{ $tabUrl('cancelled') }}" class="inline-flex h-[48px] min-w-[120px] items-center justify-center px-4 text-center text-[14px] sm:h-[56px] sm:min-w-[150px] sm:px-6 sm:text-[15px] {{ $tabClass('cancelled') }}">
                    Cancelled ({{ $cancelledCount }})
                </a>
                </div>
            </div>
            <button type="submit" form="booking-filter-form" class="inline-flex h-[44px] w-full shrink-0 items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple sm:w-auto sm:min-w-[120px]">
                <i class="fa-solid fa-filter text-[15px]"></i>
                Filter
            </button>
        </div>

        <form id="booking-filter-form" method="GET" action="{{ route('company.bookings.index') }}">
            @if ($activeStatus !== 'all')
                <input type="hidden" name="status" value="{{ $activeStatus }}">
            @endif
            <label class="relative block min-w-0">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[15px] text-[#5A6480]"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by Booking ID, Pavilion, Hall, Event..."
                    class="h-[52px] w-full rounded-md border border-borderColor bg-white pl-11 pr-4 text-[14px] font-medium text-navy outline-none placeholder:text-[#8A90A8]">
            </label>
        </form>
    </div>

    <div class="space-y-5">
        @forelse ($bookings as $bookingItem)
            @php
                $status = 'Pending';
                $statusClass = 'bg-yellow-50 text-yellow-700';
                
                if ($bookingItem->booking_status === 'cancelled' || $bookingItem->admin_status === 'rejected') {
                    $status = 'Cancelled';
                    $statusClass = 'bg-[#FFE9E9] text-[#DC2626]';
                } elseif ($bookingItem->payment_status === 'paid' && $bookingItem->booking_status === 'confirmed') {
                    if ($bookingItem->admin_status === 'approved') {
                        $status = 'Confirmed';
                        $statusClass = 'bg-[#EAF9F0] text-[#16A34A]';
                    } elseif ($bookingItem->admin_status === 'pending') {
                        $status = 'Pending Approval';
                        $statusClass = 'bg-orange-50 text-orange-700';
                    }
                }

                $exhibition = $bookingItem->exhibition;
                $pavilion = $bookingItem->pavilion;
                $hall = $bookingItem->hall;
                $booth = $bookingItem->booth;
                $boothSize = $bookingItem->boothSize;

                $title = $pavilion->title ?? $exhibition->title ?? 'Exhibition Booth';
                $hallName = $hall->title ?? 'N/A';
                $boothName = 'Booth ' . ($booth->booth_number ?? 'N/A');
                if ($boothSize) {
                    $boothName .= ' (' . $boothSize->width . 'm × ' . $boothSize->height . 'm)';
                }

                $startDate = $exhibition->start_date ?? null;
                $endDate = $exhibition->end_date ?? null;
                $dateStr = 'N/A';
                $daysStr = '0 Days';
                if ($startDate && $endDate) {
                    $dateStr = $startDate->format('M d') . ' - ' . $endDate->format('M d, Y');
                    $days = $startDate->diffInDays($endDate) + 1;
                    $daysStr = $days . ' ' . ($days === 1 ? 'Day' : 'Days');
                }

                $rawImage = ($pavilion && $pavilion->image)
                    ? $pavilion->image
                    : (($exhibition && $exhibition->banner_image) ? $exhibition->banner_image : null);
                $imagePath = \App\Support\HallMedia::imageUrl($rawImage);

                $setupStarted = $bookingItem->boothProfile
                    || in_array($bookingItem->booth_setup_status, [
                        'setup_in_progress',
                        'in_progress',
                        'ready_to_publish',
                        'pending_review',
                        'submitted_for_review',
                        'published',
                        'approved',
                        'live',
                    ], true);
            @endphp

            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-6">
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[190px_minmax(0,1fr)_380px] xl:items-center">
                    <img
                        src="{{ $imagePath }}"
                        alt="{{ $title }}"
                        class="h-[160px] w-full rounded-md object-cover sm:h-[138px] xl:w-[170px]"
                    >

                    <div class="min-w-0">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <h2 class="text-[18px] font-semibold text-navy sm:text-[21px]">{{ $title }}</h2>
                            <span class="w-fit rounded-md px-3 py-1.5 text-[13px] font-semibold {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </div>

                        <div class="space-y-3 text-[14px] font-medium text-[#34405F] sm:text-[15px]">
                            <p class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-4 text-purple"></i>
                                {{ $hallName }}
                            </p>
                            <p class="flex items-center gap-3">
                                <i class="fa-solid fa-shop w-4 text-purple"></i>
                                {{ $boothName }}
                            </p>
                            <p class="flex items-center gap-3">
                                <i class="fa-regular fa-calendar-days w-4 text-purple"></i>
                                {{ $dateStr }} <span>&bull;</span> {{ $daysStr }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-borderColor pt-5 xl:border-l xl:border-t-0 xl:py-3 xl:pl-7">
                        <p class="text-[14px] font-medium text-[#5A6480]">Booking ID</p>
                        <p class="mt-2 break-all text-[16px] font-semibold text-navy sm:break-words sm:text-[17px]">BOOK-{{ str_pad((string) $bookingItem->id, 5, '0', STR_PAD_LEFT) }}</p>

                        <div class="my-5 border-t border-borderColor"></div>

                        <p class="text-[14px] font-medium text-[#5A6480]">Amount</p>
                        <p class="mt-2 text-[22px] font-semibold leading-none text-navy sm:text-[26px]">₹{{ number_format($bookingItem->total_amount, 2) }}</p>

                        <div class="mt-5 flex flex-col gap-3">
                            <a href="{{ url('/company/bookings/' . $bookingItem->id) }}"
                                class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple hover:bg-[#F8F7FF] transition-colors">
                                View Details
                                <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            </a>

                            @if ($bookingItem->payment_status === 'paid')
                                <a href="{{ route('company.bookings.invoice', $bookingItem->id) }}" target="_blank" class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[15px] font-semibold text-white">
                                    Download Invoice
                                    <i class="fa-solid fa-download text-[13px]"></i>
                                </a>
                            @else
                                <button type="button" disabled class="inline-flex h-[48px] items-center justify-center rounded-md border border-borderColor bg-[#F5F6FA] px-5 text-[15px] font-semibold text-[#A4AABC]">
                                    No Invoice
                                </button>
                            @endif

                            @if ($status === 'Confirmed' && $setupStarted)
                                <a href="{{ route('company.booth-setup.index', $bookingItem->id) }}"
                                    class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md border border-borderColor px-5 text-[15px] font-semibold text-navy hover:bg-gray-50 transition-colors">
                                    Continue Setup
                                    <i class="fa-solid fa-store text-[13px]"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-borderColor bg-white p-8 text-center text-gray-500 font-medium">
                No bookings found. You can <a href="{{ url('/company/booth-booking/pavilions') }}" class="text-purple font-semibold hover:underline">book a booth here</a>.
            </div>
        @endforelse
    </div>

    <div class="rounded-b-xl border border-t-0 border-borderColor bg-white px-4 py-5 shadow-sm sm:px-6">
        <div class="flex flex-col gap-4 sm:gap-5 md:flex-row md:items-center md:justify-between">
            <p class="text-center text-[13px] font-medium text-[#34405F] sm:text-left sm:text-[14px]">
                Showing 1 to {{ $totalCount }} of {{ $totalCount }} bookings
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

            <div class="hidden items-center justify-center gap-3 text-[14px] font-medium text-[#34405F] sm:flex">
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
