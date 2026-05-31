<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit for Review - eproexpo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#5B32F6',
                            light: '#F4F1FF',
                        },
                        textMain: '#1C1364',
                        textMuted: '#6B7280',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-textMain font-sans flex min-h-screen">
    <div id="sidebar-container" class="z-50 relative"></div>
    
    <main class="ml-[280px] flex-1 bg-white min-h-screen flex flex-col">
        <!-- Top Nav -->
        <header class="bg-white flex justify-between items-center px-10 py-6 border-b border-gray-100 shrink-0">
            <div class="flex gap-8">
                <a href="#" class="text-[13px] font-medium text-textMain">Explore Events</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Exhibitions</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Products</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Jobs</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Resources</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Pricing</a>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-1 text-[13px] font-medium cursor-pointer">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    EN
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="w-px h-6 bg-gray-200"></div>
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/150?img=11" alt="John Doe" class="w-9 h-9 rounded-full object-cover">
                    <div>
                        <h4 class="text-[13px] font-bold">John Doe</h4>
                        <p class="text-[11px] text-textMuted font-medium">Organizer</p>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>
        </header>

        <div class="px-10 py-10 max-w-[1250px] w-full flex mx-auto flex-1 gap-14">
            
            <!-- Left Column -->
            <div class="flex-1 flex flex-col gap-10">
                
                <!-- Setup Checklist -->
                <div>
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-5">Setup Checklist</h3>
                    <div class="border border-gray-100 rounded-[12px] bg-white flex flex-col shadow-[0_2px_8px_rgba(0,0,0,0.01)] overflow-hidden">
                        
                        <!-- Checklist Items -->
                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Basic Details</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Branding</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Tickets / Passes</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Speakers</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Sessions / Agenda</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Sponsors</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 px-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Resources</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 px-5 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                <span class="text-[14px] font-bold text-[#1C1364]">Meetings & Networking</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-bold text-[#10B981]">Completed</span>
                                <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Notes -->
                <div>
                    <h3 class="text-[15px] font-bold text-[#1C1364] mb-1">Review Notes</h3>
                    <p class="text-[13px] text-[#5B6B8A] mb-3">Add any additional information for the review team.</p>
                    <div class="relative">
                        <textarea class="w-full h-[120px] p-5 bg-white border border-gray-200 rounded-[12px] text-[13px] font-medium text-[#1C1364] focus:outline-none focus:border-[#4C10D0] resize-none shadow-[0_2px_8px_rgba(0,0,0,0.01)]" placeholder="Enter notes...">Our event is ready for review. Please let us know if any additional information is required.</textarea>
                        <span class="absolute bottom-4 right-4 text-[12px] font-medium text-[#5B6B8A]">215/500</span>
                    </div>
                </div>

                <!-- Documents -->
                <div>
                    <h3 class="text-[15px] font-bold text-[#1C1364] mb-1">Documents (Optional)</h3>
                    <p class="text-[13px] text-[#5B6B8A] mb-3">Upload supporting documents if needed.</p>
                    
                    <div class="flex flex-col gap-3 mb-4">
                        <div class="flex items-center justify-between p-3.5 border border-gray-100 rounded-[8px] bg-white shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="text-red-500 shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span class="text-[13px] font-medium text-[#1C1364]">Event_Brochure.pdf</span>
                            </div>
                            <div class="flex items-center gap-10">
                                <span class="text-[13px] font-medium text-[#5B6B8A]">2.4 MB</span>
                                <button class="text-red-500 hover:text-red-600 transition-colors">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3.5 border border-gray-100 rounded-[8px] bg-white shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="text-red-500 shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span class="text-[13px] font-medium text-[#1C1364]">Sponsorship_Guide.pdf</span>
                            </div>
                            <div class="flex items-center gap-10">
                                <span class="text-[13px] font-medium text-[#5B6B8A]">1.8 MB</span>
                                <button class="text-red-500 hover:text-red-600 transition-colors">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button class="w-full py-3.5 border border-dashed border-[#C4B5FD] rounded-[8px] bg-[#F4F1FF]/30 text-[#4C10D0] text-[13px] font-bold flex items-center justify-center gap-2 hover:bg-[#F4F1FF] transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Add more files
                    </button>
                </div>
            </div>

            <!-- Right Column -->
            <div class="w-[440px] flex flex-col gap-10">
                
                <!-- Review Summary -->
                <div>
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-5">Review Summary</h3>
                    <div class="border border-gray-100 rounded-[12px] bg-white flex flex-col shadow-[0_2px_10px_rgba(0,0,0,0.01)] overflow-hidden">
                        
                        <!-- Row 1 -->
                        <div class="p-6 flex items-center gap-6 border-b border-gray-50">
                            <div class="w-[52px] h-[52px] rounded-[12px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><polyline points="9 14 11 16 15 11"></polyline></svg>
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-[16px] font-bold text-[#1C1364] mb-0.5">8/8</span>
                                <span class="text-[13px] font-medium text-[#5B6B8A]">Completed Sections</span>
                            </div>
                            <div class="text-[12px] font-medium text-[#5B6B8A] w-[140px] leading-tight">
                                All required sections are completed
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="p-6 flex items-center gap-6 border-b border-gray-50">
                            <div class="w-[52px] h-[52px] rounded-[12px] bg-[#F4F1FF] text-[#4C10D0] flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-[16px] font-bold text-[#1C1364] mb-0.5">1,506</span>
                                <span class="text-[13px] font-medium text-[#5B6B8A]">Expected Attendees</span>
                            </div>
                            <div class="text-[12px] font-medium text-[#5B6B8A] w-[140px] leading-tight">
                                Based on ticket sales configuration
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="p-6 flex items-center gap-6">
                            <div class="w-[52px] h-[52px] rounded-[12px] bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-[16px] font-bold text-[#1C1364] mb-0.5">May 15 - 17, 2024</span>
                                <span class="text-[13px] font-medium text-[#5B6B8A]">Event Dates</span>
                            </div>
                            <div class="text-[12px] font-medium text-[#5B6B8A] w-[140px] leading-tight">
                                3 Days Event
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overall Progress -->
                <div>
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-4">Overall Progress</h3>
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex-1 h-3.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#4C10D0] w-full rounded-full"></div>
                        </div>
                        <span class="text-[15px] font-bold text-[#1C1364]">100%</span>
                    </div>

                    <!-- Alert Box -->
                    <div class="bg-[#F0FDF4] border border-[#DCFCE7] rounded-[12px] p-6 flex gap-4">
                        <div class="text-[#10B981] shrink-0 mt-0.5">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <span class="text-[14px] font-bold text-[#10B981]">Your event is ready for review!</span>
                            <span class="text-[13px] font-medium text-[#5B6B8A] leading-relaxed">Once submitted, our review team will verify your event details. You will be notified via email.</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Buttons -->
                <div class="flex flex-col gap-4 mt-auto">
                    <button class="w-full bg-[#4C10D0] text-white py-4 rounded-lg text-[14px] font-bold hover:bg-[#3d0ba8] transition-colors shadow-[0_4px_14px_rgba(76,16,208,0.3)]">
                        Submit for Review
                    </button>
                    <a href="event-preview.html" class="w-[120px] py-3 border border-gray-200 text-[#1C1364] bg-white rounded-lg text-[14px] font-bold hover:bg-gray-50 transition-colors shadow-sm self-start text-center inline-block">
                        Back
                    </a>
                </div>
                
            </div>
        </div>
    </main>

    <script src="sidebar.js"></script>
    <script src="app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Set 'Events' as active
            setTimeout(() => {
                const navItems = document.querySelectorAll('#sidebar-container a');
                navItems.forEach(n => {
                    // Reset all
                    n.classList.remove('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                    n.classList.add('text-[#1C1364]', 'font-medium');
                    const svg = n.querySelector('svg');
                    if(svg) svg.classList.replace('text-[#5B32F6]', 'text-[#1C1364]');
                    
                    // Activate Events
                    if(n.textContent.trim() === 'Events') {
                        n.classList.remove('text-[#1C1364]', 'font-medium');
                        n.classList.add('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                        if(svg) svg.classList.replace('text-[#1C1364]', 'text-[#5B32F6]');
                    }
                });
            }, 100);
        });
    </script>
</body>
</html>
