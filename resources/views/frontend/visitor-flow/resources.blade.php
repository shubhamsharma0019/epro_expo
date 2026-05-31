<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Resources</title>
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
            
            <div class="mb-6">
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Resources</h1>
                <p class="text-[13px] text-gray-500 font-medium">Download brochures, documents and other resources from the exhibitors.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 max-w-[1500px]">
                
                <!-- Left: Main Content Area -->
                <div class="flex-1 flex flex-col min-w-0 w-full">
                    
                    <!-- Company Info Bar -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-4 shadow-sm flex items-center gap-4 mb-6">
                        <div id="resources-comp-logo" class="w-12 h-12 rounded-lg bg-[#0F172A] relative flex flex-col items-center justify-center shrink-0 shadow-inner">
                            <div class="text-blue-500 text-[18px] font-bold leading-none">TN</div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-1.5">
                                <h2 id="resources-comp-name" class="text-[15px] font-bold text-[#1E1B4B] tracking-tight">TechNext Solutions Pvt. Ltd.</h2>
                                <span class="bg-[#0D9488]/10 text-[#0D9488] text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Featured Exhibitor</span>
                            </div>
                            
                            <div class="flex items-center gap-4 text-[11px] font-medium text-gray-600">
                                <div>
                                    <span id="resources-comp-category" class="bg-primary-50 text-primary-600 font-bold px-2 py-0.5 rounded mr-3">AI & Automation</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-map-pin text-primary-500 text-[14px]"></i>
                                    <span id="resources-comp-booth" class="text-[#1E1B4B]">Hall 1 – AI & IA, Booth 101</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-globe text-primary-500 text-[14px]"></i>
                                    <a id="resources-comp-website" href="#" class="text-gray-500 hover:text-primary-600 transition-colors">www.technext.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <a id="resources-comp-profile-link" href="exhibitor-details.html" class="border border-gray-200 text-[#4A22E0] hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                View Company Profile <i class="ph-bold ph-arrow-up-right"></i>
                            </a>
                            <button class="w-9 h-9 rounded-lg border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 flex items-center justify-center transition-colors shadow-sm">
                                <i class="ph-bold ph-dots-three-vertical text-[18px]"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex flex-col lg:flex-row gap-8 border-b border-gray-200 mb-6 px-2">
                        <button class="text-[#4A22E0] font-bold text-[13px] pb-3 border-b-2 border-[#4A22E0]">All Resources (12)</button>
                        <button class="text-gray-500 font-medium text-[13px] pb-3 border-b-2 border-transparent hover:text-gray-900 transition-colors">Brochures (5)</button>
                        <button class="text-gray-500 font-medium text-[13px] pb-3 border-b-2 border-transparent hover:text-gray-900 transition-colors">Datasheets (4)</button>
                        <button class="text-gray-500 font-medium text-[13px] pb-3 border-b-2 border-transparent hover:text-gray-900 transition-colors">Case Studies (2)</button>
                        <button class="text-gray-500 font-medium text-[13px] pb-3 border-b-2 border-transparent hover:text-gray-900 transition-colors">Videos (3)</button>
                        <button class="text-gray-500 font-medium text-[13px] pb-3 border-b-2 border-transparent hover:text-gray-900 transition-colors">Whitepapers (2)</button>
                    </div>

                    <!-- Search and Filters Bar -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="relative w-full max-w-[300px]">
                            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                            <input type="text" placeholder="Search resources..." class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-[12px] font-medium focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm">
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="relative w-[160px]">
                                <select class="w-full border border-gray-200 rounded-lg pl-4 pr-8 py-2 text-[12px] font-bold text-[#1E1B4B] appearance-none focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm cursor-pointer">
                                    <option>All Types</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[14px] pointer-events-none"></i>
                            </div>
                            <div class="relative w-[160px]">
                                <select class="w-full border border-gray-200 rounded-lg pl-4 pr-8 py-2 text-[12px] font-bold text-[#1E1B4B] appearance-none focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm cursor-pointer">
                                    <option>Sort by: Latest</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[14px] pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Resources List -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-6 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <!-- Header Row -->
                        <div class="grid grid-cols-[3fr_1fr_1fr_1fr_auto] gap-4 p-4 border-b border-gray-100 bg-gray-50/50 text-[11px] font-bold text-[#1E1B4B] uppercase tracking-wider">
                            <div class="pl-2">Resource Name</div>
                            <div>Type</div>
                            <div>Size</div>
                            <div>Updated On</div>
                            <div class="w-10"></div>
                        </div>

                        <!-- Dynamic Rows Container -->
                        <div id="resources-list-rows">
                            <div class="text-[12px] text-gray-500 text-center py-8">Loading resources...</div>
                        </div>
                    </div>

                    <!-- Load More Button -->
                    <div class="flex justify-center pb-12">
                        <button class="border border-gray-200 text-[#4A22E0] bg-white hover:bg-primary-50 px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                            Load More Resources <i class="ph ph-caret-down"></i>
                        </button>
                    </div>

                </div>

                <!-- Right Sidebar: Company Info Area -->
                <div class="w-full lg:w-[320px] shrink-0 flex flex-col gap-6 pb-12">
                    
                    <!-- About the Company Card -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-5">About the Company</h3>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <div id="resources-about-logo" class="w-12 h-12 bg-[#0F172A] rounded-xl flex items-center justify-center shadow-sm shrink-0">
                                <div class="text-blue-500 text-[18px] font-bold">TN</div>
                            </div>
                            <h4 id="resources-about-name" class="font-bold text-[#1E1B4B] text-[14px] leading-tight">TechNext Solutions Pvt. Ltd.</h4>
                        </div>
                        
                        <p id="resources-about-desc" class="text-[12px] text-gray-600 leading-relaxed mb-6">Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.</p>
                        
                        <div class="bg-gray-50/50 rounded-[16px] p-4 flex flex-col gap-4 border border-gray-100 mb-5">
                            <div class="flex items-center gap-3">
                                <div class="text-primary-500"><i class="ph-bold ph-users text-[18px]"></i></div>
                                <div>
                                    <div id="resources-about-employees" class="text-[12px] font-bold text-[#1E1B4B]">45+</div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Employees</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-primary-500"><i class="ph-bold ph-calendar-blank text-[18px]"></i></div>
                                <div>
                                    <div id="resources-about-founded" class="text-[12px] font-bold text-[#1E1B4B]">2018</div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Founded</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span id="resources-about-flag"><img src="https://flagcdn.com/in.svg" alt="India" class="w-5 h-3.5 object-cover rounded-sm border border-gray-200"></span>
                                <div>
                                    <div id="resources-about-hq" class="text-[12px] font-bold text-[#1E1B4B]">India</div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Headquarters</div>
                                </div>
                            </div>
                        </div>

                        <a id="resources-about-profile-link" href="exhibitor-details.html" class="w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-xl font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            View Company Profile <i class="ph-bold ph-arrow-up-right"></i>
                        </a>
                    </div>

                    <!-- Need Help Card -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2">Need Help?</h3>
                        <p class="text-[12px] text-gray-500 mb-5">Can't find what you're looking for?</p>
                        
                        <button class="w-full border border-[#4A22E0] text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm mb-4">
                            <i class="ph-bold ph-chat-circle-text text-[16px]"></i> Start Live Chat
                        </button>

                        <div class="text-[11px] text-gray-500 font-medium">
                            <p class="mb-1">Our team is here to help you.</p>
                            <p>Mon - Fri, 9:00 AM to 6:00 PM (IST)</p>
                        </div>
                    </div>

                </div>

            </div>
            
        </div>
    </main>

    <script src="exhibition-api.js"></script>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            let exhibitorId = urlParams.get('id') || '101'; // Default to first seeded exhibitor

            // Fetch Exhibitor Details
            try {
                const exh = await ExhibitionAPI.getExhibitor(exhibitorId);
                if (exh) {
                    // Update header bar
                    const logoEl = document.getElementById('resources-comp-logo');
                    const nameEl = document.getElementById('resources-comp-name');
                    const catEl = document.getElementById('resources-comp-category');
                    const boothEl = document.getElementById('resources-comp-booth');
                    const webEl = document.getElementById('resources-comp-website');
                    const linkEl = document.getElementById('resources-comp-profile-link');

                    if (nameEl) nameEl.textContent = exh.name;
                    if (catEl) {
                        catEl.textContent = exh.category;
                        catEl.className = `bg-primary-50 text-primary-600 font-bold px-2 py-0.5 rounded mr-3`;
                    }
                    if (boothEl) boothEl.textContent = `${exh.hall_name || 'Hall 1'}, ${exh.booth_number || 'Booth'}`;
                    if (webEl) {
                        webEl.textContent = exh.website || 'Website';
                        webEl.href = exh.website ? (exh.website.startsWith('http') ? exh.website : 'https://' + exh.website) : '#';
                    }
                    if (logoEl) {
                        logoEl.className = `w-12 h-12 rounded-lg relative flex flex-col items-center justify-center shrink-0 shadow-inner ${exh.logo_color || 'bg-[#0F172A]'}`;
                        logoEl.innerHTML = `<div class="text-white text-[18px] font-bold leading-none">${exh.logo_text || 'EX'}</div>`;
                    }
                    if (linkEl) {
                        linkEl.href = `exhibitor-details.html?id=${exh.id}`;
                    }

                    // Update About card
                    const abNameEl = document.getElementById('resources-about-name');
                    const abLogoEl = document.getElementById('resources-about-logo');
                    const abDescEl = document.getElementById('resources-about-desc');
                    const abEmpEl = document.getElementById('resources-about-employees');
                    const abFoundEl = document.getElementById('resources-about-founded');
                    const abHqEl = document.getElementById('resources-about-hq');
                    const abFlagEl = document.getElementById('resources-about-flag');
                    const abLinkEl = document.getElementById('resources-about-profile-link');

                    if (abNameEl) abNameEl.textContent = exh.name;
                    if (abLogoEl) {
                        abLogoEl.className = `w-12 h-12 rounded-xl flex items-center justify-center shadow-sm shrink-0 ${exh.logo_color || 'bg-[#0F172A]'}`;
                        abLogoEl.innerHTML = `<div class="text-white text-[18px] font-bold leading-none">${exh.logo_text || 'EX'}</div>`;
                    }
                    if (abDescEl) abDescEl.textContent = exh.description;
                    if (abEmpEl) abEmpEl.textContent = exh.employee_count || '50+';
                    if (abFoundEl) abFoundEl.textContent = exh.founded_year || '2019';
                    if (abHqEl) abHqEl.textContent = exh.country || 'India';
                    if (abFlagEl && exh.country) {
                        const countryLower = exh.country.toLowerCase();
                        let flagUrl = 'https://flagcdn.com/in.svg'; // Default
                        if (countryLower.includes('united states') || countryLower.includes('us')) {
                            flagUrl = 'https://flagcdn.com/us.svg';
                        } else if (countryLower.includes('united kingdom') || countryLower.includes('uk')) {
                            flagUrl = 'https://flagcdn.com/gb.svg';
                        } else if (countryLower.includes('germany')) {
                            flagUrl = 'https://flagcdn.com/de.svg';
                        }
                        abFlagEl.innerHTML = `<img src="${flagUrl}" alt="${exh.country}" class="w-5 h-3.5 object-cover rounded-sm border border-gray-200">`;
                    }
                    if (abLinkEl) {
                        abLinkEl.href = `exhibitor-details.html?id=${exh.id}`;
                    }

                    // Fetch and Render Products/Resources
                    const products = await ExhibitionAPI.getProducts(exhibitorId);
                    const rowsContainer = document.getElementById('resources-list-rows');
                    
                    if (rowsContainer) {
                        if (!products || products.length === 0) {
                            rowsContainer.innerHTML = `<div class="text-[12px] text-gray-500 text-center py-8">No resources available for this exhibitor.</div>`;
                        } else {
                            rowsContainer.innerHTML = '';
                            products.forEach(p => {
                                // Determine document type
                                const docType = getDocType(p.document_url);
                                let badgeColorClass = 'bg-purple-50 text-purple-600';
                                if (docType === 'Datasheet') badgeColorClass = 'bg-green-50 text-green-600';
                                else if (docType === 'Whitepaper') badgeColorClass = 'bg-yellow-50 text-yellow-600';
                                else if (docType === 'API Guide') badgeColorClass = 'bg-blue-50 text-blue-600';

                                // Generate static/mock metadata values
                                const randomSizes = ['1.5 MB', '2.4 MB', '3.1 MB', '1.2 MB', '0.8 MB', '4.2 MB'];
                                const randomSize = randomSizes[p.id % randomSizes.length];
                                
                                const updateDate = new Date(p.updated_at || p.created_at || Date.now());
                                const formattedDate = updateDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                                const rowHtml = `
                                <div class="grid grid-cols-[3fr_1fr_1fr_1fr_auto] gap-4 p-4 border-b border-gray-100 items-center hover:bg-gray-50 transition-colors group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-10 rounded bg-[#020617] relative overflow-hidden shrink-0 flex items-center justify-center shadow-sm">
                                            <div class="absolute inset-0 opacity-40 bg-cover bg-center mix-blend-luminosity" style="background-image: url('${p.image_url || 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=100&auto=format&fit=crop'}')"></div>
                                            <div class="text-white text-[10px] font-bold relative z-10">${exh.logo_text || 'EX'}</div>
                                        </div>
                                        <div>
                                            <h3 class="text-[13px] font-bold text-[#1E1B4B] mb-0.5 group-hover:text-primary-600 transition-colors cursor-pointer">${p.name}</h3>
                                            <p class="text-[11px] text-gray-500 line-clamp-1">${p.description || ''}</p>
                                        </div>
                                    </div>
                                    <div><span class="${badgeColorClass} text-[10px] font-bold px-2 py-1 rounded">${docType}</span></div>
                                    <div class="text-[12px] text-gray-500 font-medium">${randomSize}</div>
                                    <div class="text-[12px] text-gray-500 font-medium">${formattedDate}</div>
                                    <div class="w-10 flex justify-end">
                                        <a href="${p.document_url || '#'}" download class="text-primary-600 hover:bg-primary-50 w-8 h-8 rounded flex items-center justify-center transition-colors"><i class="ph-bold ph-download-simple text-[16px]"></i></a>
                                    </div>
                                </div>
                                `;
                                rowsContainer.insertAdjacentHTML('beforeend', rowHtml);
                            });
                        }
                    }
                }
            } catch (err) {
                console.error('Error loading resources page details:', err);
            }

            function getDocType(url) {
                if (!url) return 'Brochure';
                const lower = url.toLowerCase();
                if (lower.includes('spec') || lower.includes('datasheet')) return 'Datasheet';
                if (lower.includes('guide') || lower.includes('api')) return 'API Guide';
                if (lower.includes('whitepaper')) return 'Whitepaper';
                if (lower.includes('video') || lower.includes('.mp4')) return 'Video';
                return 'Brochure';
            }
        });
    </script>
</body>
</html>
