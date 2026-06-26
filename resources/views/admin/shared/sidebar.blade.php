<aside id="admin-sidebar-aside" class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-[#0b1739] font-sans text-[#a0aabf]">
  <!-- Logo Section -->
  <div class="flex shrink-0 items-center justify-between border-b border-white/10 px-5 py-5">
    <x-shared.brand-logo
        href="{{ route('admin.dashboard') }}"
        subtitle="ADMIN PANEL"
        mark-class="h-10 w-10 rounded-[14px] text-[18px]"
        title-class="text-[20px] text-white"
        subtitle-class="text-[10px] text-[#a0aabf]"
    />
    <button type="button" data-admin-sidebar-close class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white lg:hidden">
      <i class="ph ph-x text-lg"></i>
    </button>
  </div>

  <!-- Navigation Menu -->
  <nav class="flex-1 overflow-y-auto px-4 pb-6 custom-scrollbar">
    <ul class="space-y-1">
      
      <!-- Dashboard -->
      <li>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group">
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
                <a href="{{ route('admin.companies.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Companies
                </a>
            </li>
            <li>
                <a href="{{ route('admin.company-approval.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Company Approval
                </a>
            </li>
            <li>
                <a href="{{ route('admin.companies.create') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
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
                <a href="{{ route('admin.exhibitions.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="07_exhibitions.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Exhibitions
                </a>
            </li>
            <li>
                <a href="{{ route('admin.exhibitions.create') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="08_add_exhibition.html">
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
                <a href="{{ route('admin.pavilions.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="10_pavilions.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Pavilions
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pavilions.create') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="11_add_pavilion.html">
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
                <a href="{{ route('admin.halls.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="12_halls.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    All Halls
                </a>
            </li>
            <li>
                <a href="{{ route('admin.halls.create') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="13_add_hall.html">
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
                <a href="{{ route('admin.booth-bookings.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="16_booth_management.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Booth Management
                </a>
            </li>
            <li>
                <a href="{{ route('admin.booths.create') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="15_add_booth.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Add Booth
                </a>
            </li>
            <li>
                <a href="{{ route('admin.booth-approvals.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="17_booth_setup_review.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Booth Setup Review
                </a>
            </li>
            <li>
                <a href="{{ route('admin.booths.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="14_booths.html">
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
                <a href="{{ route('admin.events.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="20_events.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Events
                </a>
            </li>
            <li>
                <a href="{{ route('admin.event-approvals.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Event Approval
                </a>
            </li>
            <li>
                <a href="{{ route('admin.event-logistics.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Event Logistics
                </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- CMS & Support -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-globe text-xl"></i>
            <span class="font-medium text-[15px]">CMS & Support</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            <li><a href="{{ route('admin.cms.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>CMS</a></li>
            <li><a href="{{ route('admin.website.home') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Website Home</a></li>
            <li><a href="{{ route('admin.support.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Support</a></li>
          </ul>
        </div>
      </li>

      <!-- Users & Visitors -->
      <li>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group">
          <i class="ph ph-users text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Users & Visitors</span>
        </a>
      </li>

      <!-- Tickets / Passes -->
      <li>
        <a href="{{ route('admin.event-tickets.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="27_tickets.html">
          <i class="ph ph-ticket text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Tickets / Passes</span>
        </a>
      </li>

      <!-- Enquiries -->
      <li>
        <a href="{{ route('admin.enquiries.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="33_enquiries.html">
          <i class="ph ph-envelope text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Enquiries</span>
        </a>
      </li>

      <!-- Payments / Invoices -->
      <li>
        <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="28_payments.html">
          <i class="ph ph-currency-circle-dollar text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Payments / Invoices</span>
        </a>
      </li>


      <!-- Admin Operations -->
      <li class="sidebar-dropdown">
        <button class="w-full flex items-center justify-between px-4 py-3 rounded-[10px] text-[#a0aabf] hover:text-white hover:bg-white/5 transition-colors group">
          <div class="flex items-center gap-3">
            <i class="ph ph-command text-xl"></i>
            <span class="font-medium text-[15px]">Admin Operations</span>
          </div>
          <i class="ph ph-caret-down text-sm transition-transform duration-200 dropdown-arrow"></i>
        </button>
        <div class="dropdown-menu hidden overflow-hidden transition-all duration-300">
          <ul class="py-2 mt-1 space-y-1 relative">
            <div class="absolute left-[26px] top-4 bottom-4 w-px bg-white/10"></div>
            <li><a href="{{ route('admin.leads.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="25_lead_management.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Lead Management</a></li>
            <li><a href="{{ route('admin.meetings.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="26_meeting_management.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Meeting Management</a></li>
            <li><a href="{{ route('admin.visitor-checkins.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="24_visitor_checkin_analytics.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Visitor Check-ins</a></li>
            <li><a href="{{ route('admin.kyc.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="05_kyc_verification.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>KYC Verification</a></li>
            <li><a href="{{ route('admin.refunds.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="29_refund_management.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Refund Management</a></li>
            <li><a href="{{ route('admin.booth-engineering.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="19_booth_engineering_review.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Booth Engineering</a></li>
            <li><a href="{{ route('admin.exhibition-lifecycle.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="09_exhibition_lifecycle.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Exhibition Lifecycle</a></li>
            <li><a href="{{ route('admin.occupancy-analytics.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="32_occupancy_analytics.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Occupancy Analytics</a></li>
            <li><a href="{{ route('admin.revenue-breakdown.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="31_revenue_breakdown_reports.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Revenue Breakdown</a></li>
            <li><a href="{{ route('admin.flow-diagrams.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="42_flow_diagrams.html"><div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>Flow Diagrams</a></li>
            
          </ul>
        </div>
      </li>

      <!-- Reports / Analytics -->
      <li>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="30_reports.html">
          <i class="ph ph-chart-bar text-xl group-hover:text-white transition-colors"></i>
          <span class="font-medium text-[15px]">Reports / Analytics</span>
        </a>
      </li>

      <!-- Notifications -->
      <li>
        <a href="{{ route('admin.notifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-[10px] hover:bg-white/5 hover:text-white transition-colors group" data-path="34_notifications.html">
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
                <a href="{{ route('admin.settings.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group" data-path="39_settings.html">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    General Settings
                </a>
            </li>
            <li>
                <a href="{{ route('admin.roles.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Roles & Permissions
                </a>
            </li>
            <li>
                <a href="{{ route('admin.activity-logs.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    Activity Logs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.system-settings.index') }}" class="relative flex items-center pl-[44px] pr-4 py-2 text-[14px] text-[#a0aabf] hover:text-white hover:bg-white/5 rounded-lg transition-colors group">
                    <div class="absolute left-[24.5px] w-[4px] h-[4px] rounded-full bg-white/30 group-hover:bg-white/50 indicator-dot"></div>
                    System Settings
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
  
        /* Enterprise responsive fixes: prevent side scroll while keeping all data visible */
        html, body { max-width: 100%; overflow-x: hidden; }
        *, *::before, *::after { box-sizing: border-box; }
        main, header, section, .main-scrollbar { min-width: 0; }
        img, svg, video, canvas { max-width: 100%; height: auto; }
        input, select, textarea { max-width: 100%; }
        table { width: 100%; table-layout: fixed; border-collapse: collapse; }
        th, td { white-space: normal !important; overflow-wrap: anywhere; word-break: break-word; vertical-align: top; }
        thead th { line-height: 1.25; letter-spacing: .02em; }
        .overflow-x-visible, .overflow-x-visible { overflow-x: visible !important; }
        .whitespace-normal { white-space: normal !important; }
        .no-scrollbar { scrollbar-width: none; }
        
        @media (max-width: 1280px) {
            .main-scrollbar { padding-left: 1rem !important; padding-right: 1rem !important; }
            th, td { padding-left: .75rem !important; padding-right: .75rem !important; font-size: 12px !important; }
            header input { width: 240px !important; }
            .tracking-wider { letter-spacing: .02em !important; }
        }
        @media (max-width: 1024px) {
            .lg\:flex-row { flex-direction: column !important; }
            .lg\:items-end { align-items: flex-start !important; }
            th, td { padding-left: .55rem !important; padding-right: .55rem !important; font-size: 11.5px !important; }
            .gap-6 { gap: 1rem !important; }
            
            /* Sidebar Parent Drawer style for legacy pages */
            body .admin-sidebar-parent-container {
                display: flex !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 260px !important;
                height: 100vh !important;
                z-index: 100 !important;
                transform: translateX(-100%) !important;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            body .admin-sidebar-parent-container.open {
                transform: translateX(0) !important;
            }
            
            /* Horizontal table scroll for better readability on small viewports */
            .overflow-x-visible, .overflow-x-auto {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }
            .overflow-x-visible table, .overflow-x-auto table, main table {
                min-width: 850px !important;
                width: 100% !important;
                table-layout: auto !important;
            }
            th, td {
                white-space: nowrap !important;
                padding-left: .75rem !important;
                padding-right: .75rem !important;
                font-size: 13px !important;
            }
        }
        @media (max-width: 768px) {
            .p-6, .p-8, .p-12, .px-8, .lg\:p-8, .main-scrollbar {
                padding: 1rem !important;
            }
            header {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            .mt-8.flex.items-center.justify-end {
                flex-wrap: wrap !important;
                justify-content: stretch !important;
                gap: 0.5rem !important;
            }
            .mt-8.flex.items-center.justify-end button {
                width: 100% !important;
                margin: 0 !important;
            }
        }
        @media (max-width: 640px) {
            h1.text-\[26px\], h1.text-\[24px\], h1.text-\[28px\] {
                font-size: 1.5rem !important;
                line-height: 2rem !important;
            }
        }
    </style>

    <script>
    (function() {
        const init = () => {
            const aside = document.getElementById('admin-sidebar-aside');
            if (!aside) return;

            const newSidebarContainer = document.getElementById('admin-sidebar');
            if (newSidebarContainer) {
                document.body.classList.add('overflow-x-hidden');
                return;
            }

            const parent = aside.parentElement;
            if (!parent) return;

            parent.classList.add('admin-sidebar-parent-container');

            const body = document.body;
            body.classList.add('overflow-x-hidden');

            let overlay = document.getElementById('admin-sidebar-overlay-dynamic');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'admin-sidebar-overlay-dynamic';
                overlay.className = 'fixed inset-0 z-40 hidden bg-[#071044]/40';
                body.appendChild(overlay);
            }

            const header = document.querySelector('header');
            if (header) {
                const leftPart = header.querySelector('.flex.items-center') || header;
                
                let toggleBtn = header.querySelector('[data-admin-sidebar-open-dynamic]');
                if (!toggleBtn) {
                    toggleBtn = document.createElement('button');
                    toggleBtn.type = 'button';
                    toggleBtn.className = 'inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-[#0B132C] mr-3 lg:hidden shrink-0 hover:bg-gray-50';
                    toggleBtn.innerHTML = '<i class="ph ph-list text-xl"></i>';
                    toggleBtn.setAttribute('aria-label', 'Open sidebar');
                    toggleBtn.setAttribute('data-admin-sidebar-open-dynamic', '');
                    
                    leftPart.insertBefore(toggleBtn, leftPart.firstChild);
                }

                toggleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    parent.classList.add('open');
                    overlay.classList.remove('hidden');
                    body.classList.add('overflow-hidden');
                });

                overlay.addEventListener('click', () => {
                    parent.classList.remove('open');
                    overlay.classList.add('hidden');
                    body.classList.remove('overflow-hidden');
                });
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
    </script>
</aside>


