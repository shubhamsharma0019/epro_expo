@extends('layouts.company-event')

@section('title', 'Event Publishing Payment | eproexpo')

@section('content')
@php
    $contactName = $companyEvent->company?->contact_person_name ?? $companyEvent->company?->owner_name ?? $companyEvent->company?->company_name ?? 'Organizer';
@endphp
<div class="flex min-h-full flex-col">
    <!-- Top Nav -->
    <header class="bg-white flex justify-between items-center px-5 py-6 sm:px-8 lg:px-10 border-b border-gray-100 shrink-0">
        <div class="flex items-center gap-3">
            <h1 class="text-[18px] font-bold text-[#1C1364]">Event Payment & Activation</h1>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-1 text-[13px] font-medium cursor-pointer hidden sm:flex">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                EN
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
            <div class="flex items-center gap-3">
                <img src="https://i.pravatar.cc/150?img=11" alt="{{ $contactName }}" class="w-9 h-9 rounded-full object-cover">
                <div>
                    <h4 class="text-[13px] font-bold">{{ $contactName }}</h4>
                    <p class="text-[11px] text-[#6B7280] font-medium">Organizer</p>
                </div>
            </div>
        </div>
    </header>

    <div class="px-5 py-10 sm:px-8 lg:px-10 max-w-[1200px] w-full flex flex-col mx-auto flex-1 gap-8 lg:flex-row lg:gap-12">
        
        <!-- Left Column: Checkout details & Payment Methods -->
        <div class="min-w-0 flex-1 flex flex-col gap-8">
            <!-- Payment Form -->
            <div class="border border-gray-100 rounded-[16px] bg-white p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                <h3 class="text-[18px] font-bold text-[#1C1364] mb-6">Payment Method</h3>
                
                <!-- Cards Selection Tabs -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-[#4C10D0] bg-gray-50 p-4 text-center">
                        <svg class="text-[#4C10D0] mb-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span class="text-[13px] font-bold text-[#1C1364]">Credit/Debit Card</span>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer text-center opacity-65 hover:opacity-100 transition-opacity">
                        <svg class="text-gray-500 mb-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span class="text-[13px] font-medium text-[#5B6B8A]">Net Banking</span>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer text-center opacity-65 hover:opacity-100 transition-opacity">
                        <svg class="text-gray-500 mb-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v8"></path><path d="M8 12h8"></path></svg>
                        <span class="text-[13px] font-medium text-[#5B6B8A]">UPI / Wallet</span>
                    </div>
                </div>

                <form id="payment-form" action="{{ route('company.event-company-flow.payment.pay', $companyEvent) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[13px] font-bold text-[#1C1364] mb-2">Cardholder Name</label>
                        <input type="text" value="{{ $contactName }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[13px] text-[#1C1364] font-medium focus:outline-none focus:border-[#4C10D0]" required>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1C1364] mb-2">Card Number</label>
                        <div class="relative">
                            <input type="text" placeholder="••••  ••••  ••••  4242" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[13px] text-[#1C1364] font-medium focus:outline-none focus:border-[#4C10D0]" required>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <svg width="28" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400"><rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-bold text-[#1C1364] mb-2">Expiration Date</label>
                            <input type="text" placeholder="MM/YY" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[13px] text-[#1C1364] font-medium focus:outline-none focus:border-[#4C10D0]" required>
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-[#1C1364] mb-2">CVV</label>
                            <input type="text" placeholder="•••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[13px] text-[#1C1364] font-medium focus:outline-none focus:border-[#4C10D0]" required>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex flex-col gap-4">
                        <button type="button" id="payBtn" style="background-color: #4C10D0; color: #FFFFFF;" class="w-full py-4 rounded-lg text-[14px] font-bold hover:bg-[#3d0ba8] transition-colors shadow-[0_4px_14px_rgba(76,16,208,0.3)]">
                            Pay & Publish Event
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="w-full lg:w-[420px] shrink-0">
            <div class="border border-gray-100 rounded-[16px] bg-white p-6 sm:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.02)] sticky top-6">
                <h3 class="text-[16px] font-bold text-[#1C1364] mb-5">Order Summary</h3>
                
                <!-- Event Card Summary -->
                <div class="bg-gray-50/60 rounded-xl p-4 mb-6 border border-gray-100">
                    <span class="mb-3 inline-block rounded bg-gray-100 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-[#4C10D0]">
                        {{ ucfirst($companyEvent->category ?? 'Event') }}
                    </span>
                    <h4 class="text-[14px] font-bold text-[#1C1364] mb-1.5 leading-snug">{{ $companyEvent->title }}</h4>
                    
                    <div class="flex items-center gap-2 text-[12px] text-[#5B6B8A] mb-1">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>{{ $companyEvent->starts_at ? $companyEvent->starts_at->format('M d, Y') : 'Date TBD' }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2 text-[12px] text-[#5B6B8A]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>{{ $companyEvent->venue_name ?? $companyEvent->venue_address ?? 'Location TBD' }}</span>
                    </div>
                </div>

                <!-- Price list -->
                <div class="space-y-3.5 text-[13px] font-medium text-[#5B6B8A] pb-5 border-b border-gray-100">
                    <div class="flex justify-between">
                        <span>Standard Publishing Fee</span>
                        <span class="text-[#1C1364] font-bold">₹149.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Taxes (GST 18%)</span>
                        <span class="text-[#1C1364] font-bold">₹26.82</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Platform Discount</span>
                        <span class="text-green-600 font-bold">-₹26.82</span>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex justify-between items-center pt-5">
                    <span class="text-[14px] font-bold text-[#1C1364]">Amount to Pay</span>
                    <span class="text-[20px] font-black text-[#1C1364]">₹149.00</span>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@push('scripts')
@if (isset($razorpayEnabled) && $razorpayEnabled)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif
<script>
    document.getElementById('payBtn').addEventListener('click', async () => {
        const payBtn = document.getElementById('payBtn');
        const originalText = payBtn.innerText;
        payBtn.innerText = 'Processing...';
        payBtn.disabled = true;

        @if(isset($razorpayEnabled) && $razorpayEnabled)
        try {
            const response = await fetch("{{ route('company.event-company-flow.payment.razorpay-order', $companyEvent) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await response.json();
            
            if (!response.ok) {
                alert(data.message || 'Error creating payment order');
                payBtn.innerText = originalText;
                payBtn.disabled = false;
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
                    submitOrder(response);
                },
                modal: {
                    ondismiss: function() {
                        payBtn.innerText = originalText;
                        payBtn.disabled = false;
                    }
                },
                theme: { color: "#4C10D0" }
            };
            const rzp = new Razorpay(options);
            rzp.open();
        } catch (err) {
            alert('Payment gateway error. Please try again.');
            payBtn.innerText = originalText;
            payBtn.disabled = false;
        }
        @else
        submitOrder(null);
        @endif
    });

    function submitOrder(razorpayResponse) {
        const form = document.getElementById('payment-form');
        
        form.action = razorpayResponse 
            ? "{{ route('company.event-company-flow.payment.verify', $companyEvent) }}" 
            : "{{ route('company.event-company-flow.payment.pay', $companyEvent) }}";
        
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
        
        form.submit();
    }
</script>
@endpush
