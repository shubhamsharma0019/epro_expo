<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Registration Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#F4F0FF', 100: '#E0D4FC', 500: '#5A32FA', 600: '#4A22E0', 700: '#3D1CBA' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FFFFFF; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Confetti Animation Elements */
        .confetti {
            position: absolute;
            border-radius: 50%;
        }
        .confetti-square {
            position: absolute;
            transform: rotate(45deg);
        }
        .confetti-triangle {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 10px solid currentColor;
            transform: rotate(30deg);
        }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="exhibition-details.html" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Content Area -->
            <div class="flex gap-8">
                
                <!-- Left: Main Success Area -->
                <div class="flex-1 flex flex-col pb-10">
                    
                    <!-- Success Header -->
                    <div class="flex flex-col items-center text-center mb-8 relative pt-4">
                        
                        <!-- Decorative Confetti -->
                        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                            <div class="confetti w-2 h-2 bg-blue-500 top-10 left-[20%]"></div>
                            <div class="confetti w-3 h-3 bg-green-400 top-[60%] left-[15%]"></div>
                            <div class="confetti-square w-2.5 h-2.5 bg-yellow-400 top-4 left-[35%]"></div>
                            <div class="confetti-triangle text-purple-500 top-16 left-[28%]"></div>
                            
                            <div class="confetti w-2 h-2 bg-red-400 top-8 right-[25%]"></div>
                            <div class="confetti w-3 h-3 bg-blue-400 top-[60%] right-[15%]"></div>
                            <div class="confetti-square w-2.5 h-2.5 bg-green-500 top-20 right-[35%]"></div>
                            <div class="confetti-triangle text-yellow-500 top-12 right-[10%]"></div>
                        </div>

                        <!-- Checkmark Icon -->
                        <div class="w-16 h-16 rounded-full bg-[#16A34A] flex items-center justify-center text-white text-[32px] mb-6 relative z-10 shadow-[0_8px_20px_rgba(22,163,74,0.3)]">
                            <i class="ph-bold ph-check"></i>
                        </div>
                        
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-3 relative z-10">Registration Successful!</h1>
                        <p class="text-[#475569] text-[16px] font-medium mb-2 relative z-10">Thank you for registering for</p>
                        <h2 class="text-[26px] font-bold text-primary-600 mb-6 relative z-10 tracking-tight">Global Tech Summit 2024</h2>
                        <p class="text-[#475569] text-[15px] font-medium relative z-10">Your booking is confirmed.</p>
                    </div>

                    <!-- Booking ID Box -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-8 max-w-lg w-full mx-auto text-center mb-10 shadow-sm">
                        <div class="text-[#64748B] text-[14px] font-semibold mb-2">Booking ID</div>
                        <div class="text-[24px] font-bold text-[#1E1B4B] mb-5 tracking-wide">GTS-240515-000123</div>
                        <div class="text-[14px] text-[#475569]">
                            A confirmation email has been sent to<br>
                            <span class="font-bold text-[#1E293B]">john.doe@email.com</span>
                        </div>
                    </div>

                    <!-- What's Next Section -->
                    <div class="mb-10">
                        <h3 class="text-center text-[#475569] text-[14px] font-semibold mb-6">What's Next?</h3>
                        
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Card 1 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 mb-4 border border-green-100">
                                    <i class="ph ph-envelope text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Check Your Email</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Your e-ticket and event details have been sent.</p>
                            </div>
                            
                            <!-- Card 2 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 mb-4 border border-primary-100">
                                    <i class="ph ph-ticket text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">View E-Ticket</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Access your e-ticket and QR code.</p>
                            </div>
                            
                            <!-- Card 3 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-4 border border-blue-100">
                                    <i class="ph ph-calendar-plus text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Add to Calendar</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Save the event dates to your calendar.</p>
                            </div>
                            
                            <!-- Card 4 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 mb-4 border border-orange-100">
                                    <i class="ph ph-map-pin text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Plan Your Visit</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Explore agenda, speakers and venue details.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-center gap-4 mb-12">
                        <a href="e-ticket.html" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] flex items-center gap-2">
                            <i class="ph ph-ticket"></i> View E-Ticket
                        </a>
                        <button class="border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 px-8 py-3 rounded-xl font-bold transition-all text-[15px] flex items-center gap-2 shadow-sm">
                            <i class="ph ph-export"></i> Share Registration
                        </button>
                    </div>

                    <!-- Need Help Banner -->
                    <div class="border border-green-200 rounded-2xl bg-[#F0FDF4] p-5 flex items-center justify-between mt-auto shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#16A34A] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="ph-fill ph-shield-check text-[20px]"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[#14532D] text-[15px] mb-1">Need help?</div>
                                <div class="text-[13px] text-[#166534] font-medium">If you have any questions, contact our support team.</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 pr-2">
                            <a href="mailto:support@eproexpo.com" class="flex items-center gap-2 text-primary-600 font-bold text-[13px] hover:underline">
                                <i class="ph ph-envelope-simple text-[18px]"></i> support@eproexpo.com
                            </a>
                            <div class="w-px h-5 bg-green-200"></div>
                            <a href="tel:+919876543210" class="flex items-center gap-2 text-primary-600 font-bold text-[13px] hover:underline">
                                <i class="ph ph-phone text-[18px]"></i> +91 98765 43210
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Right: Ticket & Summary Sidebar -->
                <div class="w-[340px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Your E-Ticket -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col items-center">
                        <div class="w-full text-left mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Your E-Ticket</h3>
                            <p class="text-[12px] text-gray-500 font-medium">Show this QR code at the venue entry.</p>
                        </div>
                        
                        <!-- Event Banner embedded in ticket -->
                        <div class="w-full rounded-xl bg-indigo-900 text-white p-4 mb-6 relative overflow-hidden shadow-md">
                            <!-- Abstract background lines for event card -->
                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/diagonal-stripes.png')] mix-blend-overlay"></div>
                            <div class="relative z-10">
                                <h4 class="font-bold text-[14px] mb-2 tracking-wide uppercase">GLOBAL TECH SUMMIT 2024</h4>
                                <p class="text-[11px] text-indigo-100 mb-1 font-medium">May 15 – May 17, 2024</p>
                                <p class="text-[11px] text-indigo-200 leading-tight">Jio World Convention Centre,<br>Mumbai, India</p>
                            </div>
                        </div>

                        <!-- QR Code -->
                        <div class="w-36 h-36 bg-white border border-gray-200 rounded-xl p-2 mb-3 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=GTS-240515-000123" alt="QR Code" class="w-full h-full object-contain">
                        </div>
                        <p class="text-[#475569] text-[13px] font-semibold">Scan at entry point</p>
                    </div>

                    <!-- Booking Details Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Booking Details</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Booking ID</span>
                                <span class="font-bold text-[#1E293B]">GTS-240515-000123</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Event</span>
                                <span class="font-medium text-[#1E293B] text-right">Global Tech Summit 2024</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Date</span>
                                <span class="font-medium text-[#1E293B] text-right">May 15 – May 17, 2024</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Venue</span>
                                <span class="font-medium text-[#1E293B] text-right w-[150px] leading-relaxed">Jio World Convention Centre, Mumbai, India</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px] pt-4 border-t border-gray-100">
                                <span class="text-gray-500 font-medium">Ticket Type</span>
                                <span class="font-bold text-[#1E293B]">Free Visitor Pass</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Ticket Count</span>
                                <span class="font-bold text-[#1E293B]">1</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <script src="../assets/js/script.js"></script>
</body>
</html>
