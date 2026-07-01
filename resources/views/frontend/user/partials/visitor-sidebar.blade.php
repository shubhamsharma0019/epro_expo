@php
    $authUser = auth()->user();
    $userName = ($user ?? $authUser)?->name ?? 'Visitor';
    $initials = collect(explode(' ', $userName))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
    $activeNav = $visitorNavActive ?? (
        request()->routeIs('frontend.user.dashboard') ? 'dashboard' : (
            request()->routeIs('frontend.user.profile') ? 'profile' : (
                request()->routeIs('frontend.user.meetings') ? 'meetings' : (
                    request()->routeIs('frontend.user.browse') ? 'browse' : (
                        request()->routeIs('frontend.user.logout.confirm') ? 'logout' : (
                            request()->routeIs('frontend.user.passes', 'frontend.user.tickets.*', 'frontend.user.exhibitions.halls*') ? 'passes' : ''
                        )
                    )
                )
            )
        )
    );
@endphp
<aside class="sidebar" id="visitor-sidebar">
    <button type="button" class="sidebar-close" onclick="closeVisitorSidebar()" aria-label="Close menu">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
    <div class="brand">
        <x-shared.brand-logo
            href="{{ route('frontend.user.dashboard') }}"
            subtitle=""
            mark-class="h-10 w-10 rounded-[14px] text-[18px]"
            title-class="text-[20px] text-white"
            subtitle-class="hidden"
        />
    </div>
    <nav class="nav">
        <a href="{{ route('frontend.user.dashboard') }}" @class(['active' => $activeNav === 'dashboard'])>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
            Dashboard
        </a>
        <a href="{{ route('frontend.user.passes') }}" @class(['active' => $activeNav === 'passes'])>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
            My passes
        </a>
        <a href="{{ route('frontend.user.meetings') }}" @class(['active' => $activeNav === 'meetings'])>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="3"/><path d="M2 21v-1a6 6 0 0112 0v1"/><circle cx="17" cy="8" r="2.5"/><path d="M22 21v-1a4.5 4.5 0 00-5-4.47"/></svg>
            My meetings
        </a>
        <a href="{{ route('frontend.user.profile') }}" @class(['active' => $activeNav === 'profile'])>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profile
        </a>
        <a href="{{ route('frontend.user.browse') }}" @class(['active' => $activeNav === 'browse'])>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21v-7h6v7"/></svg>
            Event / Exhibition
        </a>
        <a href="{{ route('frontend.user.logout.confirm') }}" @class(['logout-active' => $activeNav === 'logout', 'active' => $activeNav === 'logout'])>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
            Logout
        </a>
    </nav>
    <a href="{{ route('frontend.user.profile') }}" class="userid">
        <div class="avatar">{{ $initials }}</div>
        <div><p>{{ $userName }}</p></div>
    </a>
</aside>
