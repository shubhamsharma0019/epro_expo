@include('user.partials.list-page', [
    'title' => 'Visit History',
    'variant' => 'visit',
    'eyebrow' => 'Visitor Timeline',
    'description' => 'Review exhibitions, halls, booths, and companies you visited recently.',
    'icon' => 'fa-regular fa-clock',
    'items' => [
        ['Innovation Pavilion Visit', 'Hall 1 | 8 booths explored', 'Completed', '/user/visits/1'],
        ['Healthcare Pavilion Visit', 'Hall 2 | 4 booths explored', 'Completed', '/user/visits/2'],
        ['Business Pavilion Visit', 'Hall 3 | 6 booths explored', 'Completed', '/user/visits/3'],
    ],
])
