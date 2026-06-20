@extends('layouts.company')

@section('title', 'Booth Analytics | eproexpo')
@section('page-title', 'Booth Analytics')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="w-full max-w-[1400px] mx-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-start sm:gap-6 mb-8">
            <div>
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Booth Analytics</h1>
                <p class="text-[#6B7280] text-[15px]">Track performance and engagement for your booth.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <!-- Date Picker -->
                <form method="GET" action="{{ route('company.analytics') }}" class="flex items-center border border-gray-200 bg-white rounded-lg px-4 py-2.5 shadow-sm hover:bg-gray-50 transition-colors m-0">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <select name="range" onchange="this.form.submit()" class="text-[#4B5563] text-[14px] font-medium bg-transparent border-0 focus:ring-0 cursor-pointer pr-7 outline-none">
                        @foreach ($rangeOptions as $days => $label)
                            <option value="{{ $days }}" @selected($selectedRange === $days)>{{ $rangeDateLabels[$days] }}</option>
                        @endforeach
                    </select>
                </form>
                <!-- Export Button -->
                <a href="{{ route('company.analytics', ['range' => $selectedRange, 'export' => 'csv']) }}" class="flex items-center border border-[#3D1B9B] text-[#3D1B9B] bg-white rounded-lg px-4 py-2.5 font-bold text-[14px] shadow-sm hover:bg-[#F5F3FF] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            
            <!-- Card 1: Booth Views -->
            <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Booth Views</p>
                        <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">{{ number_format($totalBoothViews) }}</h3>
                        <p class="text-[#6B7280] text-[12px]">{{ $compareLabel }}</p>
                    </div>
                </div>
                <div class="flex items-center font-bold text-[13px] mt-6 {{ $boothViewsTrend['class'] }}">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $boothViewsTrend['icon'] }}"></path>
                    </svg>
                    {{ $boothViewsTrend['percent'] }}%
                </div>
            </div>

            <!-- Card 2: Product Views -->
            <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Product Views</p>
                        <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">{{ number_format($totalProductViews) }}</h3>
                        <p class="text-[#6B7280] text-[12px]">{{ $compareLabel }}</p>
                    </div>
                </div>
                <div class="flex items-center font-bold text-[13px] mt-6 {{ $productViewsTrend['class'] }}">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $productViewsTrend['icon'] }}"></path>
                    </svg>
                    {{ $productViewsTrend['percent'] }}%
                </div>
            </div>

            <!-- Card 3: Brochure Downloads -->
            <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Brochure Downloads</p>
                        <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">{{ number_format($totalDownloads) }}</h3>
                        <p class="text-[#6B7280] text-[12px]">{{ $compareLabel }}</p>
                    </div>
                </div>
                <div class="flex items-center font-bold text-[13px] mt-6 {{ $downloadsTrend['class'] }}">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $downloadsTrend['icon'] }}"></path>
                    </svg>
                    {{ $downloadsTrend['percent'] }}%
                </div>
            </div>

            <!-- Card 4: Meeting Requests -->
            <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Meeting Requests</p>
                        <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">{{ number_format($totalMeetings) }}</h3>
                        <p class="text-[#6B7280] text-[12px]">{{ $compareLabel }}</p>
                    </div>
                </div>
                <div class="flex items-center font-bold text-[13px] mt-6 {{ $meetingsTrend['class'] }}">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $meetingsTrend['icon'] }}"></path>
                    </svg>
                    {{ $meetingsTrend['percent'] }}%
                </div>
            </div>

            <!-- Card 5: Enquiries -->
            <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Enquiries</p>
                        <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">{{ number_format($totalEnquiries) }}</h3>
                        <p class="text-[#6B7280] text-[12px]">{{ $compareLabel }}</p>
                    </div>
                </div>
                <div class="flex items-center font-bold text-[13px] mt-6 {{ $enquiriesTrend['class'] }}">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $enquiriesTrend['icon'] }}"></path>
                    </svg>
                    {{ $enquiriesTrend['percent'] }}%
                </div>
            </div>

            <!-- Card 6: Session Attendees -->
            <div class="border border-gray-100 rounded-xl p-5 bg-white shadow-sm flex items-start justify-between">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-[#1E1B4B] text-[13px] font-bold mb-1">Session Attendees</p>
                        <h3 class="text-[#1E1B4B] text-[26px] font-black leading-none mb-2">{{ number_format($totalSessionAttendees) }}</h3>
                        <p class="text-[#6B7280] text-[12px]">{{ $compareLabel }}</p>
                    </div>
                </div>
                <div class="flex items-center font-bold text-[13px] mt-6 {{ $sessionAttendeesTrend['class'] }}">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $sessionAttendeesTrend['icon'] }}"></path>
                    </svg>
                    {{ $sessionAttendeesTrend['percent'] }}%
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
                            @foreach ($chartData['y_labels'] as $label)
                                <div class="flex items-center w-full">
                                    <span class="text-[#9CA3AF] text-[11px] w-8 text-right mr-4 font-medium">{{ $label }}</span>
                                    <div class="flex-1 border-b border-gray-100"></div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Line SVG -->
                        <div class="absolute inset-0 pl-12 pr-4 pb-8 top-1.5 h-[210px] w-full">
                            <svg class="w-full h-full overflow-visible" viewBox="0 0 700 200" preserveAspectRatio="none">
                                <!-- Line -->
                                <polyline points="{{ $chartData['polyline'] }}" fill="none" stroke="#4C1D95" stroke-width="2.5"/>
                                
                                <!-- Points -->
                                @foreach ($chartData['points'] as $p)
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4.5" fill="#4C1D95"/>
                                @endforeach
                            </svg>
                        </div>

                        <!-- X-axis labels -->
                        <div class="absolute bottom-0 left-12 right-4 flex justify-between">
                            @foreach ($chartData['points'] as $p)
                                <span class="text-[#9CA3AF] text-[11px] font-medium ml-[-15px]">{{ $p['show_label'] ? $p['label'] : '' }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($latestBooking)
                    <a href="{{ route('company.booth-setup.products.index', $latestBooking) }}" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Products &gt;</a>
                @else
                    <a href="#" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Products &gt;</a>
                @endif
            </div>

            <!-- Top Products -->
            <div class="col-span-12 lg:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Top Products</h3>
                    
                    <div class="space-y-0">
                        @forelse ($topProducts as $idx => $prod)
                            <div class="flex items-center justify-between py-5 border-b border-gray-50">
                                <div class="flex items-center text-[#1E1B4B] font-medium text-[13px]">
                                    <span class="mr-6 text-gray-500">{{ $idx + 1 }}.</span>
                                    <span>{{ $prod->name }}</span>
                                </div>
                                <span class="text-[#4C1D95] font-bold text-[14px]">{{ $prod->views }}</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 text-[13px]">No products uploaded yet.</div>
                        @endforelse
                    </div>
                </div>
                @if ($latestBooking)
                    <a href="{{ route('company.booth-setup.products.index', $latestBooking) }}" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Products &gt;</a>
                @else
                    <a href="#" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Products &gt;</a>
                @endif
            </div>

        </div>

        <!-- Bottom Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
            
            <!-- Lead Sources -->
            <div class="col-span-12 lg:col-span-7 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Traffic Sources</h3>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-around gap-6">
                        <!-- Donut Chart -->
                        <div class="relative w-40 h-40 flex-shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 160 160">
                                @php $offset = 0; @endphp
                                @foreach ($leadSources as $source)
                                    @php
                                        $circumference = 402;
                                        $dasharray = (int) round(($source['percent'] / 100) * $circumference);
                                        $dashoffset = -$offset;
                                        $offset += $dasharray;
                                    @endphp
                                    <circle cx="80" cy="80" r="64" fill="none" stroke="{{ $source['color'] }}" stroke-width="24" 
                                            stroke-dasharray="{{ $dasharray }} {{ $circumference - $dasharray }}" stroke-dashoffset="{{ $dashoffset }}" />
                                @endforeach
                            </svg>
                            <!-- Center Text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <h3 class="text-[#1E1B4B] font-black text-[22px] leading-tight mb-1">{{ number_format($totalTrafficSourceViews) }}</h3>
                                <p class="text-[#6B7280] text-[11px] uppercase tracking-wide font-medium">Total Views</p>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="space-y-5">
                            @foreach ($leadSources as $source)
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full mr-3" style="background-color: {{ $source['color'] }}"></span>
                                    <span class="text-[#4B5563] text-[13px] font-medium w-36">{{ $source['name'] }}</span>
                                    <span class="text-[#1E1B4B] text-[13px] font-bold mr-3 w-8">{{ $source['percent'] }}%</span>
                                    <span class="text-[#9CA3AF] text-[13px]">({{ number_format($source['count']) }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <a href="{{ route('company.analytics', ['range' => $selectedRange, 'export' => 'csv']) }}" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-8">View Full Report &gt;</a>
            </div>

            <!-- Recent Activities -->
            <div class="col-span-12 lg:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Recent Activities</h3>
                    
                    <div class="space-y-6">
                        @forelse ($recentActivities as $act)
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 {{ $act['bg_color'] }}">
                                    {!! $act['icon'] !!}
                                </div>
                                <div>
                                    <p class="text-[#1E1B4B] text-[13px] font-medium leading-snug mb-1">{{ $act['title'] }}</p>
                                    <p class="text-[#6B7280] text-[12px]">{{ $act['time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 text-[13px]">No recent activity logged.</div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('company.analytics', ['range' => $selectedRange, 'export' => 'csv']) }}" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-8">View All Activities &gt;</a>
            </div>

        </div>
    </div>
</section>
@endsection
