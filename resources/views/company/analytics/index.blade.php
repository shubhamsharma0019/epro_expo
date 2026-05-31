@extends('layouts.company')

@section('title', 'Booth Analytics | eproexpo')
@section('page-title', 'Booth Analytics')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
<div class="w-full max-w-[1400px] mx-auto">
            
            <!-- Header Section -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Booth Analytics</h1>
                    <p class="text-[#6B7280] text-[15px]">Track performance and engagement for your booth.</p>
                </div>
                <div class="flex space-x-3">
                    <!-- Date Picker -->
                    <div class="flex items-center border border-gray-200 bg-white rounded-lg px-4 py-2.5 shadow-sm cursor-pointer hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-[#4B5563] text-[14px] font-medium mr-2">May 11 – May 17, 2024</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <!-- Export Button -->
                    <button class="flex items-center border border-[#3D1B9B] text-[#3D1B9B] bg-white rounded-lg px-4 py-2.5 font-bold text-[14px] shadow-sm hover:bg-[#F5F3FF] transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                
                <!-- Card 1 -->
                <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Booth Views</p>
                            <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">1,248</h3>
                            <p class="text-[#6B7280] text-[12px]">vs May 4 – May 10</p>
                        </div>
                    </div>
                    <div class="flex items-center text-[#10B981] font-bold text-[13px] mt-6">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path></svg>
                        18.5%
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Product Views</p>
                            <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">962</h3>
                            <p class="text-[#6B7280] text-[12px]">vs May 4 – May 10</p>
                        </div>
                    </div>
                    <div class="flex items-center text-[#10B981] font-bold text-[13px] mt-6">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path></svg>
                        21.7%
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Brochure Downloads</p>
                            <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">356</h3>
                            <p class="text-[#6B7280] text-[12px]">vs May 4 – May 10</p>
                        </div>
                    </div>
                    <div class="flex items-center text-[#10B981] font-bold text-[13px] mt-6">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path></svg>
                        15.7%
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Meeting Requests</p>
                            <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">64</h3>
                            <p class="text-[#6B7280] text-[12px]">vs May 4 – May 10</p>
                        </div>
                    </div>
                    <div class="flex items-center text-[#10B981] font-bold text-[13px] mt-6">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path></svg>
                        38.0%
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Enquiries</p>
                            <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">93</h3>
                            <p class="text-[#6B7280] text-[12px]">vs May 4 – May 10</p>
                        </div>
                    </div>
                    <div class="flex items-center text-[#10B981] font-bold text-[13px] mt-6">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path></svg>
                        22.4%
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Session Attendees</p>
                            <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">219</h3>
                            <p class="text-[#6B7280] text-[12px]">vs May 4 – May 10</p>
                        </div>
                    </div>
                    <div class="flex items-center text-[#10B981] font-bold text-[13px] mt-6">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"></path></svg>
                        31.2%
                    </div>
                </div>

            </div>

            <!-- Middle Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
                
                <!-- Traffic Trend -->
                <div class="col-span-12 lg:col-span-7 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-[#1E1B4B] font-bold text-[15px]">Traffic Trend</h3>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-[#4C1D95] mr-2"></span>
                                <span class="text-[#6B7280] text-[12px] font-medium">Booth Views</span>
                            </div>
                        </div>

                        <!-- Chart Container -->
                        <div class="w-full h-[240px] relative">
                            <!-- Y-axis labels and grid lines -->
                            <div class="absolute inset-0 flex flex-col justify-between pb-8">
                                <div class="flex items-center w-full">
                                    <span class="text-[#9CA3AF] text-[11px] w-8 text-right mr-4 font-medium">400</span>
                                    <div class="flex-1 border-b border-gray-100"></div>
                                </div>
                                <div class="flex items-center w-full">
                                    <span class="text-[#9CA3AF] text-[11px] w-8 text-right mr-4 font-medium">300</span>
                                    <div class="flex-1 border-b border-gray-100"></div>
                                </div>
                                <div class="flex items-center w-full">
                                    <span class="text-[#9CA3AF] text-[11px] w-8 text-right mr-4 font-medium">200</span>
                                    <div class="flex-1 border-b border-gray-100"></div>
                                </div>
                                <div class="flex items-center w-full">
                                    <span class="text-[#9CA3AF] text-[11px] w-8 text-right mr-4 font-medium">100</span>
                                    <div class="flex-1 border-b border-gray-100"></div>
                                </div>
                                <div class="flex items-center w-full">
                                    <span class="text-[#9CA3AF] text-[11px] w-8 text-right mr-4 font-medium">0</span>
                                    <div class="flex-1 border-b border-gray-100"></div>
                                </div>
                            </div>

                            <!-- Line SVG -->
                            <!-- viewBox x from 0 to 600, y from 0 to 200. Padding applied naturally -->
                            <div class="absolute inset-0 pl-12 pr-4 pb-8 top-1.5 h-[210px] w-full">
                                <svg class="w-full h-full overflow-visible" viewBox="0 0 700 200" preserveAspectRatio="none">
                                    <!-- Line -->
                                    <polyline points="20,150 120,95 220,140 320,90 420,110 520,50 620,70 700,20" fill="none" stroke="#4C1D95" stroke-width="2.5"/>
                                    
                                    <!-- Points -->
                                    <circle cx="20" cy="150" r="4.5" fill="#4C1D95"/>
                                    <circle cx="120" cy="95" r="4.5" fill="#4C1D95"/>
                                    <circle cx="220" cy="140" r="4.5" fill="#4C1D95"/>
                                    <circle cx="320" cy="90" r="4.5" fill="#4C1D95"/>
                                    <circle cx="420" cy="110" r="4.5" fill="#4C1D95"/>
                                    <circle cx="520" cy="50" r="4.5" fill="#4C1D95"/>
                                    <circle cx="620" cy="70" r="4.5" fill="#4C1D95"/>
                                    <circle cx="700" cy="20" r="4.5" fill="#4C1D95"/>
                                </svg>
                            </div>

                            <!-- X-axis labels -->
                            <div class="absolute bottom-0 left-12 right-4 flex justify-between">
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-5px]">May 11</span>
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-10px]">May 12</span>
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-15px]">May 13</span>
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-20px]">May 14</span>
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-25px]">May 15</span>
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-30px]">May 16</span>
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-10px]">May 17</span>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Products &gt;</a>
                </div>

                <!-- Top Products -->
                <div class="col-span-12 lg:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Top Products</h3>
                        
                        <div class="space-y-0">
                            <!-- Product 1 -->
                            <div class="flex items-center justify-between py-5 border-b border-gray-50">
                                <div class="flex items-center text-[#1E1B4B] font-medium text-[13px]">
                                    <span class="mr-6 text-gray-500">1.</span>
                                    <span>AI Platform</span>
                                </div>
                                <span class="text-[#4C1D95] font-bold text-[14px]">412</span>
                            </div>
                            <!-- Product 2 -->
                            <div class="flex items-center justify-between py-5 border-b border-gray-50">
                                <div class="flex items-center text-[#1E1B4B] font-medium text-[13px]">
                                    <span class="mr-6 text-gray-500">2.</span>
                                    <span>IoT Gateway</span>
                                </div>
                                <span class="text-[#4C1D95] font-bold text-[14px]">328</span>
                            </div>
                            <!-- Product 3 -->
                            <div class="flex items-center justify-between py-5">
                                <div class="flex items-center text-[#1E1B4B] font-medium text-[13px]">
                                    <span class="mr-6 text-gray-500">3.</span>
                                    <span>Smart Automation Suite</span>
                                </div>
                                <span class="text-[#4C1D95] font-bold text-[14px]">222</span>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Products &gt;</a>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Lead Sources -->
                <div class="col-span-12 lg:col-span-7 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-8">Lead Sources</h3>
                        
                        <div class="flex items-center justify-center space-x-16">
                            
                            <!-- Donut Chart -->
                            <div class="relative w-48 h-48 flex-shrink-0">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 160 160">
                                    <!-- Base Circle -->
                                    <circle cx="80" cy="80" r="64" fill="none" stroke="#F3F4F6" stroke-width="24"/>
                                    
                                    <!-- Seg 1: Event Directory (45%) -->
                                    <circle cx="80" cy="80" r="64" fill="none" stroke="#4C1D95" stroke-width="24" 
                                            stroke-dasharray="180 402" stroke-dashoffset="0" />
                                    <!-- Seg 2: Direct Search (26%) -->
                                    <circle cx="80" cy="80" r="64" fill="none" stroke="#3B82F6" stroke-width="24" 
                                            stroke-dasharray="104 402" stroke-dashoffset="-180" />
                                    <!-- Seg 3: Email Campaigns (16%) -->
                                    <circle cx="80" cy="80" r="64" fill="none" stroke="#60A5FA" stroke-width="24" 
                                            stroke-dasharray="64 402" stroke-dashoffset="-284" />
                                    <!-- Seg 4: Social Media (10%) -->
                                    <circle cx="80" cy="80" r="64" fill="none" stroke="#C084FC" stroke-width="24" 
                                            stroke-dasharray="40 402" stroke-dashoffset="-348" />
                                </svg>
                                <!-- Center Text -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <h3 class="text-[#1E1B4B] font-black text-[22px] leading-tight mb-1">1,248</h3>
                                    <p class="text-[#6B7280] text-[11px] uppercase tracking-wide font-medium">Total Views</p>
                                </div>
                            </div>

                            <!-- Legend -->
                            <div class="space-y-5">
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#4C1D95] mr-3"></span>
                                    <span class="text-[#4B5563] text-[13px] font-medium w-36">Event Directory</span>
                                    <span class="text-[#1E1B4B] text-[13px] font-bold mr-3 w-8">45%</span>
                                    <span class="text-[#9CA3AF] text-[13px]">(560)</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#3B82F6] mr-3"></span>
                                    <span class="text-[#4B5563] text-[13px] font-medium w-36">Direct Search</span>
                                    <span class="text-[#1E1B4B] text-[13px] font-bold mr-3 w-8">26%</span>
                                    <span class="text-[#9CA3AF] text-[13px]">(320)</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#60A5FA] mr-3"></span>
                                    <span class="text-[#4B5563] text-[13px] font-medium w-36">Email Campaigns</span>
                                    <span class="text-[#1E1B4B] text-[13px] font-bold mr-3 w-8">16%</span>
                                    <span class="text-[#9CA3AF] text-[13px]">(199)</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#C084FC] mr-3"></span>
                                    <span class="text-[#4B5563] text-[13px] font-medium w-36">Social Media</span>
                                    <span class="text-[#1E1B4B] text-[13px] font-bold mr-3 w-8">10%</span>
                                    <span class="text-[#9CA3AF] text-[13px]">(129)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-8">View Full Report &gt;</a>
                </div>

                <!-- Recent Activities -->
                <div class="col-span-12 lg:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Recent Activities</h3>
                        
                        <div class="space-y-6">
                            <!-- Activity 1 -->
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium leading-snug mb-1">New meeting request from TechNova Solutions</p>
                                    <p class="text-[#6B7280] text-[12px]">May 16, 2024 • 01:21 PM</p>
                                </div>
                            </div>

                            <!-- Activity 2 -->
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium leading-snug mb-1">Brochure downloaded by Alex Johnson</p>
                                    <p class="text-[#6B7280] text-[12px]">May 16, 2024 • 01:18 PM</p>
                                </div>
                            </div>

                            <!-- Activity 3 -->
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium leading-snug mb-1">New enquiry from GreenEdge Industries</p>
                                    <p class="text-[#6B7280] text-[12px]">May 16, 2024 • 11:18 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-8">View All Activities &gt;</a>
                </div>

            </div>
        </div>
</section>
@endsection
