<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Global Tech Summit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 500: '#5A32FA', 600: '#4A22E0' }
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
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white">@include('frontend.visitor-flow.sidebar')</div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="{{ url('/exhibitions') }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibitions
            </a>

            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image -->
                    <div id="exh-image" class="w-[150px] h-[150px] rounded-2xl bg-cover bg-center border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.05)]" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                    
                    <!-- Info -->
                    <div class="flex flex-col justify-center">
                        <h1 id="exh-name" class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-3">Global Tech Summit 2024</h1>
                        
                        <div class="flex items-center gap-5 text-[#475569] text-[14px] font-medium mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span id="exh-dates">May 15 – May 17, 2024</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-2">
                                <i class="ph ph-clock text-[18px]"></i>
                                <span>09:00 AM – 06:00 PM (IST)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 text-[#475569] text-[14px] font-medium mb-5">
                            <i class="ph ph-map-pin text-[18px]"></i>
                            <span id="exh-venue">Jio World Convention Centre, Mumbai, India</span>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">Technology</span>
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">Innovation</span>
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">AI & ML</span>
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">Cloud</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button class="flex items-center gap-2 border border-gray-200 bg-white text-indigo-600 hover:bg-gray-50 rounded-xl px-5 py-2.5 font-bold text-[14px] transition-colors shadow-sm">
                        <i class="ph ph-share-network text-[20px] font-bold"></i> Share
                    </button>
                    <button class="flex items-center justify-center border border-gray-200 bg-white text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 rounded-xl w-[44px] h-[44px] transition-colors shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <i class="ph ph-heart text-[22px]"></i>
                    </button>
                </div>
            </div>

            <!-- Description -->
            <p id="exh-description" class="text-[#64748B] text-[15px] font-medium leading-relaxed max-w-[850px] mb-8">
                Global Tech Summit brings together industry leaders, innovators, researchers, and tech enthusiasts to shape the future of technology and digital transformation.
            </p>

            <!-- Stats Row -->
            <div class="border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 flex items-center justify-around bg-white max-w-full">
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        <span id="exh-companies-count">120+</span>
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Companies</div>
                </div>
                <div class="w-px h-12 bg-gray-100"></div>
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        8+
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Countries</div>
                </div>
                <div class="w-px h-12 bg-gray-100"></div>
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        14
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Speakers</div>
                </div>
                <div class="w-px h-12 bg-gray-100"></div>
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        50+
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Sessions</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-8 flex flex-col lg:flex-row gap-8 select-none">
                <button onclick="switchTab('overview', this)" class="tab-btn pb-4 text-[15px] font-bold text-indigo-700 border-b-[3px] border-indigo-700 -mb-[1.5px]">Overview</button>
                <button onclick="switchTab('agenda', this)" class="tab-btn pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 border-b-[3px] border-transparent -mb-[1.5px] transition-colors">Agenda</button>
                <button onclick="switchTab('speakers', this)" class="tab-btn pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 border-b-[3px] border-transparent -mb-[1.5px] transition-colors">Speakers</button>
                <button onclick="switchTab('sponsors', this)" class="tab-btn pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 border-b-[3px] border-transparent -mb-[1.5px] transition-colors">Sponsors</button>
                <button onclick="switchTab('floorplan', this)" class="tab-btn pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 border-b-[3px] border-transparent -mb-[1.5px] transition-colors">Floor Plan</button>
                <button onclick="switchTab('faqs', this)" class="tab-btn pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 border-b-[3px] border-transparent -mb-[1.5px] transition-colors">FAQs</button>
            </div>

            <!-- Tab Panels -->
            <div id="tab-panels-container">
                
                <!-- Overview Panel -->
                <div id="panel-overview" class="tab-panel grid grid-cols-1 lg:grid-cols-[1fr_1.3fr] gap-6 pb-10">
                    <!-- Left: What to Expect -->
                    <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                        <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-7">What to Expect</h2>
                        
                        <div class="space-y-6 mb-8 flex-1">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <i class="ph ph-star text-[20px]"></i>
                                </div>
                                <span class="text-[14px] text-[#475569] font-semibold">Explore innovative solutions</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <i class="ph ph-users text-[20px]"></i>
                                </div>
                                <span class="text-[14px] text-[#475569] font-semibold">Live product demos</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <i class="ph ph-user-circle text-[20px]"></i>
                                </div>
                                <span class="text-[14px] text-[#475569] font-semibold">Network with industry leaders</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <i class="ph ph-presentation-chart text-[20px]"></i>
                                </div>
                                <span class="text-[14px] text-[#475569] font-semibold">Panel discussions & keynotes</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <i class="ph ph-certificate text-[20px]"></i>
                                </div>
                                <span class="text-[14px] text-[#475569] font-semibold">One-to-one meetings</span>
                            </div>
                        </div>
                        
                        <a id="get-pass-btn" href="pass-selection.html" class="w-full inline-block text-center bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px]">
                            Get Visitor Pass
                        </a>
                    </div>

                    <!-- Right: Participating Companies -->
                    <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                        <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-7">Participating Companies</h2>
                        
                        <!-- Logos Grid -->
                        <div id="dyn-companies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <!-- Loaded dynamically -->
                        </div>


                    </div>
                </div>

                <!-- Agenda Panel -->
                <div id="panel-agenda" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Conference Agenda / Schedule</h2>
                    <div id="dyn-agenda-list" class="space-y-6">
                        <!-- Loaded dynamically -->
                    </div>
                </div>

                <!-- Speakers Panel -->
                <div id="panel-speakers" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Keynote Speakers</h2>
                    <div id="dyn-speakers-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Loaded dynamically -->
                    </div>
                </div>

                <!-- Sponsors Panel -->
                <div id="panel-sponsors" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-8 text-center">Event Sponsors & Partners</h2>
                    
                    <div class="space-y-12">
                        <!-- Platinum Sponsors -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="bg-indigo-50 border border-indigo-150 text-indigo-700 font-bold px-3 py-1 rounded text-[11px] uppercase tracking-wider">Platinum Sponsors</span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>
                            <div id="dyn-platinum-sponsors" class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Gold Sponsors -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="bg-yellow-50 border border-yellow-150 text-yellow-700 font-bold px-3 py-1 rounded text-[11px] uppercase tracking-wider">Gold Sponsors</span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>
                            <div id="dyn-gold-sponsors" class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Silver Sponsors -->
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="bg-gray-50 border border-gray-150 text-gray-600 font-bold px-3 py-1 rounded text-[11px] uppercase tracking-wider">Silver Sponsors</span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>
                            <div id="dyn-silver-sponsors" class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floor Plan Panel -->
                <div id="panel-floorplan" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-[18px] font-bold text-[#1E1B4B]">Exhibition Halls Floor Plan</h2>
                        <button onclick="window.location.href='view-floor-map.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                            <i class="ph ph-map-trifold text-[18px]"></i> Full Floor Map
                        </button>
                    </div>
                    <p class="text-[13px] text-gray-500 mb-8 leading-relaxed">Select any hall below to explore interactive booths, find registered exhibitors, or book B2B meeting slots.</p>
                    <div id="dyn-halls-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Loaded dynamically -->
                    </div>
                </div>

                <!-- FAQs Panel -->
                <div id="panel-faqs" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Frequently Asked Questions</h2>
                    <div id="dyn-faqs-accordion" class="space-y-4">
                        <!-- Loaded dynamically -->
                    </div>
                </div>

            </div>
            
        </div>
    </main>

    <script src="exhibition-api.js"></script>
    <script src="script.js"></script>
    <script>
        // Switch tabs dynamically
        function switchTab(tabId, el) {
            // Hide all tab panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            
            // Show target tab panel
            const targetPanel = document.getElementById(`panel-${tabId}`);
            if (targetPanel) targetPanel.classList.remove('hidden');

            // Reset active tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 border-b-[3px] border-transparent -mb-[1.5px] transition-colors';
            });

            // Set current tab button active styles
            el.className = 'tab-btn pb-4 text-[15px] font-bold text-indigo-700 border-b-[3px] border-indigo-700 -mb-[1.5px]';
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            let exhId = urlParams.get('id') || localStorage.getItem('activeExhibitionId') || '1';
            
            const ex = await ExhibitionAPI.getExhibition(exhId);
            if (ex) {
                // Save resolved parameters
                localStorage.setItem('activeExhibitionId', ex.id);
                localStorage.setItem('activeExhibitionName', ex.name);
                
                // Update elements
                document.getElementById('exh-name').textContent = ex.name;
                document.getElementById('exh-description').textContent = ex.description || '';
                document.getElementById('exh-venue').textContent = ex.venue;
                document.getElementById('exh-companies-count').textContent = (ex.companies_count || 120) + '+';
                
                let dateStr = 'May 15 – May 17, 2026';
                if (ex.start_date && ex.end_date) {
                    const start = new Date(ex.start_date);
                    const end = new Date(ex.end_date);
                    dateStr = `${start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} – ${end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                }
                document.getElementById('exh-dates').textContent = dateStr;
                
                if (ex.banner_url) {
                    document.getElementById('exh-image').style.backgroundImage = `url('${ex.banner_url}')`;
                }
                
                // Add query parameter to booking button
                const passBtn = document.getElementById('get-pass-btn');
                if (passBtn) {
                    passBtn.href = `pass-selection.html?id=${ex.id}`;
                }

                // Load Sponsors & Companies
                const sponsors = await ExhibitionAPI.getSponsors(ex.id);
                
                // 1. Overview Companies grid (Top 9 sponsors)
                const overviewGrid = document.getElementById('dyn-companies-grid');
                if (overviewGrid) {
                    let html = '';
                    sponsors.slice(0, 9).forEach(sp => {
                        html += `
                            <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                                <img src="${sp.logo_url}" alt="${sp.name}" class="h-6 opacity-90 max-w-full">
                            </div>
                        `;
                    });
                    overviewGrid.innerHTML = html;
                }

                // 2. Sponsors Tab classifications
                const platinumGrid = document.getElementById('dyn-platinum-sponsors');
                const goldGrid = document.getElementById('dyn-gold-sponsors');
                const silverGrid = document.getElementById('dyn-silver-sponsors');

                if (platinumGrid && goldGrid && silverGrid) {
                    let platHtml = '', goldHtml = '', silvHtml = '';
                    sponsors.forEach(sp => {
                        const cardHtml = `
                            <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center justify-center shadow-[0_2px_8px_rgba(0,0,0,0.02)] h-[90px] hover:border-indigo-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <img src="${sp.logo_url}" alt="${sp.name}" class="h-7 max-w-full object-contain mb-1">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide">${sp.name}</span>
                            </div>
                        `;
                        if (sp.level === 'Platinum') platHtml += cardHtml;
                        else if (sp.level === 'Gold') goldHtml += cardHtml;
                        else silvHtml += cardHtml;
                    });
                    
                    platinumGrid.innerHTML = platHtml || '<div class="text-[12px] text-gray-400">None</div>';
                    goldGrid.innerHTML = goldHtml || '<div class="text-[12px] text-gray-400">None</div>';
                    silverGrid.innerHTML = silvHtml || '<div class="text-[12px] text-gray-400">None</div>';
                }

                // 3. Load Agenda Sessions
                const agenda = await ExhibitionAPI.getAgenda(ex.id);
                const agendaContainer = document.getElementById('dyn-agenda-list');
                if (agendaContainer) {
                    if (agenda.length === 0) {
                        agendaContainer.innerHTML = '<div class="text-gray-400 text-sm">No agenda sessions listed for this event.</div>';
                    } else {
                        let html = '';
                        agenda.forEach((session, i) => {
                            html += `
                                <div class="flex gap-6 items-start pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                    <div class="w-[120px] shrink-0">
                                        <div class="text-indigo-600 font-bold text-[14px] mb-0.5">${session.start_time}</div>
                                        <div class="text-gray-400 font-semibold text-[11px] uppercase">${session.end_time}</div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1.5">${session.title}</h3>
                                        <p class="text-gray-500 text-[13px] leading-relaxed mb-3">${session.description || ''}</p>
                                        <div class="flex flex-wrap gap-4 text-[12px] font-semibold text-gray-600">
                                            <div class="flex items-center gap-1.5"><i class="ph ph-user text-indigo-500 text-[16px]"></i> ${session.speaker_name}</div>
                                            <div class="flex items-center gap-1.5"><i class="ph ph-map-pin text-indigo-500 text-[16px]"></i> ${session.hall_name}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        agendaContainer.innerHTML = html;
                    }
                }

                // 4. Load Keynote Speakers
                const speakers = await ExhibitionAPI.getSpeakers(ex.id);
                const speakersContainer = document.getElementById('dyn-speakers-grid');
                if (speakersContainer) {
                    if (speakers.length === 0) {
                        speakersContainer.innerHTML = '<div class="text-gray-400 text-sm">No keynote speakers listed.</div>';
                    } else {
                        let html = '';
                        speakers.forEach(sp => {
                            html += `
                                <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-center text-center hover:border-indigo-100 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                    <img src="${sp.avatar_url}" alt="${sp.name}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-50 mb-4">
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">${sp.name}</h4>
                                    <div class="text-indigo-600 font-bold text-[11px] mb-3">${sp.title} • ${sp.company}</div>
                                    <p class="text-[12px] text-gray-500 leading-relaxed font-medium line-clamp-3">${sp.bio || ''}</p>
                                </div>
                            `;
                        });
                        speakersContainer.innerHTML = html;
                    }
                }

                // 5. Load Floor Plan Halls
                const halls = await ExhibitionAPI.getHalls();
                const hallsGrid = document.getElementById('dyn-halls-grid');
                if (hallsGrid) {
                    let html = '';
                    halls.forEach(hall => {
                        html += `
                            <div onclick="window.location.href='hall-details.html?id=${hall.id}'" class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="h-28 relative">
                                    <img src="${hall.image_url}" class="w-full h-full object-cover">
                                    <div class="absolute top-2 left-2 bg-[#4A22E0] text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">${hall.badge}</div>
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 truncate">${hall.title}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium line-clamp-2 leading-relaxed mb-3 flex-1">${hall.subtitle}</p>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-indigo-700">
                                        <span>${hall.exhibitors_count} Exhibitors</span>
                                        <i class="ph ph-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    hallsGrid.innerHTML = html;
                }

                // 6. Load FAQs Accordion
                const faqs = await ExhibitionAPI.getFaqs(ex.id);
                const faqsContainer = document.getElementById('dyn-faqs-accordion');
                if (faqsContainer) {
                    if (faqs.length === 0) {
                        faqsContainer.innerHTML = '<div class="text-gray-400 text-sm">No FAQs available.</div>';
                    } else {
                        let html = '';
                        faqs.forEach((faq, idx) => {
                            html += `
                                <div class="border border-gray-150 rounded-xl overflow-hidden bg-[#FAFAFC]">
                                    <button onclick="toggleFaqAccordion(${idx})" class="w-full flex items-center justify-between p-4 text-left font-bold text-[#1E1B4B] text-[13px] hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ${faq.icon || 'ph-question'} text-[18px] text-indigo-600"></i>
                                            <span>${faq.question}</span>
                                        </div>
                                        <i id="faq-chevron-${idx}" class="ph ph-caret-down text-[16px] text-gray-400 transition-transform"></i>
                                    </button>
                                    <div id="faq-answer-${idx}" class="hidden p-4 pt-0 border-t border-gray-150 text-[12px] text-gray-600 leading-relaxed bg-white">
                                        ${faq.answer}
                                    </div>
                                </div>
                            `;
                        });
                        faqsContainer.innerHTML = html;
                    }
                }
            }
        });

        // FAQ accordion toggle helper
        function toggleFaqAccordion(idx) {
            const answer = document.getElementById(`faq-answer-${idx}`);
            const chevron = document.getElementById(`faq-chevron-${idx}`);
            if (answer && chevron) {
                const isHidden = answer.classList.contains('hidden');
                if (isHidden) {
                    answer.classList.remove('hidden');
                    chevron.classList.add('rotate-180');
                } else {
                    answer.classList.add('hidden');
                    chevron.classList.remove('rotate-180');
                }
            }
        }
    </script>
</body>
</html>
