@php
    $currency = $invoice['currency_symbol'];
    $statusTone = match ($invoice['payment_status_tone']) {
        'green' => 'text-green-700 bg-green-50 border-green-200',
        'amber' => 'text-amber-700 bg-amber-50 border-amber-200',
        'rose' => 'text-rose-700 bg-rose-50 border-rose-200',
        default => 'text-slate-700 bg-slate-50 border-slate-200',
    };
    $formatMoney = fn (float $amount) => $currency . number_format($amount, 2);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice['reference'] }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        navy: { 800: '#1E1A4A', 900: '#0F0E2C' },
                        purple: { 500: '#5A32FA', 600: '#4A22E0' },
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #F8FAFC; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0 !important; }
            .print-card { border: none !important; box-shadow: none !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="font-sans text-navy-900 antialiased p-3 sm:p-6 lg:p-8 min-h-screen">

    <div class="max-w-[900px] w-full mx-auto space-y-4 sm:space-y-6">

        <div class="no-print flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between bg-white border border-gray-200/80 rounded-xl px-4 py-3 sm:px-6 sm:py-4 shadow-sm">
            <a href="{{ route('company.bookings.show', $booking->id) }}" class="inline-flex items-center justify-center sm:justify-start gap-2 text-sm font-semibold text-purple-600 hover:text-purple-500 transition">
                <i class="ph ph-arrow-left text-base"></i>
                Back to Booking Details
            </a>
            <button onclick="window.print()" class="inline-flex h-10 w-full sm:w-auto justify-center items-center gap-2 rounded-lg bg-purple-600 hover:bg-purple-500 px-5 text-sm font-bold text-white shadow-sm transition">
                <i class="ph ph-printer text-base"></i>
                Print Invoice
            </button>
        </div>

        <div class="print-card bg-white rounded-2xl border border-gray-200/80 shadow-md p-5 sm:p-8 lg:p-12 relative overflow-hidden">
            <div class="no-print absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-purple-500 to-indigo-600"></div>

            {{-- Header --}}
            <div class="flex flex-col gap-6 border-b border-gray-100 pb-6 sm:pb-8 lg:flex-row lg:items-start lg:justify-between">
                <div class="min-w-0">
                    <x-shared.brand-logo
                        href="{{ url('/') }}"
                        subtitle="Exhibitor Booth Invoice"
                        mark-class="h-10 w-10 sm:h-11 sm:w-11 rounded-[16px] text-[18px] sm:text-[20px]"
                        title-class="text-xl sm:text-2xl font-bold text-navy-800"
                        subtitle-class="text-[11px] sm:text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1"
                    />
                </div>

                <div class="lg:text-right shrink-0">
                    <h2 class="text-lg sm:text-xl font-bold text-navy-800">INVOICE</h2>
                    <p class="text-[14px] sm:text-[15px] font-semibold text-purple-600 mt-1 break-all">{{ $invoice['reference'] }}</p>
                    <div class="mt-3 sm:mt-4 space-y-1.5 text-sm text-gray-500">
                        <p><span class="font-medium text-navy-800">Date:</span> {{ $invoice['issued_at'] }}</p>
                        @if ($invoice['payment_id'])
                            <p class="break-all"><span class="font-medium text-navy-800">Payment ID:</span> {{ $invoice['payment_id'] }}</p>
                        @endif
                        <p><span class="font-medium text-navy-800">Method:</span> {{ $invoice['payment_method'] }}</p>
                        <p class="flex flex-wrap items-center gap-2">
                            <span class="font-medium text-navy-800">Status:</span>
                            <span class="font-bold uppercase text-[11px] px-2 py-0.5 border rounded {{ $statusTone }}">{{ $invoice['payment_status_label'] }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Billing --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8 py-6 sm:py-8 border-b border-gray-100 text-sm">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Billed To</p>
                    <p class="font-bold text-navy-800 text-[15px] sm:text-[16px]">{{ $invoice['billed_to']['company_name'] }}</p>
                    <div class="mt-2 space-y-1 text-gray-500 font-medium break-words">
                        @if ($invoice['billed_to']['contact_name'])
                            <p>{{ $invoice['billed_to']['contact_name'] }}</p>
                        @endif
                        @if ($invoice['billed_to']['email'])
                            <p>{{ $invoice['billed_to']['email'] }}</p>
                        @endif
                        @if ($invoice['billed_to']['phone'])
                            <p>{{ $invoice['billed_to']['phone'] }}</p>
                        @endif
                        @if ($invoice['billed_to']['address'])
                            <p>{{ $invoice['billed_to']['address'] }}</p>
                        @endif
                    </div>
                </div>

                <div class="sm:pl-0 lg:pl-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Billed By</p>
                    <p class="font-bold text-navy-800 text-[15px] sm:text-[16px]">{{ $invoice['billed_by']['name'] }}</p>
                    <div class="mt-2 space-y-1 text-gray-500 font-medium break-words">
                        @if ($invoice['billed_by']['address_line_1'])
                            <p>{{ $invoice['billed_by']['address_line_1'] }}</p>
                        @endif
                        @if ($invoice['billed_by']['address_line_2'])
                            <p>{{ $invoice['billed_by']['address_line_2'] }}</p>
                        @endif
                        @if ($invoice['billed_by']['email'])
                            <p>{{ $invoice['billed_by']['email'] }}</p>
                        @endif
                        @if ($invoice['billed_by']['gst_number'])
                            <p><span class="font-semibold text-navy-800">GSTIN:</span> {{ $invoice['billed_by']['gst_number'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Exhibition details --}}
            <div class="my-6 sm:my-8 bg-gray-50/80 rounded-xl p-4 sm:p-6 border border-gray-100">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Exhibition Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Exhibition Event</p>
                        <p class="font-bold text-navy-800 break-words">{{ $invoice['exhibition']['title'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Dates & Duration</p>
                        <p class="font-bold text-navy-800">{{ $invoice['exhibition']['date_range'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Hall / Pavilion</p>
                        <p class="font-bold text-navy-800 break-words">{{ $invoice['exhibition']['hall'] }} ({{ $invoice['exhibition']['pavilion'] }})</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Booth Number</p>
                        <p class="font-bold text-navy-800">{{ $invoice['exhibition']['booth_label'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Booth Size</p>
                        <p class="font-bold text-navy-800">{{ $invoice['exhibition']['booth_size'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Venue</p>
                        <p class="font-bold text-navy-800 break-words">{{ $invoice['exhibition']['venue'] }}</p>
                        @if ($invoice['exhibition']['location'])
                            <p class="text-gray-500 mt-1">{{ $invoice['exhibition']['location'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Line items: mobile cards --}}
            <div class="md:hidden space-y-3">
                @foreach ($invoice['line_items'] as $item)
                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4">
                        <p class="font-semibold text-navy-800 text-[14px]">{{ $item['description'] }}</p>
                        @if ($item['subtitle'])
                            <p class="text-xs text-gray-400 mt-1">{{ $item['subtitle'] }}</p>
                        @endif
                        <div class="mt-3 grid grid-cols-3 gap-2 text-xs">
                            <div>
                                <p class="text-gray-400 uppercase tracking-wide">Qty</p>
                                <p class="font-semibold text-navy-800 mt-0.5">{{ $item['quantity'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 uppercase tracking-wide">Unit</p>
                                <p class="font-semibold text-navy-800 mt-0.5">{{ $item['unit_price_label'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-400 uppercase tracking-wide">Total</p>
                                <p class="font-bold text-navy-800 mt-0.5">{{ $item['total_label'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Line items: desktop table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3 pr-4">Description</th>
                            <th class="py-3 px-4 text-center">Qty / Days</th>
                            <th class="py-3 px-4 text-right">Unit Price</th>
                            <th class="py-3 pl-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($invoice['line_items'] as $item)
                            <tr>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-navy-800">{{ $item['description'] }}</p>
                                    @if ($item['subtitle'])
                                        <p class="text-xs text-gray-400 mt-1">{{ $item['subtitle'] }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center font-semibold text-navy-800">{{ $item['quantity'] }}</td>
                                <td class="py-4 px-4 text-right font-medium text-navy-800">{{ $item['unit_price_label'] }}</td>
                                <td class="py-4 pl-4 text-right font-bold text-navy-800">{{ $item['total_label'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="mt-6 sm:mt-8 border-t border-gray-200 pt-5 sm:pt-6">
                <div class="w-full sm:ml-auto sm:max-w-[360px] space-y-3 text-sm">
                    <div class="flex justify-between gap-4 font-medium text-gray-500">
                        <span>Space Subtotal</span>
                        <span class="text-navy-800 font-semibold shrink-0">{{ $formatMoney($invoice['totals']['space_subtotal']) }}</span>
                    </div>
                    @if ($invoice['totals']['services_subtotal'] > 0)
                        <div class="flex justify-between gap-4 font-medium text-gray-500">
                            <span>Services Subtotal</span>
                            <span class="text-navy-800 font-semibold shrink-0">{{ $formatMoney($invoice['totals']['services_subtotal']) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between gap-4 font-medium text-gray-500">
                        <span>Tax / GST ({{ rtrim(rtrim(number_format($invoice['totals']['gst_rate'], 2), '0'), '.') }}%)</span>
                        <span class="text-navy-800 font-semibold shrink-0">{{ $formatMoney($invoice['totals']['gst_amount']) }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between items-baseline gap-4">
                        <span class="text-base font-bold text-navy-800">Total Paid</span>
                        <span class="text-xl sm:text-2xl font-bold text-purple-600 shrink-0">{{ $formatMoney($invoice['totals']['total_paid']) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-10 sm:mt-16 text-center text-xs text-gray-400 space-y-2 border-t border-gray-100 pt-6 sm:pt-8 px-2">
                <p>If you have any questions about this invoice, please contact {{ $invoice['support_email'] }}</p>
                <p class="font-medium text-navy-800">Thank you for exhibiting with {{ $invoice['brand_name'] }}!</p>
            </div>
        </div>
    </div>
</body>
</html>
