<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booth Branding | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen bg-white pb-12">
        
        <!-- Horizontal Steps Navigation -->
        <div class="w-full border-b border-gray-100 bg-white sticky top-[80px] z-10 px-8 py-4">
            <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-hide">
                
                <!-- Step 1: Completed -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2">
                        <svg class="w-4 h-4 text-[#10B981]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Profile</span>
                </div>
                
                <!-- Step 2: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">2</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Branding</span>
                </div>
                
                <!-- Step 3: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">3</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Products</span>
                </div>
                
                <!-- Step 4: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">4</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Documents</span>
                </div>

                <!-- Step 5: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">5</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Catalogues</span>
                </div>

                <!-- Step 6: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">6</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Media</span>
                </div>

                <!-- Step 7: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">7</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Team</span>
                </div>

                <!-- Step 8: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">8</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Meetings</span>
                </div>

                <!-- Step 9: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">9</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Sessions</span>
                </div>

                <!-- Step 10: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">10</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Preview</span>
                </div>

                <!-- Step 11: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">11</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Publish</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="w-full max-w-[1400px] mx-auto border border-gray-100 rounded-2xl p-8 bg-white shadow-sm relative">
                
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Booth Branding</h1>
                <p class="text-[#6B7280] text-[15px] mb-8">Customize the look and feel of your virtual booth.</p>

                <!-- Main Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <!-- Left Column: Form Inputs -->
                    <div class="lg:col-span-7 space-y-8">
                        
                        <!-- Booth Banner -->
                        <div>
                            <div class="mb-3">
                                <h3 class="text-[#1E1B4B] font-bold text-[15px]">Booth Banner</h3>
                                <p class="text-gray-500 text-[13px]">Recommended size: 1920 x 400 px</p>
                            </div>
                            <div class="flex flex-col md:flex-row items-center gap-4">
                                <div class="w-full md:w-[320px] h-[80px] rounded-lg overflow-hidden border border-gray-200">
                                    <!-- Use a placeholder that mimics the banner in the image -->
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Banner Preview">
                                </div>
                                <button class="px-6 py-2 border border-[#3D1B9B] rounded-lg text-[#3D1B9B] font-medium text-[14px] hover:bg-purple-50 transition-colors whitespace-nowrap">
                                    Change Banner
                                </button>
                            </div>
                        </div>

                        <!-- Colors Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Color Column -->
                            <div>
                                <h3 class="text-[#1E1B4B] font-bold text-[14px] mb-4">Primary Color</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[#1E1B4B] text-[14px] font-semibold">Secondary Color</span>
                                        <div class="flex items-center border border-gray-200 rounded-lg p-1 w-[110px] justify-between bg-white shadow-sm cursor-pointer">
                                            <div class="w-10 h-7 bg-[#4338CA] rounded-md"></div>
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[#1E1B4B] text-[14px] font-semibold">Welcome Color</span>
                                        <div class="flex items-center border border-gray-200 rounded-lg p-1 w-[110px] justify-between bg-white shadow-sm cursor-pointer">
                                            <div class="w-10 h-7 bg-[#0EA5E9] rounded-md"></div>
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Color Column -->
                            <div>
                                <h3 class="text-[#1E1B4B] font-bold text-[14px] mb-4">Text Color</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[#1E1B4B] text-[14px] font-semibold">#4338CA</span>
                                        <div class="flex items-center border border-gray-200 rounded-lg p-1 w-[110px] justify-between bg-white shadow-sm cursor-pointer">
                                            <div class="w-10 h-7 bg-[#4338CA] rounded-md"></div>
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[#1E1B4B] text-[14px] font-semibold">Welcome Heading <span class="text-red-500">*</span></span>
                                        <div class="flex items-center border border-gray-200 rounded-lg p-1 w-[110px] justify-between bg-white shadow-sm cursor-pointer">
                                            <div class="w-10 h-7 bg-[#0EA5E9] rounded-md"></div>
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Welcome Heading Input -->
                        <div>
                            <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Welcome Heading <span class="text-red-500">*</span></label>
                            <input type="text" value="Welcome to Omnit Wave" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>

                        <!-- Theme / Template Select -->
                        <div>
                            <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Theme / Template</label>
                            <div class="relative">
                                <select class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                    <option>Tech Modern</option>
                                    <option>Classic Corporate</option>
                                    <option>Creative Studio</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Booth Background -->
                        <div>
                            <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Booth Background</label>
                            <div class="flex space-x-3 overflow-x-auto pb-2 scrollbar-hide">
                                <!-- Thumb 1 (Active) -->
                                <div class="relative w-20 h-14 rounded-lg overflow-hidden border-2 border-[#3D1B9B] flex-shrink-0 cursor-pointer">
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Thumb">
                                    <div class="absolute bottom-1 right-1 bg-[#3D1B9B] text-white rounded-full w-4 h-4 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                                <!-- Thumb 2 -->
                                <div class="w-20 h-14 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 cursor-pointer hover:border-gray-300">
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Thumb">
                                </div>
                                <!-- Thumb 3 -->
                                <div class="w-20 h-14 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 cursor-pointer hover:border-gray-300">
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Thumb">
                                </div>
                                <!-- Thumb 4 -->
                                <div class="w-20 h-14 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 cursor-pointer hover:border-gray-300">
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Thumb">
                                </div>
                                <!-- Thumb 5 -->
                                <div class="w-20 h-14 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 cursor-pointer hover:border-gray-300">
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Thumb">
                                </div>
                                <!-- Thumb 6 -->
                                <div class="w-20 h-14 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 cursor-pointer hover:border-gray-300">
                                    <img src="./assets/images/booth_banner.png" class="w-full h-full object-cover" alt="Thumb">
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button Text -->
                        <div>
                            <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">CTA Button Text <span class="text-red-500">*</span></label>
                            <input type="text" value="Let's Connect" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>

                        <!-- CTA Button Link -->
                        <div>
                            <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">CTA Button Link</label>
                            <input type="url" value="https://omnitwave.com/connect" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>

                    </div>

                    <!-- Right Column: Live Preview & About Us -->
                    <div class="lg:col-span-5 space-y-6">
                        
                        <!-- Live Preview Card -->
                        <div>
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-3">Live Preview</h3>
                            <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                                
                                <!-- Preview Top Banner -->
                                <div class="bg-gradient-to-br from-[#021035] to-[#122b7a] px-8 py-12 flex flex-col items-center justify-center text-center relative overflow-hidden">
                                    <!-- Subtle background waves/pattern simulation -->
                                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.8) 0%, transparent 50%); background-size: 200% 200%; background-position: center;"></div>
                                    
                                    <p class="text-white text-[11px] font-bold tracking-[0.2em] mb-4 relative z-10">OMNIT WAVE</p>
                                    <h2 class="text-white text-[24px] font-bold mb-2 relative z-10">Welcome to Omnit Wave</h2>
                                    <p class="text-blue-100 text-[13px] mb-6 relative z-10">Intelligent Solutions, Limitless Possibilities.</p>
                                    <button class="bg-[#5622D6] text-white px-6 py-2 rounded-lg font-semibold text-[14px] hover:bg-[#4319a8] transition-colors relative z-10">
                                        Let's Connect
                                    </button>
                                </div>

                                <!-- Preview Bottom Stats -->
                                <div class="bg-white px-6 py-8">
                                    <div class="grid grid-cols-3 gap-4 text-center">
                                        <!-- Products -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full border border-purple-100 bg-purple-50 flex items-center justify-center mb-2">
                                                <svg class="w-5 h-5 text-[#3D1B9B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                            <p class="text-[#1E1B4B] font-bold text-[13px] mb-1">Products</p>
                                            <p class="text-[#1E1B4B] font-extrabold text-[15px]">8</p>
                                        </div>
                                        <!-- Documents -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full border border-purple-100 bg-purple-50 flex items-center justify-center mb-2">
                                                <svg class="w-5 h-5 text-[#3D1B9B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <p class="text-[#1E1B4B] font-bold text-[13px] mb-1">Documents</p>
                                            <p class="text-[#1E1B4B] font-extrabold text-[15px]">6</p>
                                        </div>
                                        <!-- Team -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full border border-purple-100 bg-purple-50 flex items-center justify-center mb-2">
                                                <svg class="w-5 h-5 text-[#3D1B9B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            </div>
                                            <p class="text-[#1E1B4B] font-bold text-[13px] mb-1">Team</p>
                                            <p class="text-[#1E1B4B] font-extrabold text-[15px]">5</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- About Us Section -->
                        <div class="border border-gray-100 rounded-2xl p-6 bg-white shadow-sm mt-6">
                            <h3 class="text-[#1E1B4B] font-bold text-[16px] mb-3">About Us</h3>
                            <p class="text-[#6B7280] text-[14px] leading-relaxed mb-6">
                                Omnit Wave Technologies delivers AI-powered solutions that help businesses automate, analyze and accelerate growth with intelligent platforms and real-time insights.
                            </p>
                            
                            <!-- Social Icons Minimal -->
                            <div class="flex items-center space-x-4">
                                <a href="#" class="w-8 h-8 bg-[#0077B5] rounded flex items-center justify-center hover:opacity-90 transition-opacity">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-8 h-8 bg-[#3b5998] rounded flex items-center justify-center hover:opacity-90 transition-opacity">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-8 h-8 bg-[#1DA1F2] rounded flex items-center justify-center hover:opacity-90 transition-opacity">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-8 h-8 bg-[#FF0000] rounded flex items-center justify-center hover:opacity-90 transition-opacity">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Bottom Action Buttons -->
                <div class="flex flex-col md:flex-row justify-between items-center mt-10 border-t border-gray-100 pt-8">
                    <button class="px-8 py-3 border border-gray-200 rounded-lg text-[#3D1B9B] font-bold text-[14px] hover:bg-gray-50 transition-colors mb-4 md:mb-0">
                        Reset to Default
                    </button>
                    <!-- Navigates to Add Products and marks step 2 complete -->
                    <a href="add-products.html" onclick="if(window.markStepCompleted) window.markStepCompleted(2);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
