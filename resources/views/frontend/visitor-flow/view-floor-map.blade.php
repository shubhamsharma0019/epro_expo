<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - All Booths</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#F5F3FF', 100: '#EDE9FE', 200: '#DDD6FE', 500: '#8B5CF6', 600: '#4A22E0', 700: '#3D1CBA', 800: '#2E159F' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAFAFA; }
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
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-gray-50 to-[#EDE9FE]">
            
            <a id="dyn-back-link" href="halls.html" class="inline-flex items-center gap-2 text-[#4A22E0] hover:text-[#3D1CBA] font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Halls
            </a>

            <div class="flex flex-col lg:flex-row gap-8 max-w-[1500px]">
                
                <!-- Left: Main Content Area -->
                <div class="flex-1 flex flex-col min-w-0 w-full">
                    
                    <!-- Hero Hall Card -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-5 shadow-sm mb-8 flex items-center gap-6">
                        <div class="w-[200px] h-[140px] rounded-[16px] relative overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80" alt="Hall" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 flex flex-col pt-1">
                            <div class="mb-2">
                                <span class="bg-[#4A22E0] text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wide">Hall 1</span>
                            </div>
                            <h1 class="text-[24px] font-bold text-[#1E1B4B] mb-1.5 tracking-tight">Hall 1 – AI & IA</h1>
                            <p class="text-[12px] text-gray-500 font-medium mb-4">Artificial Intelligence & Intelligent Automation solutions.</p>
                            
                            <div class="flex flex-col lg:flex-row items-center gap-8 text-[11px] text-gray-600 font-medium">
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-users text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">45+</span>
                                        <span>Exhibitors</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-newspaper-clipping text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">350+</span>
                                        <span>Products</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-bounding-box text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">12,500 sqm</span>
                                        <span>Total Area</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-storefront text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">350+</span>
                                        <span>Booths</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons on far right -->
                        <div class="flex items-center gap-3 shrink-0 ml-auto mr-2">
                            <button onclick="window.location.href='hall-details.html?id=' + hallId" class="border border-primary-200 text-[#4A22E0] hover:bg-primary-50 px-5 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                <i class="ph-bold ph-map-trifold text-[16px]"></i> View Floor Map
                            </button>
                            <button id="dyn-bookmark-btn" onclick="toggleHallBookmark()" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-5 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                <i class="ph-bold ph-bookmark-simple text-[16px]"></i> Add to My Visits
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex flex-col lg:flex-row gap-8 border-b border-gray-100 mb-6 px-2 select-none">
                        <button onclick="switchTab('all', this)" class="tab-btn text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]">All Booths</button>
                        <button onclick="switchTab('featured', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Featured Exhibitors</button>
                        <button onclick="switchTab('category', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">By Category</button>
                        <button onclick="switchTab('az', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">By A - Z</button>
                    </div>

                    <!-- Search and Sort -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="relative w-full max-w-[380px]">
                            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                            <input type="text" id="dyn-search-input" oninput="handleSearch(this.value)" placeholder="Search by company name or booth number..." class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 text-[13px] font-medium focus:outline-none focus:border-primary-500 bg-white shadow-sm">
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <button class="w-8 h-8 rounded text-[#4A22E0] bg-primary-50 flex items-center justify-center shadow-sm">
                                    <i class="ph ph-squares-four text-[18px]"></i>
                                </button>
                                <button class="w-8 h-8 rounded text-gray-400 hover:text-gray-600 flex items-center justify-center transition-colors">
                                    <i class="ph ph-list-dashes text-[18px]"></i>
                                </button>
                            </div>
                            <select id="dyn-sort-select" onchange="handleSort(this.value)" class="border border-gray-200 bg-white rounded-lg px-4 py-2 text-[13px] font-bold text-gray-700 hover:bg-gray-50 shadow-sm focus:outline-none cursor-pointer">
                                <option value="booth">Sort by: Booth</option>
                                <option value="az">Sort by: A - Z</option>
                                <option value="za">Sort by: Z - A</option>
                            </select>
                        </div>
                    </div>

                    <!-- Booths Grid / Tab Wrapper -->
                    <div id="dyn-booths-wrapper" class="w-full pb-20">
                        <!-- Loaded dynamically -->
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <script src="exhibition-api.js"></script>
    <script src="script.js"></script>
    <script>
        const params = new URLSearchParams(window.location.search);
        const hallId = params.get("id") || "hall1";
        const bookingId = localStorage.getItem('lastBookingId');
        const activeExhibitionId = localStorage.getItem('activeExhibitionId') || '1';
        let isBookmarked = false;

        // Global State for Exhibitors
        let hallExhibitors = [];
        let activeTab = 'all';
        let searchQuery = '';
        let currentSort = 'booth';
        let userBookmarks = [];

        async function updateBookmarkUI() {
            const btn = document.getElementById("dyn-bookmark-btn");
            const btnHtml = isBookmarked 
                ? `<i class="ph-fill ph-bookmark-simple text-[16px] text-primary-500"></i> Remove from Visits`
                : `<i class="ph ph-bookmark-simple text-[16px]"></i> Add to My Visits`;
            if (btn) btn.innerHTML = btnHtml;
        }

        async function toggleHallBookmark() {
            if (!bookingId) {
                alert("Please select a pass and register first to save items to your visits!");
                window.location.href = "pass-selection.html";
                return;
            }
            const res = await ExhibitionAPI.toggleBookmark(bookingId, 'hall', hallId);
            isBookmarked = (res.status === 'added');
            updateBookmarkUI();
        }

        function switchTab(tabId, el) {
            activeTab = tabId;
            
            // Update tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors";
            });
            el.className = "tab-btn text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]";

            renderExhibitors();
        }

        function handleSearch(val) {
            searchQuery = val.toLowerCase().trim();
            renderExhibitors();
        }

        function handleSort(val) {
            currentSort = val;
            renderExhibitors();
        }

        // Main rendering coordinator
        function renderExhibitors() {
            const wrapper = document.getElementById('dyn-booths-wrapper');
            if (!wrapper) return;

            // 1. Filter by Search Query & Tab State
            let filtered = [...hallExhibitors];

            if (searchQuery) {
                filtered = filtered.filter(exh => 
                    (exh.name && exh.name.toLowerCase().includes(searchQuery)) || 
                    (exh.booth_number && exh.booth_number.toLowerCase().includes(searchQuery))
                );
            }

            if (activeTab === 'featured') {
                filtered = filtered.filter(exh => 
                    userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id)
                );
            }

            // 2. Apply Sorting
            filtered.sort((a, b) => {
                if (currentSort === 'az') {
                    return (a.name || '').localeCompare(b.name || '');
                } else if (currentSort === 'za') {
                    return (b.name || '').localeCompare(a.name || '');
                } else {
                    // Default Booth Sort
                    const aNum = parseInt((a.booth_number || '').replace(/\D/g, '')) || 999;
                    const bNum = parseInt((b.booth_number || '').replace(/\D/g, '')) || 999;
                    return aNum - bNum;
                }
            });

            // 3. Render HTML according to Active Tab Mode
            if (filtered.length === 0) {
                wrapper.innerHTML = '<div class="text-gray-400 text-sm font-medium py-12 text-center bg-gray-50 rounded-2xl border border-gray-100">No exhibitors match the selected criteria.</div>';
                return;
            }

            if (activeTab === 'all' || activeTab === 'featured') {
                // Render as a standard grid layout
                let html = '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">';
                filtered.forEach(exh => {
                    html += getExhibitorCardHtml(exh);
                });
                html += '</div>';
                wrapper.innerHTML = html;
            } else if (activeTab === 'category') {
                // Group by Category
                let grouped = {};
                filtered.forEach(exh => {
                    const cat = exh.category || 'General';
                    if (!grouped[cat]) grouped[cat] = [];
                    grouped[cat].push(exh);
                });

                let html = '<div class="space-y-10">';
                Object.keys(grouped).forEach(cat => {
                    html += `
                        <div>
                            <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-[#4A22E0] rounded-full"></span> ${cat} (${grouped[cat].length})
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    `;
                    grouped[cat].forEach(exh => {
                        html += getExhibitorCardHtml(exh);
                    });
                    html += '</div></div>';
                });
                html += '</div>';
                wrapper.innerHTML = html;
            } else if (activeTab === 'az') {
                // Group by Starting Letter
                let grouped = {};
                filtered.forEach(exh => {
                    const firstLetter = (exh.name || 'A').charAt(0).toUpperCase();
                    if (!grouped[firstLetter]) grouped[firstLetter] = [];
                    grouped[firstLetter].push(exh);
                });

                // Sort starting letters alphabetically
                const sortedLetters = Object.keys(grouped).sort();

                let html = '<div class="space-y-10">';
                sortedLetters.forEach(letter => {
                    html += `
                        <div>
                            <h3 class="font-bold text-[#1E1B4B] text-[18px] mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                                <span class="text-primary-600 font-extrabold">${letter}</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    `;
                    grouped[letter].forEach(exh => {
                        html += getExhibitorCardHtml(exh);
                    });
                    html += '</div></div>';
                });
                html += '</div>';
                wrapper.innerHTML = html;
            }
        }

        // Helper to generate the exact premium card HTML matching original style
        function getExhibitorCardHtml(exh) {
            const isBookmarkedExh = userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id);
            const bookmarkIconClass = isBookmarkedExh ? 'ph-fill ph-bookmark-simple text-primary-600' : 'ph ph-bookmark-simple text-primary-500 hover:text-primary-700';
            
            return `
                <div onclick="window.location.href='exhibitor-details.html?id=${exh.id}'" class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-all duration-300 relative cursor-pointer hover:-translate-y-1">
                    <div class="flex justify-between items-center mb-4">
                        <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">${exh.booth_number || 'Booth'}</div>
                        <div class="p-1 cursor-pointer" onclick="event.stopPropagation(); toggleExhibitorBookmark(this, ${exh.id})">
                            <i class="${bookmarkIconClass} text-[18px]"></i>
                        </div>
                    </div>
                    <div class="flex gap-3 mb-4">
                        <div class="w-12 h-12 rounded-lg ${exh.logo_color || 'bg-primary-600'} flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-[18px] mt-1">
                            ${exh.logo_text || 'EX'}
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1 truncate">${exh.name}</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-snug line-clamp-3">${exh.description || ''}</p>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">${exh.category || 'General'}</span>
                    </div>
                </div>
            `;
        }

        // Helper to toggle exhibitor bookmark
        async function toggleExhibitorBookmark(iconEl, exhibitorId) {
            if (!bookingId) {
                alert("Please select a pass and register first to save items to your visits!");
                window.location.href = "pass-selection.html";
                return;
            }
            const res = await ExhibitionAPI.toggleBookmark(bookingId, 'exhibitor', exhibitorId);
            
            // Update local userBookmarks reference
            if (res.status === 'added') {
                userBookmarks.push({ bookmarkable_type: 'exhibitor', bookmarkable_id: exhibitorId });
            } else {
                userBookmarks = userBookmarks.filter(b => !(b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exhibitorId));
            }

            const icon = iconEl.querySelector('i') || iconEl;
            if (res.status === 'added') {
                icon.className = 'ph-fill ph-bookmark-simple text-primary-600 text-[18px]';
            } else {
                icon.className = 'ph ph-bookmark-simple text-primary-500 hover:text-primary-700 text-[18px]';
            }

            // If we are in the Featured tab, re-render immediately so the card disappears/refreshes
            if (activeTab === 'featured') {
                renderExhibitors();
            }
        }

        document.addEventListener("DOMContentLoaded", async () => {
            const data = await ExhibitionAPI.getHall(hallId);
            if (!data) return;

            // Set back link
            const backLink = document.getElementById('dyn-back-link');
            if (backLink) {
                backLink.href = `hall-details.html?id=${hallId}`;
                backLink.innerHTML = `<i class="ph-bold ph-arrow-left"></i> Back to ${data.badge}`;
            }

            // Populate header elements
            const badgeEl = document.querySelector('main span.tracking-wide');
            if (badgeEl) badgeEl.textContent = data.badge;

            const titleEl = document.querySelector('main h1');
            if (titleEl) titleEl.textContent = data.title;

            const subtitleEl = document.querySelector('main p.text-gray-500');
            if (subtitleEl) subtitleEl.textContent = data.subtitle;

            const imgEl = document.querySelector('main img[alt="Hall"]');
            if (imgEl) imgEl.src = data.image_url || data.img;

            // Populate stats
            const statExh = document.querySelector('main div.flex-col:nth-child(1) span');
            if (statExh) statExh.textContent = data.exhibitors_count || data.exhibitors;

            const statArea = document.querySelector('main div.flex-col:nth-child(3) span');
            if (statArea) statArea.textContent = data.area;

            const statBooths = document.querySelector('main div.flex-col:nth-child(4) span');
            if (statBooths) statBooths.textContent = data.booths_count || data.booths;

            // Load bookmarks and update UI
            if (bookingId) {
                userBookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                isBookmarked = userBookmarks.some(b => b.bookmarkable_type === 'hall' && b.bookmarkable_id === hallId);
                updateBookmarkUI();
            }

            // Fetch exhibitors for active exhibition
            const allExhibitors = await ExhibitionAPI.getExhibitors(activeExhibitionId);
            hallExhibitors = allExhibitors.filter(exh => 
                exh.hall_name && exh.hall_name.toLowerCase().includes(data.badge.toLowerCase())
            );

            // Initial render
            renderExhibitors();
        });
    </script>
</body>
</html>
