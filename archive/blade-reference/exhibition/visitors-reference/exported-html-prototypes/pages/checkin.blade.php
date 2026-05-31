<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Check-In</title>
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
        body { background-color: #FAFAFA; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .scan-frame {
            position: relative;
            width: 80px;
            height: 80px;
        }
        .scan-frame::before, .scan-frame::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: #4A22E0;
            border-style: solid;
        }
        .scan-frame::before {
            top: 0; left: 0;
            border-width: 4px 0 0 4px;
            border-radius: 8px 0 0 0;
        }
        .scan-frame::after {
            bottom: 0; right: 0;
            border-width: 0 4px 4px 0;
            border-radius: 0 0 8px 0;
        }
        .scan-frame-inner::before, .scan-frame-inner::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: #4A22E0;
            border-style: solid;
        }
        .scan-frame-inner::before {
            top: 0; right: 0;
            border-width: 4px 4px 0 0;
            border-radius: 0 8px 0 0;
        }
        .scan-frame-inner::after {
            bottom: 0; left: 0;
            border-width: 0 0 4px 4px;
            border-radius: 0 0 0 8px;
        }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FAFAFA]">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            <div class="flex gap-8 max-w-[1400px] mx-auto">
                
                <!-- Left: Check-In Area -->
                <div class="flex-1 flex flex-col min-w-[600px]">
                    
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-[20px] font-bold text-[#1E1B4B] mb-1">Event Entry / Check-In</h1>
                            <p class="text-[13px] text-gray-500 font-medium">Scan the QR code on the attendee's e-ticket or enter the Booking ID to check-in.</p>
                        </div>
                        <button class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-5 py-2.5 rounded-xl font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                            <i class="ph ph-user-plus text-[16px]"></i> Manual Check-In
                        </button>
                    </div>

                    <!-- Scanner Box -->
                    <div class="border border-gray-200 rounded-2xl bg-white p-6 shadow-sm mb-6 relative">
                        <!-- Tabs -->
                        <div class="flex items-center gap-8 border-b border-gray-100 mb-6">
                            <div class="pb-3 border-b-2 border-primary-600 font-bold text-primary-600 text-[13px] cursor-pointer">Scan QR Code</div>
                            <div class="pb-3 text-gray-500 font-medium text-[13px] hover:text-gray-700 cursor-pointer transition-colors">Enter Booking ID</div>
                        </div>

                        <!-- Scan Area -->
                        <div class="bg-primary-50/50 rounded-xl border border-primary-100 p-10 flex flex-col items-center justify-center min-h-[260px]">
                            <div class="scan-frame mb-6">
                                <div class="scan-frame-inner absolute inset-0"></div>
                            </div>
                            <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-2">Scan Attendee QR Code</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Position the QR code within the frame to scan</p>
                        </div>

                        <!-- OR Divider -->
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 bg-white px-3 text-[11px] font-bold text-gray-400 border border-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-sm z-10">OR</div>
                    </div>

                    <!-- Success State Box -->
                    <div class="border border-green-200 rounded-2xl bg-white shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden mt-8">
                        
                        <!-- Green Top Banner -->
                        <div class="bg-green-50 px-6 py-3 border-b border-green-100 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-green-700 font-bold text-[14px]">
                                <i class="ph-fill ph-check-circle text-[20px]"></i> Check-In Successful
                            </div>
                            <div class="text-green-700 text-[12px] font-medium">
                                Checked In At: <span class="font-bold">May 15, 2024 | 09:05 AM</span>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="p-6 flex items-start gap-8">
                            
                            <!-- Avatar & Name -->
                            <div class="flex items-center gap-4 border-r border-gray-100 pr-8 min-w-[280px]">
                                <div class="relative">
                                    <img src="https://i.pravatar.cc/150?u=a042581f4e29026024d" alt="John Doe" class="w-[70px] h-[70px] rounded-full object-cover border-2 border-white shadow-md">
                                    <div class="absolute bottom-0 right-0 bg-[#16A34A] text-white w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                        <i class="ph-bold ph-check text-[12px]"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="font-bold text-[#1E1B4B] text-[20px] mb-1">John Doe</h2>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">john.doe@email.com</div>
                                    <div class="text-[13px] text-gray-500 font-medium">+91 98765 43210</div>
                                </div>
                            </div>

                            <!-- Detail Grid -->
                            <div class="flex-1 grid grid-cols-2 gap-y-5 gap-x-4 pt-1">
                                <div>
                                    <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Booking ID</div>
                                    <div class="text-[14px] font-bold text-[#1E293B]">GTS-240515-000123</div>
                                </div>
                                <div>
                                    <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Organization</div>
                                    <div class="text-[14px] font-bold text-[#1E293B]">Tech Solutions Pvt. Ltd.</div>
                                </div>
                                <div>
                                    <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Ticket Type</div>
                                    <div class="text-[14px] font-bold text-[#1E293B]">Free Visitor Pass</div>
                                </div>
                                <div>
                                    <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Check-In Location</div>
                                    <div class="text-[14px] font-bold text-[#1E293B]">Main Entrance</div>
                                </div>
                            </div>

                            <!-- Right Status Box -->
                            <div class="w-[160px] h-[140px] bg-[#F0FDF4] border border-green-100 rounded-xl flex flex-col items-center justify-center shrink-0">
                                <div class="w-12 h-12 rounded-full bg-[#16A34A] text-white flex items-center justify-center mb-3 shadow-md">
                                    <i class="ph-bold ph-check text-[24px]"></i>
                                </div>
                                <div class="font-bold text-[#16A34A] text-[15px] mb-1">Entry Granted</div>
                                <div class="text-[12px] text-green-700 font-medium">Enjoy the Event!</div>
                            </div>
                        </div>

                        <!-- Bottom Actions -->
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                            <div class="flex-1 max-w-sm mr-4">
                                <div class="text-[11px] text-gray-500 font-semibold mb-1">Notes</div>
                                <input type="text" placeholder="Add a note (optional)" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-[13px] outline-none focus:border-primary-500 bg-white shadow-sm">
                            </div>
                            <div class="flex items-center gap-3 mt-4">
                                <button class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-4 py-2.5 rounded-xl font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                                    <i class="ph ph-printer text-[18px]"></i> Print Badge
                                </button>
                                <button class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[13px] flex items-center gap-2">
                                    <i class="ph ph-corners-out text-[18px]"></i> New Check-In
                                </button>
                                <button onclick="window.location.href='lobby.html'" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(22,163,74,0.25)] transition-all text-[13px] flex items-center gap-2">
                                    Enter Lobby <i class="ph ph-arrow-right text-[18px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right: Sidebars (Stats) -->
                <div class="w-[360px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Event Details Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Event Details</h3>
                        <div class="flex gap-4">
                            <div class="w-[80px] h-[80px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                            <div class="flex flex-col pt-1">
                                <div class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-tight">Global Tech Summit 2024</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] mb-1.5 font-medium">
                                    <i class="ph ph-calendar-blank text-[14px]"></i>
                                    <span>May 15 – May 17, 2024</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] mb-1.5 font-medium">
                                    <i class="ph ph-clock text-[14px]"></i>
                                    <span>09:00 AM – 06:00 PM (IST)</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-snug mt-1">
                                    <i class="ph ph-map-pin text-[14px] mt-0.5"></i>
                                    <span>Jio World Convention Centre, Mumbai, India</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Summary Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Today's Check-In Summary</h3>
                            <span class="text-[12px] text-gray-500 font-medium">May 15, 2024</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <!-- Total Registered -->
                            <div class="border border-gray-100 rounded-xl p-4 bg-[#FAFAFA] flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-primary-500 flex items-center justify-center shrink-0">
                                    <i class="ph-fill ph-users text-[20px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E1B4B] text-[18px] leading-none mb-1">256</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Total Registered</div>
                                </div>
                            </div>
                            <!-- Checked In -->
                            <div class="border border-gray-100 rounded-xl p-4 bg-white flex items-center gap-3 shadow-sm border-l-4 border-l-green-500 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                                    <i class="ph-bold ph-check-circle text-[20px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E1B4B] text-[18px] leading-none mb-1">198</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Checked In</div>
                                </div>
                            </div>
                            <!-- Pending -->
                            <div class="border border-gray-100 rounded-xl p-4 bg-[#FAFAFA] flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                                    <i class="ph-bold ph-clock text-[20px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E1B4B] text-[18px] leading-none mb-1">58</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Pending</div>
                                </div>
                            </div>
                            <!-- Rejected -->
                            <div class="border border-gray-100 rounded-xl p-4 bg-[#FAFAFA] flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                    <i class="ph-fill ph-x-circle text-[20px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E1B4B] text-[18px] leading-none mb-1">0</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Rejected</div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div>
                            <div class="flex items-center justify-between text-[12px] font-bold mb-2">
                                <span class="text-[#1E1B4B]">Check-In Rate</span>
                                <span class="text-[#1E1B4B]">77.34%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-primary-600 h-2 rounded-full" style="width: 77.34%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Check-Ins -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Recent Check-Ins</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline">View All</a>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- User 1 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/150?u=jane" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">Jane Smith</div>
                                        <div class="text-[11px] text-gray-500 font-medium">GTS-240515-000122</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] text-gray-500 font-medium">09:04 AM</span>
                                    <i class="ph-fill ph-check-circle text-green-500 text-[16px]"></i>
                                </div>
                            </div>
                            <!-- User 2 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/150?u=michael" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">Michael Brown</div>
                                        <div class="text-[11px] text-gray-500 font-medium">GTS-240515-000121</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] text-gray-500 font-medium">09:03 AM</span>
                                    <i class="ph-fill ph-check-circle text-green-500 text-[16px]"></i>
                                </div>
                            </div>
                            <!-- User 3 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/150?u=emily" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">Emily Johnson</div>
                                        <div class="text-[11px] text-gray-500 font-medium">GTS-240515-000120</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] text-gray-500 font-medium">09:02 AM</span>
                                    <i class="ph-fill ph-check-circle text-green-500 text-[16px]"></i>
                                </div>
                            </div>
                            <!-- User 4 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/150?u=daniel" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">Daniel Wilson</div>
                                        <div class="text-[11px] text-gray-500 font-medium">GTS-240515-000119</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] text-gray-500 font-medium">09:01 AM</span>
                                    <i class="ph-fill ph-check-circle text-green-500 text-[16px]"></i>
                                </div>
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
