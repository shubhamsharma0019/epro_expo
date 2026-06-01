@extends('layouts.frontend')

@section('title', 'Payment - ' . (isset($dbEvent) ? $dbEvent->title : 'Global Tech Summit 2024'))

@section('content')
<main class="mx-auto w-full max-w-[1248px] flex-1 px-[24px] pt-6 pb-12">
            <!-- Breadcrumbs -->
            <div class="mb-5 flex items-center gap-2 text-[14px] font-medium text-[#07105C]">
                <a href="{{ url('/events') }}" class="hover:text-[#351EEA]">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#07105C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings') }}" class="hover:text-[#351EEA]">Events</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#07105C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                @if (isset($dbEvent))
                    <a href="{{ route('events.listings.show', $dbEvent->slug) }}" class="hover:text-[#351EEA]">{{ $dbEvent->title }}</a>
                @else
                    <a href="{{ url('/events/listings/global-tech-summit-2024') }}" class="hover:text-[#351EEA]">Global Tech Summit 2024</a>
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#07105C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span>Payment</span>
            </div>

            <div class="grid grid-cols-1 gap-[18px] lg:grid-cols-[1fr_457px]">
                <!-- Left payment column -->
                <section>
                    <div class="mb-[19px] pl-6 pt-2">
                        <h1 class="text-[22px] font-bold leading-tight text-[#070A50]">Payment</h1>
                        <p class="mt-1 text-[15px] font-medium text-[#20266F]">Make secure payment for your booking.</p>
                    </div>

                    <div class="rounded-lg border border-[#E5E3F0] bg-white px-6 pb-6 pt-5 shadow-[0_1px_4px_rgba(31,42,107,0.02)]">
                        <h2 class="mb-[16px] text-[16px] font-bold text-[#070A50]">Choose a payment method</h2>

                        <!-- Card option expanded -->
                        <div data-payment-option="Card / Debit Card" class="payment-option rounded-lg border border-[#7C55FF] bg-white px-4 py-4">
                            <div class="flex items-center gap-5">
                                <button type="button" class="payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border-2 border-[#351EEA]">
                                    <span class="h-[7px] w-[7px] rounded-full bg-[#351EEA]"></span>
                                </button>
                                <span class="w-[155px] text-[15px] font-bold text-[#070A50]">Card / Debit Card</span>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-6 w-[42px] items-center justify-center rounded border border-[#E2E6F2] bg-white text-[13px] font-black italic tracking-tighter text-[#14227D]">VISA</span>
                                    <span class="relative inline-flex h-6 w-[42px] items-center justify-center rounded border border-[#E2E6F2] bg-white">
                                        <span class="absolute left-[10px] h-[15px] w-[15px] rounded-full bg-[#EB001B] opacity-90 mix-blend-multiply"></span>
                                        <span class="absolute right-[10px] h-[15px] w-[15px] rounded-full bg-[#F79E1B] opacity-90 mix-blend-multiply"></span>
                                    </span>
                                    <span class="inline-flex h-6 w-[42px] items-center justify-center rounded bg-[#1377B9] text-[8px] font-black tracking-tight text-white">AMEX</span>
                                    <span class="inline-flex h-6 w-[42px] items-center justify-center rounded border border-[#E2E6F2] bg-white text-[8px] font-black italic text-[#151515]">RuPay</span>
                                </div>
                            </div>

                            <form class="mt-[17px] pl-[41px]">
                                <label class="mb-2 block text-[14px] font-medium text-[#070A50]">Card Number</label>
                                <div class="relative">
                                    <input id="cardNumber" value="4242 4242 4242 4242" maxlength="19" class="h-[43px] w-full rounded-md border border-[#DBDDEA] bg-white px-3 pr-[70px] text-[14px] font-medium text-[#07105C] outline-none focus:border-[#7C55FF]" />
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[17px] font-black italic tracking-tighter text-[#14227D]">VISA</span>
                                </div>

                                <div class="mt-[13px] grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-2 block text-[14px] font-medium text-[#070A50]">Expiry Date</label>
                                        <input id="expiryDate" value="05 / 27" maxlength="7" class="h-[43px] w-full rounded-md border border-[#DBDDEA] bg-white px-3 text-[14px] font-medium text-[#07105C] outline-none focus:border-[#7C55FF]" />
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-[14px] font-medium text-[#070A50]">CVV</label>
                                        <div class="relative">
                                            <input id="cvv" value="123" maxlength="3" class="h-[43px] w-full rounded-md border border-[#DBDDEA] bg-white px-3 pr-10 text-[14px] font-medium text-[#07105C] outline-none focus:border-[#7C55FF]" />
                                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-[#454C93]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M12 9h.008v.008H12V9zm9 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-[13px]">
                                    <label class="mb-2 block text-[14px] font-medium text-[#070A50]">Card Holder Name</label>
                                    <input value="John Doe" id="cardHolderName" class="h-[43px] w-full rounded-md border border-[#DBDDEA] bg-white px-3 text-[14px] font-medium text-[#07105C] outline-none focus:border-[#7C55FF]" />
                                </div>
                            </form>
                        </div>

                        <!-- Other options -->
                        <div class="mt-1.5 space-y-1.5">
                            <button type="button" data-payment-option="UPI" class="payment-option flex h-[47px] w-full items-center gap-6 rounded-md border border-[#E0E2EE] bg-white px-4 text-left hover:border-[#7C55FF]">
                                <span class="payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border border-[#9CA0C5]"></span>
                                <span class="w-[110px] text-[15px] font-bold text-[#070A50]">UPI</span>
                                <span class="inline-flex h-6 w-[45px] items-center justify-center rounded border border-[#E2E6F2] bg-white text-[13px] font-black italic text-[#222]">UPI</span>
                            </button>
                            <button type="button" data-payment-option="Net Banking" class="payment-option flex h-[47px] w-full items-center gap-6 rounded-md border border-[#E0E2EE] bg-white px-4 text-left hover:border-[#7C55FF]">
                                <span class="payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border border-[#9CA0C5]"></span>
                                <span class="w-[110px] text-[15px] font-bold text-[#070A50]">Net Banking</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#242424]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M4.5 10.5h15M6 10.5V18m4-7.5V18m4-7.5V18m4-7.5V18M12 3l8.25 4.5H3.75L12 3z" />
                                </svg>
                            </button>
                            <button type="button" data-payment-option="Wallets" class="payment-option flex h-[47px] w-full items-center gap-6 rounded-md border border-[#E0E2EE] bg-white px-4 text-left hover:border-[#7C55FF]">
                                <span class="payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border border-[#9CA0C5]"></span>
                                <span class="w-[110px] text-[15px] font-bold text-[#070A50]">Wallets</span>
                                <span class="inline-flex h-6 w-[50px] items-center justify-center rounded border border-[#E2E6F2] bg-white text-[13px] font-black italic text-[#063F90]">PayPal</span>
                            </button>
                            <button type="button" data-payment-option="Pay Later" class="payment-option flex h-[47px] w-full items-center gap-6 rounded-md border border-[#E0E2EE] bg-white px-4 text-left hover:border-[#7C55FF]">
                                <span class="payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border border-[#9CA0C5]"></span>
                                <span class="w-[110px] text-[15px] font-bold text-[#070A50]">Pay Later</span>
                                <span class="inline-flex h-6 w-[50px] items-center justify-center rounded border border-[#E2E6F2] bg-white text-[15px] font-black text-[#1D4F9F]">pay<span class="text-[#00A0E8]">tm</span></span>
                            </button>
                        </div>

                        <div class="mt-4 flex h-[51px] items-center gap-3 rounded-md bg-[#F7F3FF] px-5 text-[14px] font-semibold text-[#07105C]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[19px] w-[19px] text-[#10A950]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5 0 00-9 0v3m-.75 0h10.5A1.5 1.5 0 0118.75 12v6.75a1.5 1.5 0 01-1.5 1.5H6.75a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z" />
                            </svg>
                            <span>Your payment is secure and encrypted.</span>
                        </div>

                        <div class="mt-[26px] flex items-center justify-between">
                            <button onclick="window.history.back()" class="h-[42px] w-[96px] rounded-[5px] border border-[#8F68FF] bg-white text-[14px] font-bold text-[#351EEA] hover:bg-[#F7F3FF]">Back</button>
                            <button id="payBtn" class="h-[42px] w-[186px] rounded-[5px] bg-[#351EEA] text-[14px] font-bold text-white shadow-[0_10px_22px_rgba(53,30,234,0.25)] hover:bg-[#2515C9]">Pay ₹98.00</button>
                        </div>
                    </div>
                </section>

                <!-- Right summary column -->
                <aside class="space-y-[14px]">
                    <div class="rounded-lg border border-[#E5E3F0] bg-white px-6 pb-6 pt-[22px] shadow-[0_1px_4px_rgba(31,42,107,0.02)]">
                        <h2 class="mb-[15px] text-[18px] font-bold text-[#070A50]">Order Summary</h2>

                        <div class="rounded-md bg-[#FBFAFF] p-4 shadow-[0_18px_36px_rgba(31,42,107,0.04)]">
                            <div class="flex gap-4">
                                <img src="{{ $dbEvent && $dbEvent->branding?->banner_path ? asset('storage/' . $dbEvent->branding->banner_path) : asset('images/events/banner_bg.png') }}" alt="Event image" class="h-[69px] w-[74px] shrink-0 rounded object-cover bg-gray-200" />
                                <div class="min-w-0 pt-1">
                                    <h3 class="truncate text-[15px] font-bold text-[#07105C]">{{ $dbEvent ? $dbEvent->title : 'Global Tech Summit 2024' }}</h3>
                                    <p class="mt-3 flex items-center gap-2 text-[13px] font-medium text-[#20266F]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $dbEvent && $dbEvent->starts_at ? ($dbEvent->starts_at->format('M d') . ' - ' . ($dbEvent->ends_at ? $dbEvent->ends_at->format('M d, Y') : $dbEvent->starts_at->format('Y'))) : 'May 15 - May 17, 2024' }}
                                    </p>
                                    <p class="mt-2 flex items-start gap-2 text-[13px] font-medium leading-[20px] text-[#20266F]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $dbEvent ? $dbEvent->venue_name . ',' : 'Jio World Convention Centre,' }}<br />{{ $dbEvent ? $dbEvent->city : 'Mumbai' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-[24px]">
                            <div class="mb-3 flex items-center justify-between">
                                <h3 class="text-[15px] font-bold text-[#07105C]">Tickets</h3>
                                <a href="{{ url('/events/tickets/select') }}" class="text-[13px] font-bold text-[#351EEA]">Edit</a>
                            </div>
                            <div class="flex items-center justify-between text-[14px] font-medium text-[#07105C]">
                                <span id="right-pass-name">General Pass &times; 2</span>
                                <span id="right-pass-total">₹98.00</span>
                            </div>
                        </div>

                        <div class="my-[20px] border-t border-dashed border-[#DBDDEC]"></div>

                        <div class="flex items-center justify-between text-[14px] font-medium text-[#07105C]">
                            <span>Total Tickets</span>
                            <span id="right-total-tickets">2</span>
                        </div>

                        <div class="mt-[29px] flex items-center justify-between">
                            <span class="text-[18px] font-bold text-[#07105C]">Total Amount</span>
                            <span class="text-[27px] font-extrabold tracking-[-0.04em] text-[#07105C]" id="right-total-amount">₹98.00</span>
                        </div>
                    </div>

                    <div class="rounded-lg border border-[#E5E3F0] bg-white px-6 pb-6 pt-5 shadow-[0_1px_4px_rgba(31,42,107,0.02)]">
                        <div class="mb-[18px] flex items-center justify-between">
                            <h2 class="text-[15px] font-bold text-[#070A50]" id="right-attendees-title">Attendee Details (2)</h2>
                            <a href="{{ url('/events/tickets/attendee-details') }}" class="text-[13px] font-bold text-[#351EEA]">Edit</a>
                        </div>

                        <div class="space-y-[26px]" id="right-attendees-list">
                            <!-- Populated dynamically via JavaScript -->
                        </div>
                    </div>

                    <div class="rounded-lg border border-[#E5E3F0] bg-white p-4 shadow-[0_1px_4px_rgba(31,42,107,0.02)]">
                        <div class="flex items-start gap-3">
                            <div class="flex h-[31px] w-[31px] shrink-0 items-center justify-center rounded-full text-[#351EEA]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[13px] font-semibold text-[#07105C]">Your payment is secure and encrypted.</p>
                                <p class="mt-2 text-[12px] font-medium leading-[20px] text-[#20266F]">
                                    By proceeding, you agree to our <a href="{{ url('/events') }}" class="font-bold text-[#351EEA]">Terms &amp; Conditions</a> and <a href="{{ url('/events') }}" class="font-bold text-[#351EEA]">Cancellation Policy</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
@endsection

@push('scripts')
@if (isset($razorpayEnabled) && $razorpayEnabled)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif
<script>
const options = document.querySelectorAll('.payment-option');

        options.forEach((option) => {
            option.addEventListener('click', () => {
                options.forEach((item) => {
                    const radio = item.querySelector('.payment-radio');
                    item.classList.remove('border-[#7C55FF]');
                    item.classList.add('border-[#E0E2EE]');
                    if (radio) {
                        radio.className = 'payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border border-[#9CA0C5]';
                        radio.innerHTML = '';
                    }
                });

                option.classList.remove('border-[#E0E2EE]');
                option.classList.add('border-[#7C55FF]');

                const selectedRadio = option.querySelector('.payment-radio');
                if (selectedRadio) {
                    selectedRadio.className = 'payment-radio flex h-[19px] w-[19px] shrink-0 items-center justify-center rounded-full border-2 border-[#351EEA]';
                    selectedRadio.innerHTML = '<span class="h-[7px] w-[7px] rounded-full bg-[#351EEA]"></span>';
                }
            });
        });

        const cardNumber = document.getElementById('cardNumber');
        if (cardNumber) {
            cardNumber.addEventListener('input', (event) => {
                let value = event.target.value.replace(/\D/g, '').slice(0, 16);
                event.target.value = value.replace(/(.{4})/g, '$1 ').trim();
            });
        }

        const expiryDate = document.getElementById('expiryDate');
        if (expiryDate) {
            expiryDate.addEventListener('input', (event) => {
                let value = event.target.value.replace(/\D/g, '').slice(0, 4);
                if (value.length > 2) value = value.slice(0, 2) + ' / ' + value.slice(2);
                event.target.value = value;
            });
        }

        const cvv = document.getElementById('cvv');
        if (cvv) {
            cvv.addEventListener('input', (event) => {
                event.target.value = event.target.value.replace(/\D/g, '').slice(0, 3);
            });
        }

        document.getElementById('payBtn').addEventListener('click', async () => {
            const orderData = JSON.parse(localStorage.getItem("eventOrder"));
            if (!orderData) {
                alert("Order data not found.");
                return;
            }

            @if(isset($razorpayEnabled) && $razorpayEnabled)
            try {
                const response = await fetch("{{ route('events.tickets.payment.razorpay-order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ amount: orderData.totalAmount || 98.00 })
                });
                const data = await response.json();
                
                if (!response.ok) {
                    alert(data.message || 'Error creating payment order');
                    return;
                }

                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: data.currency,
                    name: data.name,
                    description: data.description,
                    order_id: data.order_id,
                    handler: function (response) {
                        submitOrder(orderData, response);
                    },
                    theme: { color: "#351EEA" }
                };
                const rzp = new Razorpay(options);
                rzp.open();
            } catch (err) {
                alert('Payment gateway error. Please try again.');
            }
            @else
            submitOrder(orderData, null);
            @endif
        });

        function submitOrder(orderData, razorpayResponse) {
            const form = document.createElement('form');
            form.method = 'POST';
            
            // If razorpayResponse exists, hit verify. Else fallback to confirm.
            form.action = razorpayResponse ? "{{ route('events.tickets.payment.verify') }}" : "{{ route('events.tickets.payment.confirm') }}";
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = 'orderData';
            dataInput.value = JSON.stringify(orderData);
            form.appendChild(dataInput);

            if (razorpayResponse) {
                const fields = ['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature'];
                fields.forEach(field => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = field;
                    input.value = razorpayResponse[field];
                    form.appendChild(input);
                });
            }
            
            document.body.appendChild(form);
            form.submit();
        }

        // Initialize UI from localStorage
        document.addEventListener("DOMContentLoaded", () => {
            const orderData = JSON.parse(localStorage.getItem("eventOrder"));
            if (!orderData) return;

            const qty = orderData.quantity || 1;
            const currency = orderData.priceCurrency || (orderData.eventSlug && orderData.eventSlug !== 'global-tech-summit-2024' ? 'INR' : '₹');
            const currencySymbol = currency === 'USD' ? '$' : (currency === 'INR' || currency === '₹' ? '₹' : currency + ' ');

            // Update Right Side Summary Card
            document.getElementById("right-pass-name").innerHTML = `${orderData.passName} &times; ${qty}`;
            document.getElementById("right-pass-total").innerText = `${currencySymbol}${orderData.totalAmount.toFixed(2)}`;
            document.getElementById("right-total-tickets").innerText = qty;
            document.getElementById("right-total-amount").innerText = `${currencySymbol}${orderData.totalAmount.toFixed(2)}`;

            // Update Pay Button Text
            document.getElementById("payBtn").innerText = `Pay ${currencySymbol}${orderData.totalAmount.toFixed(2)}`;

            // Update Attendee Details
            document.getElementById("right-attendees-title").innerText = `Attendee Details (${qty})`;
            const attendees = orderData.attendees || [];
            const rightAttendeesList = document.getElementById("right-attendees-list");
            let attendeesHtml = '';

            for (let i = 0; i < qty; i++) {
                const att = attendees[i] || {
                    name: orderData.attendee_name || 'Attendee',
                    email: orderData.attendee_email || 'N/A',
                    phone: orderData.attendee_phone || 'N/A'
                };
                
                const initials = att.name ? att.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'A';

                attendeesHtml += `
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#F2EFFC] text-[12px] font-bold text-[#07105C]">${initials}</div>
                    <div>
                        <h3 class="text-[14px] font-bold text-[#07105C]">${att.name}</h3>
                        <p class="mt-1 text-[13px] font-medium text-[#07105C]">${att.email}</p>
                        <p class="mt-2 text-[13px] font-medium text-[#07105C]">${att.phone}</p>
                    </div>
                </div>
                `;
            }
            rightAttendeesList.innerHTML = attendeesHtml;

            // Fill card holder name if logged in
            const cardHolder = document.getElementById("cardHolderName");
            if (cardHolder && orderData.attendee_name) {
                cardHolder.value = orderData.attendee_name;
            }
        });
</script>
@endpush
