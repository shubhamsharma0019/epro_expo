const sidebarHTML = `
<aside class="fixed inset-y-0 left-0 z-20 flex h-screen w-[260px] flex-col justify-between overflow-y-auto border-r border-gray-100 bg-white px-5 py-4 shadow-sm">
    <div>
        <div class="mb-3 flex h-[68px] shrink-0 items-center px-3">
            <a href="javascript:void(0)" class="flex items-center">
                <svg viewBox="0 0 160 32" class="h-8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <!-- Orange Crescent -->
                  <path d="M10 16C10 11.5 12 7.5 15 5C10.5 6.5 7 10.5 7 16C7 21.5 10.5 25.5 15 27C12 24.5 10 20.5 10 16Z" fill="#F97316"/>
                  <!-- Purple Circle with cutout -->
                  <path d="M16 4C22.627 4 28 9.373 28 16C28 22.627 22.627 28 16 28C14.5 28 13.1 27.7 11.8 27.1C13.6 24.9 14.8 22.1 14.8 19V14.5C14.8 13.1 15.8 12 17.2 12H21C21.5 10.5 20 9 18 9C16.5 9 15 10 14.5 11.5C13.5 11.5 12.5 11.5 11.5 11.5C12 8.5 14.5 6 18 6C20.5 6 22.5 7.5 23.5 9.5C24.5 11 24.5 13 23.5 14.5H17.2C16.6 14.5 16 15.1 16 15.8V19C16 21.5 14.5 23.8 12.3 25.1C13.4 25.6 14.7 26 16 26C21.5 26 26 21.5 26 16C26 10.5 21.5 6 16 6C15.2 6 14.4 6.1 13.7 6.3C14.1 5.5 15 4.9 16 4Z" fill="#3D1B9B"/>
                  <path d="M17.2 14.5C16.6 14.5 16 15.1 16 15.8V19H14.8V14.5C14.8 13.1 15.8 12 17.2 12H21V14.5H17.2Z" fill="white"/>
                  <!-- Text 'epro' -->
                  <text x="36" y="23" fill="#3D1B9B" font-family="Arial, sans-serif" font-weight="bold" font-size="22" letter-spacing="-0.5">epro</text>
                  <!-- Text 'expo' -->
                  <text x="82" y="23" fill="#0EA5E9" font-family="Arial, sans-serif" font-weight="bold" font-size="22" letter-spacing="-0.5">expo</text>
                </svg>
            </a>
        </div>
        <!-- Menu Items -->
        <nav id="sidebar-nav" class="flex-1 space-y-1.5 pb-3 overflow-y-auto">
            <a href="javascript:void(0)" data-page="index" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="javascript:void(0)" data-page="pavilions" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Pavilions
            </a>
            <a href="javascript:void(0)" data-page="halls" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Halls
            </a>
            <a href="javascript:void(0)" data-page="booth-search" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Book Booths
            </a>
            <a href="javascript:void(0)" data-page="booking-details" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                My Bookings
            </a>
            <a href="javascript:void(0)" data-page="leads" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Leads
            </a>
            <a href="javascript:void(0)" data-page="add-products" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Manage Booths / Edit Booths
            </a>
            <a href="javascript:void(0)" data-page="media-gallery" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Meeting Request
            </a>
            <a href="javascript:void(0)" data-page="team-members" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Analytics
            </a>
            <a href="javascript:void(0)" data-page="meetings" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Payments / Invoices
            </a>
            <a href="javascript:void(0)" data-page="sessions" class="flex items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                Notification
            </a>
            <a href="javascript:void(0)" data-page="preview" class="hidden items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Preview Booth
            </a>
            <a href="javascript:void(0)" data-page="publish" class="hidden items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349a5.259 5.259 0 00-1.542-3.717l-2.718-2.718a5.25 5.25 0 00-3.712-1.538H6.75A3.375 3.375 0 003.375 4.5v15m10.5-2.81v-4.02a1.5 1.5 0 011.5-1.5h2.52a1.5 1.5 0 011.5 1.5v4.02"></path></svg>
                Publish Booth
            </a>
            
            <div class="mt-8 mb-4 border-t border-gray-100"></div>
            
            <a href="javascript:void(0)" data-page="support" class="hidden items-center px-5 py-3 text-gray-900 hover:bg-gray-50 hover:text-[#3b18ff] transition-colors rounded-xl font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Support
            </a>
        </nav>
    </div>
    <div class="pt-2">
        <a href="javascript:void(0)" class="flex items-center px-5 py-3 rounded-xl hover:bg-gray-50 text-gray-900 transition-colors font-medium text-base">
            <svg class="w-[20px] h-[20px] mr-4 text-[#3D1B9B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </a>
    </div>
</aside>
`;

const topnavHTML = `
<header class="h-[80px] bg-white border-b border-gray-100 fixed top-0 right-0 left-[260px] flex items-center justify-between px-8 z-10">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>
    <div class="flex items-center space-x-6">
        <button type="button" class="text-gray-500 hover:text-gray-900 transition-colors">
            <i class="ph ph-magnifying-glass text-2xl"></i>
        </button>
        <button type="button" class="text-gray-500 hover:text-gray-900 transition-colors relative">
            <i class="ph ph-bell text-2xl"></i>
            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
        </button>
        <div class="flex items-center cursor-pointer">
            <img src="/assets/exhibition/images/avatar.png" alt="John Doe" class="w-9 h-9 rounded-full object-cover">
            <span class="ml-3 font-semibold text-gray-900 text-sm">John Doe</span>
            <i class="ph ph-caret-down text-gray-500 ml-2"></i>
        </div>
    </div>
</header>
`;

document.addEventListener("DOMContentLoaded", () => {
    const sidebarContainer = document.getElementById("sidebar-container");
    const topnavContainer = document.getElementById("topnav-container");
    
    if (sidebarContainer) sidebarContainer.innerHTML = sidebarHTML;
    if (topnavContainer) topnavContainer.innerHTML = topnavHTML;

    // Highlight active sidebar item
    const path = window.location.pathname;
    const page = path.split("/").pop().replace(".html", "");
    
    // For specific pages mapped to sidebar
    let activeKey = "";
    if(path.includes("/company/bookings")) activeKey = "booking-details";
    else if(page.includes("setup") || page.includes("profile") || page.includes("branding") || page.includes("products") || page.includes("upload")) {
        activeKey = "add-products";
    }

    if(activeKey) {
        const activeLink = document.querySelector(`#sidebar-nav a[data-page="${activeKey}"]`);
        if(activeLink) {
            activeLink.classList.remove("text-[#6B7280]");
            activeLink.classList.add("text-[#3D1B9B]");
            // make the text bold
            activeLink.style.fontWeight = "700";
            // keep the svg the same color, it's already #3D1B9B
        }
    }
    
    renderSetupBooth();
});

// --- Dynamic State Management for Booth Setup ---
const stepsData = [
    { id: 1, title: "Company Profile", desc: "Add your company details and contact information.", link: "/company/booth-setup/company-profile" },
    { id: 2, title: "Booth Branding", desc: "Customize your booth look and feel.", link: "/company/booth-setup/branding" },
    { id: 3, title: "Products", desc: "Add and showcase your products or services.", link: "/company/booth-setup/products" },
    { id: 4, title: "Documents", desc: "Upload brochures, certificates and other documents.", link: "/company/booth-setup/documents" },
    { id: 5, title: "Catalogues", desc: "Upload your digital catalogues and lookbooks.", link: "/company/booth-setup/catalogues" },
    { id: 6, title: "Media Gallery", desc: "Add images, videos and presentations.", link: "#" },
    { id: 7, title: "Team Members", desc: "Add team members and their roles.", link: "#" },
    { id: 8, title: "Meetings", desc: "Enable meetings and connection preferences.", link: "#" },
    { id: 9, title: "Sessions", desc: "Add sessions, webinars or demos.", link: "#" },
    { id: 10, title: "Preview", desc: "Preview your booth before publishing.", link: "#" },
    { id: 11, title: "Publish Booth", desc: "Go live and start connecting with attendees.", link: "#" }
];

function initBoothState() {
    if (!localStorage.getItem('boothState')) {
        const initialState = {};
        for(let i=1; i<=11; i++) {
            initialState[i] = (i === 1) ? 'in_progress' : 'pending';
        }
        localStorage.setItem('boothState', JSON.stringify(initialState));
    }
}

function getBoothState() {
    initBoothState();
    return JSON.parse(localStorage.getItem('boothState'));
}

window.markStepCompleted = function(stepId) {
    const state = getBoothState();
    state[stepId] = 'completed';
    if(stepId < 11) {
        if(state[stepId + 1] === 'pending') {
            state[stepId + 1] = 'in_progress';
        }
    }
    localStorage.setItem('boothState', JSON.stringify(state));
};

window.resetBoothState = function() {
    localStorage.removeItem('boothState');
    location.reload();
};

function renderSetupBooth() {
    const container = document.getElementById('steps-list-container');
    if (!container) return;
    
    const state = getBoothState();
    let html = '';
    let completedCount = 0;
    
    stepsData.forEach((step, index) => {
        const stepState = state[step.id];
        if (stepState === 'completed') completedCount++;
        
        const isLast = index === stepsData.length - 1;
        const borderBottom = isLast ? '' : 'border-b border-gray-100';
        
        if (stepState === 'completed') {
            html += `
                <a href="${step.link}" class="flex items-center justify-between p-6 ${borderBottom} hover:bg-gray-50 transition-colors group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 squircle bg-[#10B981] text-white flex items-center justify-center font-bold text-[17px] mr-5">${step.id}</div>
                        <div>
                            <h3 class="font-bold text-[16px] text-[#1E1B4B]">${step.title}</h3>
                            <p class="text-[14px] text-[#6B7280] mt-0.5">${step.desc}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center text-[#10B981] font-semibold text-[14px] mr-6">
                            Completed 
                            <svg class="w-5 h-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            `;
        } else if (stepState === 'in_progress') {
            html += `
                <div class="px-0.5">
                    <a href="${step.link}" class="flex items-center justify-between p-6 bg-[#FDFDFF] border border-[#3D1B9B] rounded-xl shadow-sm transition-colors group relative z-10 my-[-1px]">
                        <div class="flex items-center">
                            <div class="w-10 h-10 squircle bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[17px] mr-5">${step.id}</div>
                            <div>
                                <h3 class="font-bold text-[16px] text-[#1E1B4B]">${step.title}</h3>
                                <p class="text-[14px] text-[#6B7280] mt-0.5">${step.desc}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center text-[#3D1B9B] font-bold text-[14px] mr-6">
                                In Progress 
                                <svg class="w-5 h-5 ml-2 text-[#3D1B9B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" stroke-opacity="0.3"></circle>
                                    <path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path>
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-[#3D1B9B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </a>
                </div>
            `;
        } else {
            const tag = step.link === "#" ? "div" : "a";
            const hoverClass = step.link === "#" ? "" : "hover:bg-gray-50";
            const hoverIconClass = step.link === "#" ? "" : "group-hover:text-gray-600";
            html += `
                <${tag} href="${step.link}" class="flex items-center justify-between p-6 ${borderBottom} ${hoverClass} transition-colors group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 squircle bg-white border border-gray-200 text-[#3D1B9B] flex items-center justify-center font-bold text-[17px] mr-5">${step.id}</div>
                        <div>
                            <h3 class="font-bold text-[16px] text-[#1E1B4B]">${step.title}</h3>
                            <p class="text-[14px] text-[#6B7280] mt-0.5">${step.desc}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center text-[#D1D5DB] font-semibold text-[14px] mr-6">
                            Pending 
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 ${hoverIconClass} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </${tag}>
            `;
        }
    });
    
    container.innerHTML = html;
    
    const progressText = document.getElementById('overall-progress-text');
    const progressBar = document.getElementById('overall-progress-bar');
    if(progressText && progressBar) {
        const percentage = Math.round((completedCount / 11) * 100);
        progressText.innerText = percentage + '%';
        progressBar.style.width = percentage + '%';
    }
}
