@extends('layouts.frontend')

@section('title', 'Attendee Details - Global Tech Summit 2024')

@section('content')
<main class="px-[44px] pt-6 pb-12 flex-1 max-w-[1200px] w-full mx-auto">
            <!-- Breadcrumbs -->
            <div class="mb-8 flex items-center gap-2 text-[14px] text-[#6A708F]">
                <a href="{{ url('/events') }}" class="hover:text-[#5B35D5] transition">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings') }}" class="hover:text-[#5B35D5] transition">Events</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings/global-tech-summit-2024') }}" class="hover:text-[#5B35D5] transition">Global Tech Summit 2024</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-[#1F2A6A]">Attendee Details</span>
            </div>

            <!-- Page content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column: Attendee Forms -->
                <div class="lg:col-span-8">
                    <div class="mb-6">
                        <h2 class="text-[22px] font-bold text-[#1F2A6A]">Attendee Information</h2>
                        <p class="mt-2 text-[15px] text-[#4E567A]">Enter details of the attendees for this booking.</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Attendee 1 -->
                        <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-7 shadow-[0_2px_10px_rgba(31,42,107,0.02)]">
                            <div class="mb-5 flex items-center justify-between">
                                <h3 class="text-[16px] font-bold text-[#1F2A6A]">Attendee 1</h3>
                                <button class="flex items-center gap-1.5 text-[14px] font-semibold text-[#E03137] hover:text-[#C92A2F] transition">
                                    <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Full Name -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Full Name <span class="text-[#E03137]">*</span></label>
                                    <input type="text" value="John Doe" class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                                
                                <!-- Email -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Email Address <span class="text-[#E03137]">*</span></label>
                                    <input type="email" value="john.doe@example.com" class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                                
                                <!-- Phone -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Phone Number <span class="text-[#E03137]">*</span></label>
                                    <div class="flex items-center overflow-hidden rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] transition focus-within:border-[#5B35D5] focus-within:bg-white">
                                        <button class="flex items-center gap-2 border-r border-[#E8E3F0] px-4 py-3 text-[14px] font-medium text-[#1F2A6A] hover:bg-[#F1EFF7] transition">
                                            <img src="https://flagcdn.com/w20/in.png" alt="India Flag" class="h-3.5 w-5 rounded-sm object-cover" />
                                            <svg class="h-3 w-3 text-[#6A708F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                        </button>
                                        <input type="tel" value="+91 98765 43210" class="w-full bg-transparent px-4 py-3 text-[14px] text-[#1F2A6A] outline-none" />
                                    </div>
                                </div>
                                
                                <!-- Company -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Company (Optional)</label>
                                    <input type="text" value="Tech Solutions Inc." class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                                
                                <!-- Job Title -->
                                <div class="flex flex-col gap-2 md:col-span-1">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Job Title <span class="text-[#E03137]">*</span></label>
                                    <input type="text" value="CEO" class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                            </div>
                        </div>

                        <!-- Attendee 2 -->
                        <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-7 shadow-[0_2px_10px_rgba(31,42,107,0.02)]">
                            <div class="mb-5 flex items-center justify-between">
                                <h3 class="text-[16px] font-bold text-[#1F2A6A]">Attendee 2</h3>
                                <button class="flex items-center gap-1.5 text-[14px] font-semibold text-[#E03137] hover:text-[#C92A2F] transition">
                                    <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Full Name -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Full Name <span class="text-[#E03137]">*</span></label>
                                    <input type="text" value="Jane Smith" class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                                
                                <!-- Email -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Email Address <span class="text-[#E03137]">*</span></label>
                                    <input type="email" value="jane.smith@example.com" class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                                
                                <!-- Phone -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Phone Number <span class="text-[#E03137]">*</span></label>
                                    <div class="flex items-center overflow-hidden rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] transition focus-within:border-[#5B35D5] focus-within:bg-white">
                                        <button class="flex items-center gap-2 border-r border-[#E8E3F0] px-4 py-3 text-[14px] font-medium text-[#1F2A6A] hover:bg-[#F1EFF7] transition">
                                            <img src="https://flagcdn.com/w20/in.png" alt="India Flag" class="h-3.5 w-5 rounded-sm object-cover" />
                                            <svg class="h-3 w-3 text-[#6A708F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                        </button>
                                        <input type="tel" value="+91 987 654 3210" class="w-full bg-transparent px-4 py-3 text-[14px] text-[#1F2A6A] outline-none" />
                                    </div>
                                </div>
                                
                                <!-- Company -->
                                <div class="flex flex-col gap-2">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Company (Optional)</label>
                                    <input type="text" value="Tech Solutions Inc." class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                                
                                <!-- Job Title -->
                                <div class="flex flex-col gap-2 md:col-span-1">
                                    <label class="text-[13px] font-bold text-[#1F2A6A]">Job Title <span class="text-[#E03137]">*</span></label>
                                    <input type="text" value="CTO" class="rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add more attendees button -->
                    <button class="mt-6 mb-8 flex items-center gap-2 rounded-xl border border-[#B9A8F3] px-6 py-3 text-[14px] font-bold text-[#5B35D5] transition hover:bg-[#F4F0FF]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add more attendees
                    </button>

                    <!-- Bottom Actions -->
                    <div class="flex items-center justify-between border-t border-[#E8E3F0] pt-8">
                        <button onclick="window.history.back()" class="rounded-xl border border-[#B9A8F3] px-9 py-3.5 text-[15px] font-bold text-[#5B35D5] transition hover:bg-[#F4F0FF] hover:border-[#5B35D5]">
                            Back
                        </button>
                        <button onclick="window.location.href='{{ url('/events/tickets/summary') }}'" class="rounded-xl bg-[#4318FF] px-10 py-3.5 text-[15px] font-bold text-white transition hover:bg-[#3412C9] shadow-[0_8px_20px_rgba(67,24,255,0.25)]">
                            Continue
                        </button>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-4">
                    <div class="rounded-[20px] border border-[#E8E3F0] bg-[#FAFAFC] p-8 sticky top-8">
                        <h3 class="mb-7 text-[20px] font-bold text-[#1F2A6A]">Order Summary</h3>
                        
                        <!-- Event Info -->
                        <div class="mb-7 rounded-2xl bg-[#F4F0FF] p-5 border border-[#E8E3F0]">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-[#5B35D5] shadow-[0_2px_8px_rgba(91,53,213,0.08)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[22px] w-[22px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-[15px] font-bold text-[#1F2A6A]">Global Tech Summit 2024</h4>
                                    <p class="mt-1 text-[13px] font-medium text-[#4E567A]">May 15 - May 17, 2024</p>
                                    <p class="mt-1 text-[13px] leading-[1.5] text-[#6A708F]">Jio World Convention Centre,<br>Mumbai</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets Summary -->
                        <div class="border-b border-[#E8E3F0] pb-6">
                            <h4 class="mb-4 text-[16px] font-bold text-[#1F2A6A]">Tickets</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-[14.5px] font-medium text-[#4E567A]">General Pass &times; 2</span>
                                <span class="text-[15px] font-bold text-[#1F2A6A]">₹98.00</span>
                            </div>
                        </div>
                        
                        <!-- Total Amount -->
                        <div class="flex items-center justify-between border-b border-[#E8E3F0] py-6">
                            <span class="text-[16px] font-bold text-[#1F2A6A]">Total Amount</span>
                            <span class="text-[26px] font-extrabold text-[#1F2A6A]">₹98.00</span>
                        </div>

                        <!-- Attendee Preview Summary -->
                        <div class="py-6">
                            <div class="mb-5 flex items-center justify-between">
                                <h4 class="text-[16px] font-bold text-[#1F2A6A]">Attendee Details</h4>
                                <button class="text-[14px] font-bold text-[#5B35D5] hover:underline">Edit</button>
                            </div>
                            
                            <!-- Attendee 1 -->
                            <div class="mb-5">
                                <h5 class="mb-1.5 text-[14px] font-bold text-[#1F2A6A]">Attendee 1</h5>
                                <p class="text-[13.5px] leading-relaxed text-[#4E567A]">John Doe</p>
                                <p class="text-[13.5px] leading-relaxed text-[#4E567A]">john.doe@example.com</p>
                                <p class="text-[13.5px] leading-relaxed text-[#4E567A]">+91 98765 43210</p>
                            </div>
                            
                            <!-- Attendee 2 -->
                            <div>
                                <h5 class="mb-1.5 text-[14px] font-bold text-[#1F2A6A]">Attendee 2</h5>
                                <p class="text-[13.5px] leading-relaxed text-[#4E567A]">Jane Smith</p>
                                <p class="text-[13.5px] leading-relaxed text-[#4E567A]">jane.smith@example.com</p>
                                <p class="text-[13.5px] leading-relaxed text-[#4E567A]">+91 987 654 3210</p>
                            </div>
                        </div>

                        <!-- Terms & Conditions Footer -->
                        <div class="mt-2 flex items-start gap-3 rounded-[12px] bg-[#F4F0FF] p-4 border border-[#E8E3F0]/50">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#5B35D5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <p class="text-[12.5px] leading-relaxed text-[#4E567A]">
                                By proceeding, you agree to our <a href="{{ url('/events') }}" class="font-bold text-[#5B35D5] hover:underline">Terms & Conditions</a> and <a href="{{ url('/events') }}" class="font-bold text-[#5B35D5] hover:underline">Cancellation Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
@endsection
