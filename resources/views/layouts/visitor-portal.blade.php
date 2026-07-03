<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'eproexpo — Visitor')</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config = { corePlugins: { preflight: false } };</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@include('frontend.user.partials.visitor-shell-styles')
@include('frontend.user.partials.visitor-portal-responsive')
@include('frontend.shared.partials.responsive-fixes')
@yield('page-styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeVisitorSidebar()"></div>

<div class="shell @yield('shell-class', 'shell--passes')">
    @include('frontend.user.partials.visitor-sidebar')

    <div class="portal-stack">
        <div class="mobile-topbar">
            <button type="button" class="menu-toggle" onclick="toggleVisitorSidebar()" aria-label="Open menu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <x-shared.brand-logo
                href="{{ route('frontend.user.dashboard') }}"
                subtitle=""
                mark-class="h-9 w-9 rounded-[13px] text-[17px]"
                title-class="text-[18px] text-[#071044]"
                subtitle-class="hidden"
            />
            <span style="width:38px;"></span>
        </div>

        @yield('portal-content')
    </div>
</div>

<script>
function toggleVisitorSidebar(){
  document.querySelector('.sidebar')?.classList.toggle('is-open');
  document.getElementById('sidebar-overlay')?.classList.toggle('is-open');
  document.body.classList.toggle('sidebar-open');
}
function closeVisitorSidebar(){
  document.querySelector('.sidebar')?.classList.remove('is-open');
  document.getElementById('sidebar-overlay')?.classList.remove('is-open');
  document.body.classList.remove('sidebar-open');
}
document.querySelectorAll('.sidebar .nav a').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 980) closeVisitorSidebar();
  });
});
window.addEventListener('resize', () => {
  if (window.innerWidth > 980) closeVisitorSidebar();
});
</script>
@stack('scripts')
</body>
</html>
