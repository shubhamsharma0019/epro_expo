@include('frontend.user.partials.detail-page', [
    'title' => 'Visit Details',
    'eyebrow' => 'Visit history',
    'heading' => 'Innovation Pavilion Visit',
    'description' => 'You explored Hall 1, visited 8 booths, downloaded 3 documents, and sent 2 enquiries during this exhibition visit.',
    'backUrl' => '/user/visits',
    'meta' => [['Pavilion', 'Innovation'], ['Booths', '8 visited'], ['Enquiries', '2 sent']],
])
