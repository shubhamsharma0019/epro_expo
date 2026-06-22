@php
    $showVisitorSidebar = $showVisitorSidebar ?? \App\Support\ExhibitionTicketFlow::shouldShowVisitorSidebar($slug ?? request()->route('slug'));
@endphp

@if ($showVisitorSidebar)
    <div id="exhibition-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#071044]/40 lg:hidden"></div>
    @include('components.exhibition.exhibition-sidebar')
@endif
