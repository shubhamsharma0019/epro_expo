@include('frontend.shared.partials.site-navbar', [
    'activeNav' => $activeNav ?? null,
    'menuId' => $menuId ?? 'eventsNav',
])
