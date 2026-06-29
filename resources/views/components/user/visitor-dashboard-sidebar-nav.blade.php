@php
    $visitorNav = \App\Support\VisitorDashboardNav::context();
    $visitorDashboardNavLinks = $visitorNav['links'];
    $passFlowHref = $visitorNav['passFlowHref'];
    $passFlowLocked = $visitorNav['passFlowLocked'];
@endphp

<aside id="user-sidebar-aside" class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-[#0b1739] font-sans text-[#a0aabf]">
    <div class="flex shrink-0 items-center justify-between border-b border-white/10 px-5 py-5">
        <x-shared.brand-logo
            href="{{ $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard') }}"
            subtitle="VISITOR PANEL"
            mark-class="h-10 w-10 rounded-[14px] text-[18px]"
            title-class="text-[20px] text-white"
            subtitle-class="text-[10px] text-[#a0aabf]"
        />
        <button type="button" data-user-sidebar-close data-sidebar-close class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white lg:hidden">
            <i class="ph ph-x text-lg"></i>
        </button>
    </div>

    <nav class="custom-scrollbar flex-1 overflow-y-auto px-4 pb-6">
        <ul class="space-y-1">
            @foreach ($visitorDashboardNavLinks as $link)
                <li>
                    <a
                        href="{{ $link['href'] }}"
                        @class([
                            'flex items-center gap-3 rounded-[10px] px-4 py-3 transition-colors',
                            'bg-[#5B32F6] text-white shadow-[0_8px_20px_rgba(91,50,246,0.22)]' => $link['active'] ?? false,
                            'text-[#a0aabf] hover:bg-white/5 hover:text-white' => ! ($link['active'] ?? false),
                        ])
                    >
                        <i class="ph {{ $link['icon'] }} text-xl"></i>
                        <span class="text-[15px] font-medium">{{ $link['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="border-t border-white/10 px-4 py-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-[10px] px-4 py-3 text-[#a0aabf] transition-colors hover:bg-white/5 hover:text-white">
                    <i class="ph ph-globe text-xl"></i>
                    <span class="text-[15px] font-medium">Back to Website</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('frontend.user.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-[10px] border-0 bg-transparent px-4 py-3 text-left text-rose-300 transition-colors hover:bg-rose-500/10 hover:text-rose-200">
                        <i class="ph ph-sign-out text-xl"></i>
                        <span class="text-[15px] font-medium">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</aside>
