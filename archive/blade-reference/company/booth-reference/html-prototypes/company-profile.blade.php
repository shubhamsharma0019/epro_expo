<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen bg-white">
        
        <!-- Horizontal Steps Navigation -->
        <div class="w-full border-b border-gray-100 bg-white sticky top-[80px] z-10 px-8 py-4">
            <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-hide">
                
                <!-- Step 1: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">1</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Profile</span>
                </div>
                
                <!-- Step 2: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#F3F4F6] text-[#6B7280] flex items-center justify-center font-bold text-[13px] mr-2">2</div>
                    <span class="text-[#6B7280] font-semibold text-[14px] mr-1">Branding</span>
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
            <div class="w-full max-w-[1400px] mx-auto border border-gray-200 rounded-2xl p-8 bg-white shadow-sm relative">
                
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Company Profile</h1>
                <p class="text-[#6B7280] text-[15px] mb-8">Add your company information to help attendees know you better.</p>

                <!-- Form Grid -->
                <div class="grid grid-cols-12 gap-x-6 gap-y-6">
                    
                    <!-- Logo Upload Area (Spans 4 columns, 3 rows tall) -->
                    <div class="col-span-12 md:col-span-4 row-span-3">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Company Logo</label>
                        <div class="border-2 border-dashed border-[#8B5CF6] rounded-xl p-6 h-[220px] flex flex-col items-center justify-center bg-white cursor-pointer hover:bg-purple-50 transition-colors">
                            <div class="mb-4">
                                <!-- Using a placeholder for OMNIT WAVE logo -->
                                <img src="./assets/images/booth_banner.png" alt="Omnit Wave Logo" class="h-12 object-contain grayscale-0 opacity-80" style="mix-blend-mode: multiply;">
                            </div>
                            <p class="text-center text-[#3D1B9B] text-[13px] font-medium leading-relaxed px-4">
                                Click to upload or drag and drop<br>PNG, JPG or SVG (Max. 5MB)
                            </p>
                        </div>
                    </div>

                    <!-- Row 1 right side -->
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Company Name <span class="text-red-500">*</span></label>
                        <input type="text" value="Omnit Wave Technologies" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Contact Person <span class="text-red-500">*</span></label>
                        <input type="text" value="John Doe" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 2 right side -->
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Industry <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                <option>Artificial Intelligence</option>
                                <option>Software Development</option>
                                <option>Cloud Computing</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" value="john.doe@omnitwave.com" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 3 right side -->
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Tagline</label>
                        <input type="text" value="Intelligent Solutions, Limitless Possibilities." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Phone <span class="text-red-500">*</span></label>
                        <input type="tel" value="+1 555 123 4567" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 4 -->
                    <div class="col-span-12 md:col-span-8">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">About Company <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <textarea rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] resize-none pb-8">Omnit Wave Technologies delivers AI-powered solutions that help businesses automate, analyze and accelerate growth with intelligent platforms and real-time insights.</textarea>
                            <span class="absolute bottom-3 right-4 text-[12px] text-gray-400 font-medium">143/300</span>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Website</label>
                        <input type="url" value="https://www.omnitwave.com" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 5 -->
                    <div class="col-span-12 md:col-span-5">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Address <span class="text-red-500">*</span></label>
                        <input type="text" value="123 Innovation Drive, Suite 500" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" value="San Francisco" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">State <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                <option>California</option>
                                <option>New York</option>
                                <option>Texas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Zip Code <span class="text-red-500">*</span></label>
                        <input type="text" value="94107" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 6 -->
                    <div class="col-span-12 md:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Country <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                <option>United States</option>
                                <option>Canada</option>
                                <option>United Kingdom</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links Section -->
                <div class="mt-8 border border-gray-100 rounded-xl p-6 bg-[#FAFAFA]">
                    <h2 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Social Links</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                        
                        <!-- LinkedIn -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#0077B5] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </div>
                            <input type="url" value="https://linkedin.com/company/omnitwave" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                        <!-- Facebook -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#1877F2] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                                </svg>
                            </div>
                            <input type="url" value="https://facebook.com/omnitwave" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                        <!-- Twitter / X -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#1DA1F2] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </div>
                            <input type="url" value="https://twitter.com/omnitwave" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                        <!-- YouTube -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#FF0000] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                </svg>
                            </div>
                            <input type="url" value="https://youtube.com/@omnitwave" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                    </div>
                </div>

                <!-- Save & Continue Button -->
                <div class="flex justify-end mt-8">
                    <!-- Added onclick to mark step 1 as completed -->
                    <a href="booth-branding.html" onclick="if(window.markStepCompleted) window.markStepCompleted(1);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
