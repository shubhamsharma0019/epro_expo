@include('user.partials.detail-page', [
    'title' => 'Exhibition Ticket Details',
    'eyebrow' => 'Exhibition pass',
    'heading' => 'Global Tech Expo 2026',
    'description' => 'Visitor Pass for Innovation Pavilion with lobby access, booth discovery, enquiries, and downloadable e-ticket.',
    'primaryUrl' => '/user/exhibition-tickets/1/e-ticket',
    'primaryLabel' => 'View E-Ticket',
    'backUrl' => '/user/exhibition-tickets',
    'meta' => [['Status', 'Active'], ['Pavilion', 'Innovation'], ['Access', 'Lobby + Booths']],
])
