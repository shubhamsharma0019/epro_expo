@include('user.partials.list-page', [
    'title' => 'My Exhibition Tickets',
    'variant' => 'ticket',
    'eyebrow' => 'Exhibition Access',
    'description' => 'Manage exhibition visitor passes, active lobby access, and e-ticket downloads.',
    'icon' => 'fa-regular fa-id-card',
    'items' => [
        ['Global Tech Expo 2026', 'Visitor Pass | Innovation Pavilion', 'Active', '/user/exhibition-tickets/1'],
        ['Healthcare Innovation Expo', 'Business Pass | Healthcare Pavilion', 'Upcoming', '/user/exhibition-tickets/2'],
        ['Sustainable Business Fair', 'Visitor Pass | Sustainability Pavilion', 'Saved', '/user/exhibition-tickets/3'],
    ],
])
