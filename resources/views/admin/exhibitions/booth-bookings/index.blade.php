<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booth Bookings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <main class="mx-auto max-w-6xl p-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#1E1B4B]">Booth Booking Approvals</h1>
                <p class="mt-1 text-sm text-gray-500">Review, approve, or reject paid exhibitor booth bookings.</p>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                Back to Dashboard
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-6 flex gap-2">
            <a href="{{ route('admin.booth-bookings.index', ['status' => 'all']) }}" 
               class="rounded-lg px-4 py-2 text-sm font-semibold {{ $status === 'all' ? 'bg-[#3D1B9B] text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                All Bookings
            </a>
            <a href="{{ route('admin.booth-bookings.index', ['status' => 'pending']) }}" 
               class="rounded-lg px-4 py-2 text-sm font-semibold {{ $status === 'pending' ? 'bg-[#3D1B9B] text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Pending Review
            </a>
            <a href="{{ route('admin.booth-bookings.index', ['status' => 'approved']) }}" 
               class="rounded-lg px-4 py-2 text-sm font-semibold {{ $status === 'approved' ? 'bg-[#3D1B9B] text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Approved
            </a>
            <a href="{{ route('admin.booth-bookings.index', ['status' => 'rejected']) }}" 
               class="rounded-lg px-4 py-2 text-sm font-semibold {{ $status === 'rejected' ? 'bg-[#3D1B9B] text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Rejected
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="min-w-[800px] divide-y divide-gray-100">
                <div class="grid grid-cols-6 gap-4 bg-gray-50 p-5 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                    <div class="col-span-2">Company</div>
                    <div>Exhibition</div>
                    <div>Booth & Size</div>
                    <div>Total Paid</div>
                    <div class="text-right">Action</div>
                </div>
                
                <div class="divide-y divide-gray-100 bg-white">
                    @forelse ($bookings as $booking)
                        <div class="grid grid-cols-6 gap-4 p-5 items-center hover:bg-[#FBFAFF]">
                            <div class="col-span-2">
                                <p class="font-bold text-gray-900">{{ $booking->company->company_name ?? 'Unknown Company' }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->company->email ?? '' }}</p>
                            </div>
                            <div class="text-sm text-gray-700">
                                {{ $booking->exhibition->title ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold text-gray-900">Booth {{ $booking->booth->booth_number ?? '--' }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->boothSize->title ?? '' }}</p>
                            </div>
                            <div class="text-sm font-bold text-gray-900">
                                ₹{{ number_format($booking->total_amount, 2) }}
                            </div>
                            <div class="text-right">
                                <div class="flex items-center justify-end gap-3">
                                    @if ($booking->admin_status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">Pending</span>
                                    @elseif ($booking->admin_status === 'approved')
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-800">Approved</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-800">Rejected</span>
                                    @endif
                                    <a href="{{ route('admin.booth-bookings.show', $booking->id) }}" class="inline-flex items-center justify-center rounded-lg bg-[#3D1B9B] px-3.5 py-1.5 text-xs font-bold text-white hover:bg-[#2F1480]">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            No booth bookings found for the selected filter.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</body>
</html>
