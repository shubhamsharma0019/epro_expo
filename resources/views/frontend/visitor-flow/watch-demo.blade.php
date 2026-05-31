<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Watch Demo</title>
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
            
            <a id="wd-back-link" href="exhibitor-details.html" class="inline-flex items-center gap-2 text-[#4A22E0] hover:text-[#3D1CBA] font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Company
            </a>
            
            <div class="mb-6">
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Watch Demo</h1>
                <p class="text-[13px] text-gray-500 font-medium">Explore product demos and presentations from the exhibitor.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 max-w-[1500px]">
                
                <!-- Left: Video Area -->
                <div class="flex-1 flex flex-col min-w-0 w-full">
                    
                    <!-- Company Info Bar -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-4 shadow-sm flex items-center gap-4 mb-6">
                        <div id="wd-comp-logo-container" class="w-12 h-12 rounded-lg bg-[#0F172A] relative flex flex-col items-center justify-center shrink-0 shadow-inner">
                            <div id="wd-comp-logo-text" class="text-blue-500 text-[18px] font-bold leading-none">TN</div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-1.5">
                                <h2 id="wd-comp-name" class="text-[15px] font-bold text-[#1E1B4B] tracking-tight">Loading...</h2>
                                <span class="bg-[#0D9488]/10 text-[#0D9488] text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Featured Exhibitor</span>
                            </div>
                            
                            <div class="flex items-center gap-4 text-[11px] font-medium text-gray-600">
                                <div>
                                    <span id="wd-comp-category" class="bg-primary-50 text-primary-600 font-bold px-2 py-0.5 rounded mr-3">-</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-map-pin text-primary-500 text-[14px]"></i>
                                    <span id="wd-comp-location-booth" class="text-[#1E1B4B]">-</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-globe text-primary-500 text-[14px]"></i>
                                    <a id="wd-comp-website" href="#" class="text-gray-500 hover:text-primary-600 transition-colors">-</a>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <a id="wd-btn-view-profile" href="exhibitor-details.html" class="border border-gray-200 text-[#4A22E0] hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                View Company Profile <i class="ph-bold ph-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Video Player Container -->
                    <div class="border border-gray-100 rounded-[20px] bg-[#020617] overflow-hidden shadow-md relative mb-6">
                        <!-- Video Element -->
                        <div class="aspect-video w-full relative">
                            <video id="wd-video-element" class="w-full h-full object-cover" controls src="" poster=""></video>
                        </div>
                    </div>

                    <!-- Video Meta Data & Actions -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm mb-8 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex flex-col lg:flex-row items-start justify-between gap-8 mb-5">
                            <div>
                                <span id="wd-video-badge" class="bg-[#4A22E0] text-white text-[11px] font-bold px-2.5 py-1 rounded inline-block mb-3">Featured Demo</span>
                                <h2 id="wd-video-title" class="text-[20px] font-bold text-[#1E1B4B] mb-3">Product Demo</h2>
                                <p id="wd-video-desc" class="text-[13px] text-gray-600 leading-relaxed max-w-[700px]"></p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <button class="border border-gray-200 text-[#4A22E0] hover:bg-primary-50 px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <i class="ph-bold ph-bookmark-simple text-[18px]"></i> Save for Later
                                </button>
                                <button id="wd-btn-request-meeting" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <i class="ph-bold ph-calendar-plus text-[18px]"></i> Request Meeting
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-6 text-[12px] font-medium text-gray-500">
                            <div id="wd-video-duration" class="flex items-center gap-1.5"><i class="ph-bold ph-clock text-[16px]"></i> -</div>
                            <div id="wd-video-date" class="flex items-center gap-1.5"><i class="ph-bold ph-calendar-blank text-[16px]"></i> -</div>
                            <div id="wd-video-views" class="flex items-center gap-1.5"><i class="ph-bold ph-eye text-[16px]"></i> -</div>
                        </div>
                    </div>

                    <!-- More Demos Section -->
                    <div class="pb-12">
                        <div class="flex items-center justify-between mb-5">
                            <h3 id="wd-more-demos-heading" class="font-bold text-[#1E1B4B] text-[16px]">More Demos</h3>
                        </div>

                        <div id="wd-more-demos-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <!-- Loaded dynamically -->
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar: Details Area -->
                <div class="w-full lg:w-[320px] shrink-0 flex flex-col gap-6 pb-12">
                    
                    <!-- Demo Details Card -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5 border-b border-gray-100 pb-4">Presenter Details</h3>
                        
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-user text-[16px]"></i></div>
                                <div>
                                    <div class="text-[11px] text-gray-500 font-bold mb-0.5">Presented by</div>
                                    <div id="wd-presenter-name" class="text-[12px] font-bold text-[#1E1B4B]">-</div>
                                    <div id="wd-presenter-title" class="text-[10px] text-gray-500 font-medium">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About This Demo -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-3">About This Demo</h3>
                        <p id="wd-about-desc" class="text-[12px] text-gray-600 leading-relaxed mb-3">-</p>
                    </div>

                    <!-- Need Help -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Need Help?</h3>
                        <p class="text-[11px] text-gray-500 font-medium mb-4">Our team is here to help you.</p>
                        <button class="w-full border border-[#4A22E0] text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph-bold ph-chat-circle-text text-[16px]"></i> Start Live Chat
                        </button>
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
            const exhibitorId = urlParams.get('id') || '101';

            // Set up dynamic back link and view profile link
            const backLink = document.getElementById('wd-back-link');
            if (backLink) backLink.href = `exhibitor-details.html?id=${exhibitorId}`;

            const viewProfileLink = document.getElementById('wd-btn-view-profile');
            if (viewProfileLink) viewProfileLink.href = `exhibitor-details.html?id=${exhibitorId}`;

            // Fetch exhibitor details dynamically
            const exhibitor = await ExhibitionAPI.getExhibitor(exhibitorId);
            if (!exhibitor) return;

            // Split name to form a clean subtitle representation
            const nameWords = exhibitor.name.split(' ');
            const sub = nameWords[0] || '';
            const sub2 = nameWords.slice(1).join(' ') || '';

            // Populate exhibitor headers
            document.getElementById('wd-comp-name').textContent = exhibitor.name;
            document.getElementById('wd-comp-category').textContent = exhibitor.category;
            document.getElementById('wd-comp-location-booth').textContent = `${exhibitor.hall_name || 'Hall 1'}, ${exhibitor.booth_number || 'Booth 101'}`;
            
            const websiteEl = document.getElementById('wd-comp-website');
            if (websiteEl) {
                websiteEl.textContent = exhibitor.website || 'www.exhibitor.com';
                websiteEl.href = exhibitor.website ? (exhibitor.website.startsWith('http') ? exhibitor.website : 'https://' + exhibitor.website) : '#';
            }

            document.getElementById('wd-comp-logo-text').innerHTML = exhibitor.logo_text || sub.substring(0, 2).toUpperCase();
            if (exhibitor.logo_color) {
                document.getElementById('wd-comp-logo-container').className = 'w-12 h-12 rounded-lg relative flex flex-col items-center justify-center shrink-0 shadow-inner ' + exhibitor.logo_color;
            }

            // Bind request meeting button
            const requestMtgBtn = document.getElementById('wd-btn-request-meeting');
            if (requestMtgBtn) {
                requestMtgBtn.onclick = () => {
                    window.location.href = `request-meeting.html?id=${exhibitorId}`;
                };
            }

            // Fetch videos for this exhibitor
            const videos = await ExhibitionAPI.getExhibitorVideos(exhibitorId);
            const videoEl = document.getElementById('wd-video-element');

            function playVideo(video) {
                if (!video) return;
                
                // Update video sources
                videoEl.src = video.video_url || 'https://www.w3schools.com/html/mov_bbb.mp4';
                videoEl.poster = video.thumbnail_url || '';
                videoEl.load();

                // Update text elements
                document.getElementById('wd-video-title').textContent = video.title;
                document.getElementById('wd-video-desc').textContent = video.description;
                document.getElementById('wd-video-duration').innerHTML = `<i class="ph-bold ph-clock text-[16px]"></i> ${video.duration} mins`;
                document.getElementById('wd-video-date').innerHTML = `<i class="ph-bold ph-calendar-blank text-[16px]"></i> ${video.published_date}`;
                document.getElementById('wd-video-views').innerHTML = `<i class="ph-bold ph-eye text-[16px]"></i> ${video.views_count.toLocaleString()} Views`;
                document.getElementById('wd-video-badge').textContent = video.badge || 'Featured Demo';

                document.getElementById('wd-presenter-name').textContent = video.presenter_name || exhibitor.rep_name || 'Rahul Sharma';
                document.getElementById('wd-presenter-title').textContent = video.presenter_title || exhibitor.rep_title || 'Representative';
                document.getElementById('wd-about-desc').textContent = video.description;
            }

            // Load and render "More Demos" list
            const listContainer = document.getElementById('wd-more-demos-list');
            const headingEl = document.getElementById('wd-more-demos-heading');
            if (headingEl) {
                headingEl.textContent = `More Demos from ${exhibitor.name}`;
            }

            if (listContainer && videos && videos.length > 0) {
                listContainer.innerHTML = '';
                videos.forEach((v, index) => {
                    const card = document.createElement('div');
                    card.className = 'group cursor-pointer';
                    card.onclick = () => {
                        playVideo(v);
                        // Scroll up to player smoothly
                        document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
                    };
                    card.innerHTML = `
                        <div class="aspect-video bg-[#020617] rounded-xl relative overflow-hidden mb-3">
                            <div class="absolute inset-0 opacity-40 bg-cover bg-center group-hover:scale-105 transition-transform duration-500" style="background-image: url('${v.thumbnail_url || 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=400&auto=format&fit=crop'}')"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white group-hover:bg-[#4A22E0] group-hover:border-[#4A22E0] transition-all">
                                    <i class="ph-fill ph-play text-[18px] ml-1"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">${v.duration}</div>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 leading-tight group-hover:text-primary-600 transition-colors line-clamp-2">${v.title}</h4>
                        <div class="flex items-center gap-2 text-[10px] font-medium text-gray-500">
                            <span>${v.published_date}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span>${v.views_count.toLocaleString()} Views</span>
                        </div>
                    `;
                    listContainer.appendChild(card);
                });

                // Play first video by default
                playVideo(videos[0]);
            } else if (listContainer) {
                listContainer.innerHTML = '<div class="col-span-4 text-gray-400 text-sm font-medium py-6 text-center">No demo videos available for this exhibitor.</div>';
            }
        });
    </script>
</body>
</html>
