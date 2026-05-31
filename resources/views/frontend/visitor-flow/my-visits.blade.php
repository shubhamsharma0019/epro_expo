<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - My Visits</title>
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
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white">@include('frontend.visitor-flow.sidebar')</div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FAFAFA]">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-8 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <div class="flex flex-col lg:flex-row gap-8 max-w-[1200px] mx-auto">
                
                <!-- Left: Dashboard Area -->
                <div class="flex-1 flex flex-col">
                    
                    <h1 class="text-[20px] font-bold text-[#1E1B4B] mb-4">My Visits / Dashboard</h1>
                    
                    <!-- Tabs -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 border-b border-gray-200 mb-6">
                        <div onclick="filterVisits('all', this)" class="tab-btn pb-3 border-b-2 border-primary-600 font-bold text-primary-600 text-[14px] cursor-pointer">All Visits</div>
                        <div onclick="filterVisits('pavilion', this)" class="tab-btn pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Pavilions</div>
                        <div onclick="filterVisits('hall', this)" class="tab-btn pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Halls</div>
                        <div onclick="filterVisits('exhibitor', this)" class="tab-btn pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Exhibitors</div>
                    </div>

                    <!-- Dynamic Visits Container -->
                    <div id="visits-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Cards will load dynamically -->
                    </div>

                    <!-- Empty State -->
                    <div id="visits-empty" class="hidden border border-gray-100 rounded-2xl bg-white p-12 text-center shadow-sm flex flex-col items-center justify-center min-h-[350px]">
                        <div class="w-16 h-16 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 mb-4 border border-indigo-100/50">
                            <i class="ph ph-bookmark-simple text-[32px]"></i>
                        </div>
                        <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-2">No planned visits yet</h3>
                        <p class="text-[13px] text-gray-500 max-w-sm mb-6 leading-relaxed">Bookmarked pavilions, halls, and exhibitors will appear here so you can easily plan your day on the exhibition floor.</p>
                        <button onclick="window.location.href='pavallion.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors shadow-sm">
                            Explore Pavilions
                        </button>
                    </div>
                </div>

                <!-- Right: Side Card widgets -->
                <div class="w-full lg:w-[320px] shrink-0 flex flex-col gap-6">
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h2 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Visit Overview</h2>
                        <div class="space-y-4 text-[12px]">
                            <div class="flex justify-between pb-3 border-b border-gray-50">
                                <span class="text-gray-500 font-medium">Total Saved</span>
                                <span id="stat-total" class="font-bold text-[#1E293B]">0 Items</span>
                            </div>
                            <div class="flex justify-between pb-3 border-b border-gray-50">
                                <span class="text-gray-500 font-medium">Pavilions</span>
                                <span id="stat-pavilions" class="font-bold text-[#1E293B]">0</span>
                            </div>
                            <div class="flex justify-between pb-3 border-b border-gray-50">
                                <span class="text-gray-500 font-medium">Halls</span>
                                <span id="stat-halls" class="font-bold text-[#1E293B]">0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-medium">Exhibitors</span>
                                <span id="stat-exhibitors" class="font-bold text-[#1E293B]">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Help Desk -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-5 shadow-sm text-center">
                        <h3 class="font-bold text-[#1E1B4B] text-[14px] mb-1.5 text-left">Planning Assistance</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed text-left mb-4 font-normal">Need a customized path? Our lobby hosts can print out a map of your bookmarked visits.</p>
                        <a href="lobby.html" class="w-full bg-[#4A22E0] hover:bg-[#3D1CBA] text-white py-2.5 rounded-lg font-bold text-[12px] text-center block transition-colors shadow-sm">
                            Go to Lobby
                        </a>
                    </div>
                </div>

            </div>
            
            <div class="h-8"></div>
        </div>
    </main>

    <script src="exhibition-api.js"></script>
    <script src="script.js"></script>
    <script>
        let currentTab = 'all';

        async function loadVisits() {
            const bookingId = localStorage.getItem('lastBookingId');
            const grid = document.getElementById('visits-grid');
            const emptyState = document.getElementById('visits-empty');
            
            if (!bookingId) {
                grid.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            try {
                // Get all bookmarks from backend
                const bookmarks = await ExhibitionAPI.getBookmarks(bookingId);

                // Fetch metadata for each bookmark in parallel
                const fetchPromises = bookmarks.map(async (b) => {
                    try {
                        let entityData = null;
                        if (b.bookmarkable_type === 'exhibitor') {
                            entityData = await ExhibitionAPI.getExhibitor(b.bookmarkable_id);
                        } else if (b.bookmarkable_type === 'pavilion') {
                            entityData = await ExhibitionAPI.getPavilion(b.bookmarkable_id);
                        } else if (b.bookmarkable_type === 'hall') {
                            entityData = await ExhibitionAPI.getHall(b.bookmarkable_id);
                        }

                        if (entityData) {
                            return {
                                id: b.bookmarkable_id,
                                type: b.bookmarkable_type,
                                title: entityData.name || entityData.title || '',
                                subtitle: entityData.description || entityData.subtitle || '',
                                imageUrl: entityData.banner_url || entityData.image_url || entityData.rep_img_url || '',
                                extra: b.bookmarkable_type === 'exhibitor' 
                                    ? `${entityData.hall_name || 'Hall 1'}, ${entityData.booth_number || 'Booth'}` 
                                    : (b.bookmarkable_type === 'pavilion' 
                                        ? `${entityData.booths_count || '10+'} Booths` 
                                        : `${entityData.area || '10,000'} sqm`)
                            };
                        }
                    } catch (err) {
                        console.warn('Error fetching metadata for bookmark:', b, err);
                    }
                    return null;
                });

                const visits = (await Promise.all(fetchPromises)).filter(Boolean);

                // Calculate and display stats
                const counts = { pavilion: 0, hall: 0, exhibitor: 0 };
                visits.forEach(v => {
                    if (counts[v.type] !== undefined) counts[v.type]++;
                });

                document.getElementById('stat-total').textContent = `${visits.length} Items`;
                document.getElementById('stat-pavilions').textContent = counts.pavilion;
                document.getElementById('stat-halls').textContent = counts.hall;
                document.getElementById('stat-exhibitors').textContent = counts.exhibitor;

                const filtered = currentTab === 'all' ? visits : visits.filter(v => v.type === currentTab);

                if (filtered.length === 0) {
                    grid.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                    grid.classList.remove('hidden');
                    
                    let html = '';
                    filtered.forEach((item, index) => {
                        const fallbackImg = item.type === 'hall' 
                            ? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80'
                            : (item.type === 'pavilion' 
                                ? 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=400&q=80'
                                : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=400&q=80');

                        const detailsPage = item.type === 'pavilion' 
                            ? `pavilion-details.html?id=${item.id}`
                            : (item.type === 'hall' 
                                ? `hall-details.html?id=${item.id}` 
                                : `exhibitor-details.html?id=${item.id}`);

                        const typeBadgeColors = {
                            pavilion: 'bg-indigo-50 text-indigo-600 border-indigo-100',
                            hall: 'bg-pink-50 text-pink-600 border-pink-100',
                            exhibitor: 'bg-green-50 text-green-600 border-green-100'
                        };

                        const badgeClass = typeBadgeColors[item.type] || 'bg-gray-50 text-gray-600 border-gray-100';

                        html += `
                            <div id="visit-card-${item.type}-${item.id}" class="bg-white border border-gray-100 rounded-[20px] overflow-hidden shadow-sm flex flex-col h-[320px] hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <div class="h-32 relative overflow-hidden bg-gray-100 shrink-0">
                                    <img src="${item.imageUrl || fallbackImg}" alt="${item.title}" class="w-full h-full object-cover">
                                    <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold border capitalize ${badgeClass}">
                                        ${item.type}
                                    </span>
                                    <button onclick="removeVisitItem('${item.type}', '${item.id}')" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-red-500 flex items-center justify-center transition-colors shadow-sm">
                                        <i class="ph-bold ph-trash text-[16px]"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1 leading-snug line-clamp-1">${item.title}</h3>
                                    <p class="text-[11px] text-gray-500 font-medium mb-3 line-clamp-2 leading-relaxed">${item.subtitle}</p>
                                    
                                    <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-600">
                                        <span>${item.extra || ''}</span>
                                        <a href="${detailsPage}" class="text-[#4A22E0] hover:underline flex items-center gap-1">
                                            View Details <i class="ph-bold ph-caret-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    grid.innerHTML = html;
                }
            } catch (err) {
                console.error('Error fetching bookmarks for dashboard:', err);
            }
        }

        async function removeVisitItem(type, id) {
            const bookingId = localStorage.getItem('lastBookingId');
            if (!bookingId) return;

            const card = document.getElementById(`visit-card-${type}-${id}`);
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(async () => {
                    await ExhibitionAPI.toggleBookmark(bookingId, type, id);
                    loadVisits();
                }, 300);
            }
        }

        function filterVisits(tab, btnEl) {
            currentTab = tab;
            
            // Toggle active styles on tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors';
            });
            
            btnEl.className = 'tab-btn pb-3 border-b-2 border-primary-600 font-bold text-primary-600 text-[14px] cursor-pointer';
            
            loadVisits();
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadVisits();
        });
    </script>
</body>
</html>
