@include('frontend.user.partials.list-page', [
    'title' => $title ?? 'My Exhibition Tickets',
    'variant' => 'ticket',
    'eyebrow' => $eyebrow ?? 'Exhibition Access',
    'description' => $description ?? 'Manage exhibition visitor passes, active lobby access, and e-ticket downloads.',
    'icon' => $icon ?? 'fa-regular fa-id-card',
    'items' => $items ?? [],
])
