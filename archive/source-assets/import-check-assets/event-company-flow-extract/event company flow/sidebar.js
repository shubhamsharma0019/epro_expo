const sidebarHTML = `
<div class="w-[280px] h-screen border-r border-gray-100 flex flex-col py-8 px-6 bg-white fixed top-0 left-0 font-sans shadow-[2px_0_10px_rgba(0,0,0,0.02)] z-50">
    <!-- Logo -->
    <div class="flex items-center gap-3 mb-10 pl-2">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 8.5C15.0964 8.5 9.5 14.0964 9.5 21C9.5 27.9036 15.0964 33.5 22 33.5C25.8643 33.5 29.3175 31.7454 31.621 28.9868" stroke="url(#paint0_linear)" stroke-width="7" stroke-linecap="round"/>
            <circle cx="32" cy="11" r="3.5" fill="#FF8A00"/>
            <defs>
                <linearGradient id="paint0_linear" x1="9.5" y1="33.5" x2="31" y2="8.5" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#5B32F6" />
                    <stop offset="1" stop-color="#FF3366" />
                </linearGradient>
            </defs>
        </svg>
        <span class="text-[24px] font-bold text-[#1C1364] tracking-tight">eproexpo</span>
    </div>
    
    <!-- Navigation -->
    <nav class="flex flex-col gap-1.5 flex-1 overflow-y-auto min-h-0" style="scrollbar-width: none;">
        <!-- Dashboard (Active) -->
        <a href="event_company_dashboard.html" class="flex items-center gap-4 px-4 py-3.5 bg-[#F4F1FF] text-[#5B32F6] text-[15px] font-semibold rounded-xl transition-colors">
            <svg class="text-[#5B32F6] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
            Dashboard
        </a>
        
        <!-- Events -->
        <a href="create-event.html" class="flex items-center gap-4 px-4 py-3.5 text-[#1C1364] hover:bg-[#F8F9FA] text-[15px] font-medium rounded-xl transition-colors group">
            <svg class="text-[#1C1364] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            Events
        </a>
        
        <!-- Leads -->
        <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-[#1C1364] hover:bg-[#F8F9FA] text-[15px] font-medium rounded-xl transition-colors group">
            <svg class="text-[#1C1364] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="6" height="6" rx="1"></rect><rect x="14" y="4" width="6" height="6" rx="1"></rect><rect x="4" y="14" width="6" height="6" rx="1"></rect><path d="M14 17h6"></path><path d="M17 14v6"></path></svg>
            Leads
        </a>
        
        <!-- Registrations -->
        <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-[#1C1364] hover:bg-[#F8F9FA] text-[15px] font-medium rounded-xl transition-colors group">
            <svg class="text-[#1C1364] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="M9 14h6"></path><path d="M9 10h6"></path><path d="M9 18h6"></path></svg>
            Registrations
        </a>
        
        <!-- Analytics -->
        <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-[#1C1364] hover:bg-[#F8F9FA] text-[15px] font-medium rounded-xl transition-colors group">
            <svg class="text-[#1C1364] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            Analytics
        </a>
        
        <!-- Settport -->
        <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-[#1C1364] hover:bg-[#F8F9FA] text-[15px] font-medium rounded-xl transition-colors group">
            <svg class="text-[#1C1364] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            Settport
        </a>
        
        <!-- Support -->
        <a href="#" class="flex items-center gap-4 px-4 py-3.5 text-[#1C1364] hover:bg-[#F8F9FA] text-[15px] font-medium rounded-xl transition-colors group">
            <svg class="text-[#1C1364] w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Support
        </a>
    </nav>
    

</div>
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .overflow-y-auto::-webkit-scrollbar {
        display: none;
    }
</style>
`;
