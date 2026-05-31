<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Booth | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
</head>
<body class="bg-[#F9FAFB] text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen bg-[#F9FAFB] pb-12">
        
        <!-- Horizontal Steps Navigation -->
        <div class="w-full border-b border-gray-100 bg-white sticky top-[80px] z-10 px-8 py-4">
            <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-hide">
                
                <!-- Steps 1-10: Inactive/Completed -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">1</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Profile</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">2</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Branding</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">3</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Products</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">4</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Documents</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">5</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Catalogues</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">6</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Media</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">7</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Team</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">8</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Meetings</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">9</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Sessions</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-[#4B5563] flex items-center justify-center font-bold text-[13px] mr-2">10</div>
                    <span class="text-[#4B5563] font-medium text-[14px] mr-1">Preview</span>
                </div>

                <!-- Step 11: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-[#F5F3FF] flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">11</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Publish</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="w-full max-w-[1400px] mx-auto bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                
                <!-- Title Section -->
                <div class="mb-8">
                    <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Publish Booth</h1>
                    <p class="text-[#6B7280] text-[15px]">Complete all requirements below before publishing your booth.</p>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    
                    <!-- Left Card: Booth Readiness (col-span-5) -->
                    <div class="col-span-12 lg:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col h-full">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Booth Readiness</h3>
                        
                        <div class="flex-1 space-y-4">
                            <!-- Item 1 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Company Profile</h4>
                                        <p class="text-[#6B7280] text-[12px]">Company information is complete.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Booth Branding</h4>
                                        <p class="text-[#6B7280] text-[12px]">Branding settings are applied.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 3 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Add Products</h4>
                                        <p class="text-[#6B7280] text-[12px]">4 products added.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 4 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Upload Documents</h4>
                                        <p class="text-[#6B7280] text-[12px]">6 documents uploaded.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 5 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Upload Catalogues</h4>
                                        <p class="text-[#6B7280] text-[12px]">2 catalogues uploaded.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 6 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Media Gallery</h4>
                                        <p class="text-[#6B7280] text-[12px]">12 media files added.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 7 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Team Members</h4>
                                        <p class="text-[#6B7280] text-[12px]">4 team members added.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 8 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Meetings Availability</h4>
                                        <p class="text-[#6B7280] text-[12px]">Availability is published.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 9 -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Live Demos / Sessions</h4>
                                        <p class="text-[#6B7280] text-[12px]">4 sessions created.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            <!-- Item 10 -->
                            <div class="flex items-center justify-between pb-2">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#10B981] flex items-center justify-center mr-4 flex-shrink-0 shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px]">Preview Booth</h4>
                                        <p class="text-[#6B7280] text-[12px]">Booth preview is ready.</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-[#10B981]">
                                    <span class="font-bold text-[13px] mr-1.5">Completed</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Success Alert -->
                        <div class="bg-[#ECFDF5] border border-[#A7F3D0] rounded-lg p-4 mt-6 flex items-center">
                            <div class="bg-[#10B981] text-white rounded-full w-5 h-5 flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-[#059669] font-bold text-[14px]">Great! Your booth is ready to be published.</span>
                        </div>
                    </div>

                    <!-- Middle Card: Booth Preview (col-span-4) -->
                    <div class="col-span-12 lg:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col h-full">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Booth Preview</h3>
                        
                        <div class="mb-5">
                            <img src="./assets/images/booth_banner.png" alt="Booth Preview" class="w-full h-[220px] object-cover rounded-lg">
                        </div>

                        <h4 class="text-[#1E1B4B] font-bold text-[16px] mb-1">Omnit Wave Technologies</h4>
                        <p class="text-[#6B7280] text-[13px] mb-6">Booth 12A | Hall 1 - Tech & Innovation</p>

                        <div class="flex-1 space-y-0">
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-[#4B5563] text-[13px]">Products</span>
                                <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                    <span class="mr-2">4</span>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-[#4B5563] text-[13px]">Documents</span>
                                <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                    <span class="mr-2">6</span>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-[#4B5563] text-[13px]">Catalogues</span>
                                <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                    <span class="mr-2">2</span>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-[#4B5563] text-[13px]">Media</span>
                                <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                    <span class="mr-2">12</span>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-[#4B5563] text-[13px]">Team Members</span>
                                <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                    <span class="mr-2">4</span>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-[#4B5563] text-[13px]">Sessions</span>
                                <div class="flex items-center text-[#1E1B4B] font-bold text-[13px]">
                                    <span class="mr-2">4</span>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <button class="w-full mt-6 py-2.5 border border-[#4C1D95] text-[#4C1D95] font-bold text-[14px] rounded-lg hover:bg-[#F5F3FF] transition-colors">
                            View Preview
                        </button>
                    </div>

                    <!-- Right Column: Tips & Summary (col-span-3) -->
                    <div class="col-span-12 lg:col-span-3 flex flex-col justify-between h-full">
                        
                        <!-- Publishing Tips -->
                        <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm mb-6">
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Publishing Tips</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="text-[#4C1D95] font-bold mr-2 text-[16px] leading-none mt-0.5">&bull;</span>
                                    <span class="text-[#4B5563] text-[12px] leading-relaxed">Ensure all information is accurate and up to date.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#4C1D95] font-bold mr-2 text-[16px] leading-none mt-0.5">&bull;</span>
                                    <span class="text-[#4B5563] text-[12px] leading-relaxed">High-quality images and videos attract more visitors.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#4C1D95] font-bold mr-2 text-[16px] leading-none mt-0.5">&bull;</span>
                                    <span class="text-[#4B5563] text-[12px] leading-relaxed">Add compelling product descriptions.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#4C1D95] font-bold mr-2 text-[16px] leading-none mt-0.5">&bull;</span>
                                    <span class="text-[#4B5563] text-[12px] leading-relaxed">Configure meetings availability to receive requests.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#4C1D95] font-bold mr-2 text-[16px] leading-none mt-0.5">&bull;</span>
                                    <span class="text-[#4B5563] text-[12px] leading-relaxed">Promote your live sessions for better engagement.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Selected Summary -->
                        <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Selected Summary</h3>
                            
                            <div class="space-y-4 mb-4">
                                <div>
                                    <p class="text-[#6B7280] text-[12px] mb-1">Dates</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#1E1B4B] text-[13px] font-medium">May 11 – May 17, 2024</span>
                                        <span class="text-[#6B7280] text-[12px]">7 Days</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[#6B7280] text-[12px] mb-1">Daily Slots</p>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium">22 Slots</p>
                                </div>
                                <div>
                                    <p class="text-[#6B7280] text-[12px] mb-1">Slot Duration</p>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium">30 Minutes</p>
                                </div>
                                <div>
                                    <p class="text-[#6B7280] text-[12px] mb-1">Total Availability</p>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium">11:00 Hours</p>
                                </div>
                            </div>
                            
                            <p class="text-[#6B7280] text-[11px]">All times in (GMT +05:30) Asia/Kolkata</p>
                        </div>

                        <!-- Publish Button Section -->
                        <div class="mt-6">
                            <a href="dashboard.html" class="w-full bg-[#4C1D95] text-white py-4 rounded-xl font-bold text-[16px] flex items-center justify-center hover:bg-[#3b1774] transition-colors shadow-lg shadow-indigo-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349a5.259 5.259 0 00-1.542-3.717l-2.718-2.718a5.25 5.25 0 00-3.712-1.538H6.75A3.375 3.375 0 003.375 4.5v15m10.5-2.81v-4.02a1.5 1.5 0 011.5-1.5h2.52a1.5 1.5 0 011.5 1.5v4.02"></path></svg>
                                Publish Booth
                            </a>
                            <p class="text-[#6B7280] text-[12px] text-center mt-3">
                                Once published, your booth will be visible to all event visitors.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
