<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Booth Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <main class="mx-auto max-w-4xl p-8">
        <a href="{{ route('admin.booth-bookings.index') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-bold text-[#3D1B9B] hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Back to Bookings List
        </a>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <span class="rounded bg-[#F4F0FF] px-2.5 py-1 text-xs font-bold text-[#3D1B9B] uppercase tracking-wider">
                            {{ $booking->booking_status }}
                        </span>
                        <h1 class="mt-3 text-2xl font-bold text-gray-900">Review Booking Details</h1>
                        <p class="text-sm text-gray-500">Booking ID: #BOOK-{{ str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        @if ($booking->admin_status === 'pending')
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-800">Pending Review</span>
                        @elseif ($booking->admin_status === 'approved')
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">Approved</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-800">Rejected</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Exhibitor Information</h3>
                        <p class="mt-2 font-bold text-gray-900">{{ $booking->company->company_name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->company->contact_person_name ?? '' }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->company->email ?? '' }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->company->phone ?? '' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Exhibition Details</h3>
                        <p class="mt-2 font-bold text-gray-900">{{ $booking->exhibition->title ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Pavilion: {{ $booking->pavilion->title ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Hall: {{ $booking->hall->title ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Booth: {{ $booking->booth->booth_number ?? 'N/A' }} ({{ $booking->boothSize->title ?? '' }})</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Financial Breakdown -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Pricing & Payment Breakdown</h3>
                    <div class="space-y-2 rounded-lg bg-gray-50 p-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Booth Price:</span>
                            <span class="font-semibold text-gray-900">₹{{ number_format($booking->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Additional Services:</span>
                            <span class="font-semibold text-gray-900">₹{{ number_format($booking->services_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2 font-bold text-base">
                            <span class="text-gray-900">Total Amount Paid:</span>
                            <span class="text-[#3D1B9B]">₹{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Days booked -->
                @if($booking->days->isNotEmpty())
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Booked Slots/Days</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($booking->days as $day)
                                <span class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1 text-xs font-medium text-gray-700">
                                    {{ $day->booking_date->format('M d, Y') }} ({{ $day->label ?: 'Full Day' }})
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($booking->rejection_reason)
                    <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        <p class="font-bold">Rejection Reason:</p>
                        <p class="mt-1">{{ $booking->rejection_reason }}</p>
                    </div>
                @endif

                <hr class="border-gray-100">

                @if ($booking->admin_status === 'pending')
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        <form method="POST" action="{{ route('admin.booth-bookings.approve', $booking->id) }}">
                            @csrf
                            <button class="w-full sm:w-auto rounded-lg bg-[#3D1B9B] px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#2F1480]">
                                Approve Booking
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.booth-bookings.reject', $booking->id) }}" class="flex flex-1 flex-col sm:flex-row gap-3">
                            @csrf
                            <input name="rejection_reason" required placeholder="Please provide a reason for rejection..." 
                                   class="flex-1 rounded-lg border border-gray-200 px-4 py-3 text-sm focus:border-red-400 focus:outline-none">
                            <button class="rounded-lg border border-red-200 bg-white px-6 py-3 text-sm font-bold text-red-600 hover:bg-red-50">
                                Reject Booking
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
