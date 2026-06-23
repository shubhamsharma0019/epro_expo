@include('frontend.user.partials.detail-page', [
    'title' => 'Visit Details',
    'eyebrow' => 'Visit history',
    'heading' => $exhibition->title ?? $exhibition->name ?? 'Exhibition Visit',
    'description' => 'You registered for this exhibition with pass ' . $pass->booking_id . '. Track your sessions, meetings, and booth visits from here.',
    'primaryUrl' => $exhibition?->slug ? route('exhibitions.visit', $exhibition->slug) : route('frontend.user.tickets.index'),
    'primaryLabel' => 'Open Exhibition Lobby',
    'backUrl' => route('frontend.user.visits.index'),
    'heroImage' => asset('images/exhibitions/hero-pavilion-scene.png'),
    'meta' => [
        ['Pass ID', $pass->booking_id],
        ['Status', $pass->payment_status === 'completed' ? 'Confirmed' : ucfirst($pass->payment_status)],
        ['Sessions Joined', (string) $sessionsCount],
        ['Meetings', (string) $meetingsCount],
        ['Booths Viewed', (string) $boothViewsCount],
        ['Visit Date', ($exhibition?->start_date && $exhibition?->end_date)
            ? $exhibition->start_date->format('M d, Y') . ' - ' . $exhibition->end_date->format('M d, Y')
            : ($pass->created_at?->format('M d, Y') ?? 'Date TBD')],
    ],
])
