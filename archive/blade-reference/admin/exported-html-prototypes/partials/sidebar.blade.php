<aside class="w-[240px] h-screen bg-[#0b1739] text-[#a0aabf] flex flex-col font-sans border-r border-[#1a2548] rounded-tr-[20px] rounded-br-[20px] shadow-xl overflow-hidden relative">
  <!-- Logo Section -->
  <div class="p-6 flex items-center gap-3 shrink-0">
    <!-- Icon/Logo -->
    <svg viewBox="0 0 100 100" class="w-[38px] h-[38px] shrink-0 drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="logoGradSidebar" x1="0%" y1="100%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#1060FF"/>
                <stop offset="35%" stop-color="#00D4FF"/>
                <stop offset="65%" stop-color="#FF3B6A"/>
                <stop offset="100%" stop-color="#FF7547"/>
            </linearGradient>
        </defs>
        <path d="M 80 50 L 20 50 A 30 30 0 0 1 80 50 A 30 30 0 0 1 65 76" stroke="url(#logoGradSidebar)" stroke-width="16" stroke-linecap="round" stroke-linejoin="round" fill="none" />
    </svg>
    <span class="text-white text-[24px] font-bold tracking-wide">eproexpo</span>
  </div>

  <!-- Navigation Menu -->
  <nav class="flex-1 overflow-y-auto px-4 pb-6 custom-scrollbar">
    <ul class="space-y-1">
      
      <!-- Dashboard -->
      <li>
        <a href="admin_dashboard.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] text-white bg-[#2b228b] shadow-md transition-colors group">
          <i class="ph ph-chart-pie-slice text-xl"></i>
          <span class="font-medium text-[15px]">Dashboard</span>
        </a>
      </li>

      <!-- Company -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-buildings text-xl group-hover:text-white transition-colors"></i>
            <span class="font-medium text-[15px]">Company</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="companies.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="companies.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Companies
                </a>
            </li>
            <li>
                <a href="company_approval.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="company_approval.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Company Approval
                </a>
            </li>
            <li>
                <a href="add_company.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="add_company.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Add Company
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Exhibitions -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-calendar-blank text-xl"></i>
            <span class="font-medium text-[15px]">Exhibitions</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="exhibitions.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="exhibitions.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Exhibitions
                </a>
            </li>
            <li>
                <a href="add_exhibition.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="add_exhibition.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Add Exhibition
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Pavilions -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-flag-banner text-xl"></i>
            <span class="font-medium text-[15px]">Pavilions</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="pavilions.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="pavilions.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Pavilions
                </a>
            </li>
            <li>
                <a href="add_pavilion.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="add_pavilion.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Add Pavilion
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Halls -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-buildings text-xl"></i>
            <span class="font-medium text-[15px]">Halls</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="halls.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="halls.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    All Halls
                </a>
            </li>
            <li>
                <a href="add_hall.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="add_hall.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Add Hall
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Booths -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-package text-xl"></i>
            <span class="font-medium text-[15px]">Booths</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="booth_management.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="booth_management.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Booth Management
                </a>
            </li>
            <li>
                <a href="add_booth.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="add_booth.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Add Booth
                </a>
            </li>
            <li>
                <a href="booth_setup_review.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="booth_setup_review.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Booth Setup Review
                </a>
            </li>
            <li>
                <a href="booths.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="booths.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Booth Inventory
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Event Management -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-ticket text-xl group-hover:text-white transition-colors"></i>
            <span class="font-medium text-[15px]">Event Management</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="events.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="events.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Events
                </a>
            </li>
            <li>
                <a href="event_setup_review.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="event_setup_review.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Event Setup Review
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Users & Visitors -->
      <li>
        <a href="users.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group">
          <i class="ph ph-users text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Users & Visitors</span>
        </a>
      </li>

      <!-- Tickets / Passes -->
      <li>
        <a href="tickets.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="tickets.html">
          <i class="ph ph-ticket text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Tickets / Passes</span>
        </a>
      </li>

      <!-- Enquiries / Leads -->
      <li>
        <a href="enquiries.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="enquiries.html">
          <i class="ph ph-envelope text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Enquiries / Leads</span>
        </a>
      </li>

      <!-- Payments / Invoices -->
      <li>
        <a href="payments.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="payments.html">
          <i class="ph ph-currency-circle-dollar text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Payments / Invoices</span>
        </a>
      </li>

      <!-- Reports / Analytics -->
      <li>
        <a href="reports.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="reports.html">
          <i class="ph ph-chart-bar text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Reports / Analytics</span>
        </a>
      </li>

      <!-- Notifications -->
      <li>
        <a href="notifications.html" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="notifications.html">
          <i class="ph ph-bell text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Notifications</span>
        </a>
      </li>

      <!-- Settings Dropdown -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-gear text-xl"></i>
            <span class="font-medium text-[15px]">Settings</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <!-- Connection line -->
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            
            <li>
                <a href="settings.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="settings.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    General Settings
                </a>
            </li>
            <li>
                <a href="roles.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="roles.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Roles & Permissions
                </a>
            </li>
            <li>
                <a href="activity_logs.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="activity_logs.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Activity Logs
                </a>
            </li>
            <li>
                <a href="system_settings.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="system_settings.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    System Settings
                </a>
            </li>
            <li>
                <a href="backup.html" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="backup.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Backup & Restore
                </a>
            </li>
          </ul>
        </div>
      </li>
      
    </ul>
  </nav>

  <style>
        body { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    /* Custom scrollbar to match the dark theme */
    .custom-scrollbar::-webkit-scrollbar {
      width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
      background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.2);
    }
  </style>
</aside>


