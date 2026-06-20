@extends('layouts.company-flow')

@section('title', 'EproExpo Payment')

@section('content')
@php
    $company = \App\Domain\Company\Models\Company::find(session('company_id'));
    $selectedBoothCount = count($booking->selected_booth_ids ?: [$booking->booth_id]);
    $selectedBoothLabel = $selectedBoothCount > 1
        ? $selectedBoothCount . ' linked booths'
        : ($booking->booth ? 'Booth ' . $booking->booth->booth_number : 'Booth');
@endphp
<section class="mx-auto w-full max-w-[1400px] px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-[28px] font-semibold leading-tight tracking-[-0.5px] text-navy sm:text-[34px]">
            Payment
        </h1>
        <p class="mt-2 max-w-[760px] text-[15px] leading-6 text-[#5A6480] sm:text-[16px]">
            Complete your booking through Razorpay. Your booth is confirmed only after backend payment verification.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
        <div class="min-w-0 space-y-6">
            <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-7">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h2 class="text-[22px] font-semibold text-navy">Razorpay Checkout</h2>
                        <p class="mt-2 text-[14px] leading-6 text-[#5A6480] sm:text-[15px]">
                            Razorpay opens a secure checkout for UPI, cards, net banking, wallets, and supported payment options.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 text-[12px] font-semibold text-purple sm:text-[13px]">
                        <span class="rounded-full border border-[#DCD4FF] bg-[#FBFAFF] px-3 py-2">UPI</span>
                        <span class="rounded-full border border-[#DCD4FF] bg-[#FBFAFF] px-3 py-2">Cards</span>
                        <span class="rounded-full border border-[#DCD4FF] bg-[#FBFAFF] px-3 py-2">Net Banking</span>
                        <span class="rounded-full border border-[#DCD4FF] bg-[#FBFAFF] px-3 py-2">Wallets</span>
                    </div>
                </div>

                <div class="mt-6 rounded-xl border border-[#E7EAF3] bg-[#FBFCFF] p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <span class="text-[15px] font-semibold text-navy">Amount to Pay</span>
                        <span id="payment-amount-main" class="text-[30px] font-semibold leading-none text-navy">&#8377;{{ number_format($amountToPay) }}</span>
                    </div>
                    <button type="button" id="razorpay-pay-button" @disabled(! $razorpayEnabled)
                        class="mt-5 inline-flex h-[56px] w-full items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[17px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)] transition disabled:cursor-not-allowed disabled:opacity-55 sm:w-auto sm:min-w-[300px]">
                        <i class="fa-solid fa-lock text-[15px]"></i>
                        Pay with Razorpay
                    </button>
                </div>

                @unless ($razorpayEnabled)
                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-[14px] leading-6 text-amber-800">
                        Razorpay keys are not configured. Add <strong>RAZORPAY_KEY_ID</strong> and <strong>RAZORPAY_KEY_SECRET</strong> in your environment before collecting payments.
                    </div>
                    <form method="POST" action="{{ route('company.booth-booking.payment.continue') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="inline-flex h-[52px] w-full items-center justify-center rounded-md border border-[#B9A7FF] bg-white px-6 text-[16px] font-semibold text-purple transition hover:bg-[#F8F5FF] sm:w-auto sm:min-w-[300px]">
                            Continue to Confirmation
                        </button>
                    </form>
                @endunless

                <div id="payment-status" class="mt-6 hidden rounded-xl border px-5 py-4 text-[15px] font-medium"></div>
            </div>
        </div>

        <aside class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6 xl:self-start">
            <div class="mb-6 flex items-center justify-between gap-5">
                <h2 class="text-[22px] font-semibold text-navy">Booking Summary</h2>
                <a href="{{ url('/company/booth-booking/services?' . http_build_query(array_filter(['exhibition' => session('company_booth_booking.exhibition_slug')]))) }}" class="text-[14px] font-semibold text-purple">Edit</a>
            </div>

            <div class="space-y-4 text-[14px] text-navy sm:text-[15px]">
                <div class="flex items-center justify-between gap-5"><span class="text-[#5A6480]">Exhibition</span><span class="text-right font-semibold">{{ $booking->exhibition?->title ?? $booking->exhibition?->name ?? 'Exhibition' }}</span></div>
                <div class="flex items-center justify-between gap-5"><span class="text-[#5A6480]">Pavilion</span><span id="summary-pavilion" class="text-right font-semibold">{{ $booking->pavilion?->title ?? 'Pavilion' }}</span></div>
                <div class="flex items-center justify-between gap-5"><span class="text-[#5A6480]">Hall</span><span id="summary-hall" class="text-right font-semibold">{{ $booking->hall?->title ?? 'Hall' }}</span></div>
                <div class="flex items-center justify-between gap-5"><span class="text-[#5A6480]">Booth</span><span id="summary-booth" class="text-right font-semibold">{{ $selectedBoothLabel }}</span></div>
                <div class="flex items-start justify-between gap-5"><span class="text-[#5A6480]">Selected Days</span><span id="summary-days" class="max-w-[220px] text-right font-semibold">{{ $daysLabel }}</span></div>
                <div class="flex items-center justify-between gap-5"><span class="text-[#5A6480]">Duration</span><span id="summary-duration" class="text-right font-semibold">{{ $selectedDays->count() }} {{ $selectedDays->count() === 1 ? 'Day' : 'Days' }}</span></div>
                <div class="flex items-center justify-between gap-5"><span class="text-[#5A6480]">Services</span><span id="summary-services" class="text-right font-semibold">{{ $bookingServices->count() }} Selected</span></div>
            </div>

            <div class="my-6 border-t border-borderColor"></div>

            <div class="space-y-4 text-[15px] text-[#34405F]">
                <div class="flex items-center justify-between gap-5"><span>Booth Price</span><span id="amount-booth-price" class="font-semibold text-navy">&#8377;{{ number_format($boothPrice) }}</span></div>
                <div class="flex items-center justify-between gap-5"><span>Days Amount</span><span id="amount-days" class="font-semibold text-navy">&#8377;{{ number_format($daysAmount) }}</span></div>
                <div class="flex items-center justify-between gap-5"><span>Services Amount</span><span id="amount-services" class="font-semibold text-navy">&#8377;{{ number_format($servicesAmount) }}</span></div>
            </div>

            <div class="my-6 border-t border-borderColor"></div>

            <div class="flex items-center justify-between gap-5">
                <span class="text-[17px] font-semibold text-navy">Amount to Pay</span>
                <span id="payment-amount-summary" class="text-[28px] font-semibold leading-none text-navy">&#8377;{{ number_format($amountToPay) }}</span>
            </div>
        </aside>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    (() => {
        const payButton = document.getElementById('razorpay-pay-button');
        const statusBox = document.getElementById('payment-status');
        const field = (id) => document.getElementById(id);

        const showStatus = (message, type = 'info') => {
            if (!statusBox) return;
            const classes = {
                info: 'border-[#DCD4FF] bg-[#FBFAFF] text-[#5b2eff]',
                error: 'border-red-200 bg-red-50 text-red-700',
                success: 'border-green-200 bg-green-50 text-green-700',
            };
            statusBox.className = `mt-6 rounded-xl border px-5 py-4 text-[15px] font-medium ${classes[type] || classes.info}`;
            statusBox.textContent = message;
            statusBox.classList.remove('hidden');
        };

        const applyPaymentSummary = (payload) => {
            if (!payload?.summary || !payload?.amounts) {
                return;
            }

            field('summary-pavilion').textContent = payload.summary.pavilion;
            field('summary-hall').textContent = payload.summary.hall;
            field('summary-booth').textContent = payload.summary.booth;
            field('summary-days').textContent = payload.summary.selected_days;
            field('summary-duration').textContent = payload.summary.duration;
            field('summary-services').textContent = payload.summary.services;
            field('amount-booth-price').textContent = payload.amounts.booth_price_display;
            field('amount-days').textContent = payload.amounts.days_amount_display;
            field('amount-services').textContent = payload.amounts.services_amount_display;
            field('payment-amount-main').textContent = payload.amounts.amount_to_pay_display;
            field('payment-amount-summary').textContent = payload.amounts.amount_to_pay_display;

            if (payButton) {
                payButton.disabled = !payload.razorpay_enabled;
            }

            if (!payload.razorpay_enabled) {
                showStatus('Razorpay keys are missing, so payment cannot start yet.', 'error');
            }
        };

        const loadPaymentSummary = async () => {
            const response = await fetch(@json(route('company.booth-booking.payment.summary')), {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                },
            });
            const payload = await response.json();

            if (!response.ok) {
                throw new Error(payload.message || 'Unable to load payment summary.');
            }

            applyPaymentSummary(payload);
            return payload;
        };

        loadPaymentSummary().catch((error) => {
            showStatus(error.message || 'Unable to load payment summary.', 'error');
        });

        payButton?.addEventListener('click', async () => {
            if (!window.Razorpay) {
                showStatus('Razorpay checkout could not be loaded. Please check your internet connection.', 'error');
                return;
            }

            payButton.disabled = true;
            showStatus('Creating secure Razorpay order...');

            try {
                await loadPaymentSummary();

                const orderResponse = await fetch(@json(route('company.booth-booking.payment.razorpay-order')), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token()),
                    },
                });
                const order = await orderResponse.json();

                if (!orderResponse.ok) {
                    throw new Error(order.message || 'Unable to create payment order.');
                }

                const checkout = new Razorpay({
                    key: order.key,
                    amount: order.amount,
                    currency: order.currency,
                    name: order.name,
                    description: order.description,
                    order_id: order.order_id,
                    prefill: {
                        name: @json($company?->contact_person_name ?? $company?->owner_name ?? $company?->company_name ?? ''),
                        email: @json($company?->email ?? ''),
                        contact: @json($company?->phone ?? ''),
                    },
                    theme: {
                        color: '#5b2eff',
                    },
                    handler: async (response) => {
                        try {
                            showStatus('Verifying payment securely...');

                            const verifyResponse = await fetch(@json(route('company.booth-booking.payment.verify')), {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': @json(csrf_token()),
                                },
                                body: JSON.stringify(response),
                            });
                            const result = await verifyResponse.json();

                            if (!verifyResponse.ok) {
                                throw new Error(result.message || 'Payment verification failed.');
                            }

                            showStatus(result.message || 'Payment verified successfully.', 'success');
                            window.location.href = result.redirect_url;
                        } catch (error) {
                            payButton.disabled = false;
                            showStatus(error.message || 'Payment verification failed.', 'error');
                        }
                    },
                    modal: {
                        ondismiss: () => {
                            payButton.disabled = false;
                            showStatus('Payment was cancelled before completion.', 'error');
                        },
                    },
                });

                checkout.open();
            } catch (error) {
                payButton.disabled = false;
                showStatus(error.message || 'Payment could not be completed.', 'error');
            }
        });
    })();
</script>
@endpush
