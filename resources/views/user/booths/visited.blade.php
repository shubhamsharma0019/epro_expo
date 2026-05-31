@include('user.partials.list-page', [
    'title' => 'Visited Booths',
    'variant' => 'media',
    'eyebrow' => 'Booth Directory',
    'description' => 'Companies and virtual booths you interacted with during exhibitions.',
    'icon' => 'fa-solid fa-store',
    'items' => [
        ['OmniTech Solutions', 'Innovation Pavilion | Booth 12A', 'Visited', '/exhibitions/global-tech-expo-2026/booths/omnitech-solutions'],
        ['Healthcore Labs', 'Healthcare Pavilion | Booth 08C', 'Visited', '/exhibitions/healthcare-innovation-expo/booths/healthcore-labs'],
        ['Buildwise Studio', 'Business Pavilion | Booth 20B', 'Visited', '/exhibitions/business-growth/booths/buildwise-studio'],
    ],
])
