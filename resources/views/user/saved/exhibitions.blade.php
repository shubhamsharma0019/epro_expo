@include('user.partials.list-page', [
    'title' => 'Saved Exhibitions',
    'variant' => 'media',
    'eyebrow' => 'Saved Collection',
    'description' => 'Your bookmarked exhibitions for quick access and future ticket booking.',
    'icon' => 'fa-regular fa-bookmark',
    'items' => [
        ['Global Tech Expo 2026', 'Technology | Virtual + New Delhi', 'Saved', '/exhibitions/global-tech-expo-2026'],
        ['Healthcare Innovation Expo', 'Healthcare | Virtual', 'Saved', '/exhibitions/healthcare-innovation-expo'],
        ['Sustainable Business Fair', 'Sustainability | Hybrid', 'Saved', '/exhibitions/sustainable-business-fair'],
    ],
])
