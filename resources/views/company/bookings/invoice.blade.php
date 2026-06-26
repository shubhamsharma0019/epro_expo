@php
    $bookingReference = 'EXPO-' . optional($booking->created_at)->format('Y') . '-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT);
    $startDate = $booking->exhibition?->start_date ? \Carbon\Carbon::parse($booking->exhibition->start_date)->format('M d, Y') : null;
    $endDate = $booking->exhibition?->end_date ? \Carbon\Carbon::parse($booking->exhibition->end_date)->format('M d, Y') : null;
    $daysCount = $bookingDays->count();
    $dateRange = $startDate && $endDate ? $startDate . ' - ' . $endDate . ($daysCount ? ' (' . $daysCount . ' Days)' : '') : 'Dates not available';
    $company = $booking->company;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $bookingReference }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        navy: {
                            50: '#F4F4F9',
                            800: '#1E1A4A',
                            900: '#0F0E2C',
                        },
                        purple: {
                            50: '#F5F3FF',
                            100: '#EDE9FE',
                            500: '#5A32FA',
                            600: '#4A22E0',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F8FAFC;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }
            .print-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="font-sans text-navy-900 antialiased p-4 sm:p-8 min-h-screen flex flex-col justify-between">

    <div class="max-w-[900px] w-full mx-auto space-y-6">
        
        <!-- Action Header Bar (No Print) -->
        <div class="no-print flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white border border-gray-200/80 rounded-xl px-6 py-4 shadow-sm">
            <a href="{{ url('/company/bookings/' . $booking->id) }}" class="inline-flex items-center justify-center sm:justify-start gap-2 text-sm font-semibold text-purple-600 hover:text-purple-500 transition">
                <i class="ph ph-arrow-left text-base"></i>
                Back to Booking Details
            </a>
            
            <div class="flex items-center justify-center sm:justify-end gap-3">
                <button onclick="window.print()" class="inline-flex h-[40px] w-full sm:w-auto justify-center items-center gap-2 rounded-lg bg-purple-600 hover:bg-purple-500 px-5 text-sm font-bold text-white shadow-sm transition">
                    <i class="ph ph-printer text-base"></i>
                    Print Invoice
                </button>
            </div>
        </div>

        <!-- Main Invoice Content -->
        <div class="print-card bg-white rounded-2xl border border-gray-200/80 shadow-md p-8 sm:p-12 relative overflow-hidden">
            
            <!-- Decorative Accent line (No Print) -->
            <div class="no-print absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-purple-500 to-indigo-600"></div>

            <!-- Invoice Header -->
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 border-b border-gray-100 pb-8">
                <div>
                    <div class="flex items-center gap-2 text-purple-600 mb-3">
                        <i class="ph ph-shield-check text-[32px] fill-current"></i>
                        <span class="text-2xl font-bold tracking-tight text-navy-800">EproExpo</span>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Exhibitor Booth Invoice</p>
                </div>
                
                <div class="sm:text-right">
                    <h2 class="text-xl font-bold text-navy-800">INVOICE</h2>
                    <p class="text-[15px] font-semibold text-purple-600 mt-1">{{ $bookingReference }}</p>
                    
                    <div class="mt-4 space-y-1 text-sm text-gray-500">
                        <p><span class="font-medium text-navy-800">Date:</span> {{ optional($booking->paid_at)->format('F d, Y') ?? optional($booking->updated_at)->format('F d, Y') }}</p>
                        @if($booking->razorpay_payment_id)
                            <p><span class="font-medium text-navy-800">Payment ID:</span> {{ $booking->razorpay_payment_id }}</p>
                        @endif
                        <p><span class="font-medium text-navy-800">Status:</span> <span class="text-green-600 font-bold uppercase text-xs px-2 py-0.5 bg-green-50 border border-green-200 rounded">Paid</span></p>
                    </div>
                </div>
            </div>

            <!-- Addresses Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-8 border-b border-gray-100 text-sm">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Billed To</p>
                    <p class="font-bold text-navy-800 text-[16px]">{{ $company->company_name ?? 'Exhibitor Company' }}</p>
                    <div class="mt-2 space-y-1 text-gray-500 font-medium">
                        <p>{{ $company->contact_person_name ?? 'Contact Person' }}</p>
                        <p>{{ $company->email ?? '' }}</p>
                        <p>{{ $company->phone ?? '' }}</p>
                    </div>
                </div>

                <div class="sm:pl-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Billed By</p>
                    <p class="font-bold text-navy-800 text-[16px]">EproExpo Global Technologies Ltd.</p>
                    <div class="mt-2 space-y-1 text-gray-500 font-medium">
                        <p>104 Convention Plaza, Bandra Kurla Complex</p>
                        <p>Mumbai, MH, 400051, India</p>
                        <p>billing@eproexpo.com</p>
                    </div>
                </div>
            </div>

            <!-- Exhibition Details -->
            <div class="my-8 bg-gray-50/80 rounded-xl p-6 border border-gray-100">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Exhibition details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Exhibition Event</p>
                        <p class="font-bold text-navy-800">{{ $booking->exhibition->title ?? 'Exhibition' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Dates & Duration</p>
                        <p class="font-bold text-navy-800">{{ $dateRange }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Hall / Pavilion</p>
                        <p class="font-bold text-navy-800">{{ $booking->hall->title ?? 'N/A' }} ({{ $booking->pavilion->title ?? 'N/A' }})</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Booth Number</p>
                        <p class="font-bold text-navy-800">Booth {{ $booking->booth->booth_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Booth Size</p>
                        <p class="font-bold text-navy-800">{{ $booking->boothSize->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Venue Venue</p>
                        <p class="font-bold text-navy-800">{{ $booking->exhibition->venue ?? 'Jio World Convention Centre' }}</p>
                    </div>
                </div>
            </div>

            <!-- Items table -->
            <div class="overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0">
                <table class="w-full min-w-[600px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3 pr-4">Description</th>
                            <th class="py-3 px-4 text-center">Qty / Days</th>
                            <th class="py-3 px-4 text-right">Unit Price</th>
                            <th class="py-3 pl-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Base Booth Rental Item -->
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-navy-800">Booth Rental Fee</p>
                                <p class="text-xs text-gray-400 mt-1">Base cost for booth size {{ $booking->boothSize->title }}</p>
                            </td>
                            <td class="py-4 px-4 text-center font-semibold text-navy-800">1</td>
                            <td class="py-4 px-4 text-right font-medium text-navy-800">₹{{ number_format((float) ($booking->boothSize->price ?? $booking->amount), 2) }}</td>
                            <td class="py-4 pl-4 text-right font-bold text-navy-800">₹{{ number_format((float) ($booking->boothSize->price ?? $booking->amount), 2) }}</td>
                        </tr>

                        <!-- Days Booking Item -->
                        @if($bookingDays->isNotEmpty())
                            @foreach($bookingDays as $day)
                                <tr>
                                    <td class="py-4 pr-4">
                                        <p class="font-semibold text-navy-800">Daily Show Slot - {{ $day->booking_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Show duration access slot</p>
                                    </td>
                                    <td class="py-4 px-4 text-center font-semibold text-navy-800">1 Day</td>
                                    <td class="py-4 px-4 text-right font-medium text-navy-800">₹{{ number_format((float) $day->price, 2) }}</td>
                                    <td class="py-4 pl-4 text-right font-bold text-navy-800">₹{{ number_format((float) $day->price, 2) }}</td>
                                </tr>
                            @endforeach
                        @endif

                        <!-- Services Items -->
                        @if($bookingServices->isNotEmpty())
                            @foreach($bookingServices as $service)
                                <tr>
                                    <td class="py-4 pr-4">
                                        <p class="font-semibold text-navy-800">{{ $service->title }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Additional custom booth service</p>
                                    </td>
                                    <td class="py-4 px-4 text-center font-semibold text-navy-800">{{ $service->pivot->quantity }}</td>
                                    <td class="py-4 px-4 text-right font-medium text-navy-800">₹{{ number_format((float) $service->pivot->price, 2) }}</td>
                                    <td class="py-4 pl-4 text-right font-bold text-navy-800">₹{{ number_format((float) $service->pivot->total, 2) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Invoice Totals -->
            <div class="mt-8 border-t border-gray-200 pt-6 flex justify-end">
                <div class="w-full sm:w-[320px] space-y-3.5 text-sm">
                    <div class="flex justify-between font-medium text-gray-500">
                        <span>Space Subtotal</span>
                        <span class="text-navy-800 font-semibold">₹{{ number_format((float) $booking->amount, 2) }}</span>
                    </div>
                    @if($booking->services_amount > 0)
                        <div class="flex justify-between font-medium text-gray-500">
                            <span>Services Subtotal</span>
                            <span class="text-navy-800 font-semibold">₹{{ number_format((float) $booking->services_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between font-medium text-gray-500">
                        <span>Tax / GST (0%)</span>
                        <span class="text-navy-800 font-semibold">₹0.00</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3.5 flex justify-between items-baseline">
                        <span class="text-base font-bold text-navy-800">Total Paid</span>
                        <span class="text-2xl font-bold text-purple-600">₹{{ number_format((float) $booking->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Signature / Thanks -->
            <div class="mt-16 text-center text-xs text-gray-400 space-y-2 border-t border-gray-100 pt-8">
                <p>If you have any questions about this invoice, please contact support@eproexpo.com</p>
                <p class="font-medium text-navy-800">Thank you for exhibiting with EproExpo!</p>
            </div>
            
        </div>
    </div>

</body>
</html>
