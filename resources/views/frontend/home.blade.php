@include('frontend.home.index', [
    'home' => $home ?? [],
    'events' => $events ?? [],
    'categories' => $categories ?? [],
    'countries' => $countries ?? [],
    'heroSlides' => $heroSlides ?? [],
    'heroMeta' => $heroMeta ?? ['event_count' => 0, 'category_count' => 0, 'country_count' => 0],
    'slots' => $slots ?? [],
])
