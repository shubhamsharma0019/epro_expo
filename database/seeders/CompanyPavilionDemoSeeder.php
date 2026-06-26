<?php

namespace Database\Seeders;

use App\Domain\Booth\Models\BoothSize;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Support\HallBoothLayoutSync;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanyPavilionDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure the exhibitions exist and have active status
        $exhibitionsData = [
            [
                'slug' => 'global-tech-expo-2024',
                'name' => 'Global Tech Expo 2024',
                'title' => 'Global Tech Expo 2024',
                'description' => 'A premium exhibition for technology, business, healthcare, education, sustainability, and mobility companies.',
                'location' => 'Virtual Expo',
                'venue' => 'Jio World Convention Centre, Mumbai, India',
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-14',
                'banner_image' => 'images/exhibitions/hero-book-exhibition.png',
                'banner_url' => 'images/exhibitions/hero-book-exhibition.png',
                'companies_count' => 120,
                'status' => 'active',
                'approval_status' => 'approved',
                'publish_status' => 'published',
                'approved_at' => now(),
                'published_at' => now(),
            ],
            [
                'slug' => 'future-of-ai-expo',
                'name' => 'Future of AI Expo',
                'title' => 'Future of AI Expo',
                'description' => 'Explore deep neural structures, machine learning platforms, and automation algorithms.',
                'location' => 'Bengaluru Convention Centre',
                'venue' => 'Bengaluru Convention Centre, Bengaluru, India',
                'start_date' => '2026-06-10',
                'end_date' => '2026-06-12',
                'banner_image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
                'companies_count' => 80,
                'status' => 'active',
                'approval_status' => 'approved',
                'publish_status' => 'published',
                'approved_at' => now(),
                'published_at' => now(),
            ],
            [
                'slug' => 'sustainability-world-expo',
                'name' => 'Sustainability World Expo',
                'title' => 'Sustainability World Expo',
                'description' => 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.',
                'location' => 'Pune International Exhibition Centre',
                'venue' => 'Pune International Exhibition Centre, Pune, India',
                'start_date' => '2026-08-08',
                'end_date' => '2026-08-10',
                'banner_image' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
                'companies_count' => 85,
                'status' => 'active',
                'approval_status' => 'approved',
                'publish_status' => 'published',
                'approved_at' => now(),
                'published_at' => now(),
            ]
        ];

        $exhibitions = [];
        foreach ($exhibitionsData as $exData) {
            $exhibitions[$exData['slug']] = Exhibition::updateOrCreate(
                ['slug' => $exData['slug']],
                $exData
            );
        }

        $boothSizes = collect([
            ['title' => '3m x 3m', 'width' => 3, 'height' => 3, 'area' => 9, 'price' => 499, 'description' => 'Standard booth for compact product showcases.'],
            ['title' => '3m x 4m', 'width' => 3, 'height' => 4, 'area' => 12, 'price' => 899, 'description' => 'Expanded booth for demos and display counters.'],
            ['title' => '6m x 3m', 'width' => 6, 'height' => 3, 'area' => 18, 'price' => 1499, 'description' => 'Premium booth for larger visitor interactions.'],
            ['title' => '6m x 6m', 'width' => 6, 'height' => 6, 'area' => 36, 'price' => 1999, 'description' => 'Flagship booth for high visibility brands.'],
            ['title' => '9m x 9m', 'width' => 9, 'height' => 9, 'area' => 81, 'price' => 2499, 'description' => 'Large custom booth for anchor exhibitors.'],
        ])->map(function ($size) {
            return BoothSize::updateOrCreate(
                ['title' => $size['title']],
                array_merge($size, ['status' => 'active'])
            );
        })->values();

        // Seeding Pavilion Map by Exhibition Slug
        $pavilionMap = [
            'global-tech-expo-2024' => [
                [
                    'title' => 'Innovation Pavilion',
                    'description' => 'High-tech, AI, IoT and more',
                    'image' => 'assets/images/pavilions/innovation-pavilion.png',
                    'total_halls' => 4,
                    'total_booths' => 1200,
                    'halls' => [
                        ['Hall 1 - Tech & Innovation', 360],
                        ['Hall 2 - AI & Robotics', 320],
                        ['Hall 3 - Digital Solutions', 280],
                        ['Hall 4 - Future Mobility', 240],
                    ],
                ],
                [
                    'title' => 'Business Pavilion',
                    'description' => 'Perfect for B2B meetings and networking',
                    'image' => 'assets/images/pavilions/business-pavilion.png',
                    'total_halls' => 3,
                    'total_booths' => 900,
                    'halls' => [
                        ['Hall 1 - Enterprise Solutions', 340],
                        ['Hall 2 - Finance & Growth', 300],
                        ['Hall 3 - B2B Networking', 260],
                    ],
                ],
                [
                    'title' => 'Healthcare Pavilion',
                    'description' => 'Healthcare, Pharma & wellness',
                    'image' => 'assets/images/pavilions/healthcare-pavilion.png',
                    'total_halls' => 3,
                    'total_booths' => 800,
                    'halls' => [
                        ['Hall 1 - Healthcare Innovation', 300],
                        ['Hall 2 - Pharma & Life Sciences', 260],
                        ['Hall 3 - Wellness Technology', 240],
                    ],
                ],
                [
                    'title' => 'Education Pavilion',
                    'description' => 'EdTech, training & academic solutions',
                    'image' => 'assets/images/pavilions/education-pavilion.png',
                    'total_halls' => 2,
                    'total_booths' => 600,
                    'halls' => [
                        ['Hall 1 - EdTech Platforms', 320],
                        ['Hall 2 - Training & Academia', 280],
                    ],
                ],
                [
                    'title' => 'Sustainability Pavilion',
                    'description' => 'Green tech & sustainable future solutions',
                    'image' => 'assets/images/pavilions/sustainability-pavilion.png',
                    'total_halls' => 2,
                    'total_booths' => 500,
                    'halls' => [
                        ['Hall 1 - Green Technology', 270],
                        ['Hall 2 - Sustainable Future', 230],
                    ],
                ],
                [
                    'title' => 'Automotive Pavilion',
                    'description' => 'Automotive tech & mobility solutions',
                    'image' => 'assets/images/pavilions/automotive-pavilion.png',
                    'total_halls' => 2,
                    'total_booths' => 700,
                    'halls' => [
                        ['Hall 1 - Automotive Technology', 380],
                        ['Hall 2 - Mobility Solutions', 320],
                    ],
                ],
            ],
            'future-of-ai-expo' => [
                [
                    'title' => 'Deep Learning Pavilion',
                    'description' => 'Neural network models, generative frameworks and tensors',
                    'image' => 'assets/images/pavilions/innovation-pavilion.png',
                    'total_halls' => 2,
                    'total_booths' => 600,
                    'halls' => [
                        ['Hall 1 - LLMs & Chatbots', 300],
                        ['Hall 2 - Computer Vision', 300],
                    ],
                ],
                [
                    'title' => 'AI Robotics Pavilion',
                    'description' => 'Humanoids, drones, automation mechanics and computer vision integration',
                    'image' => 'assets/images/pavilions/automotive-pavilion.png',
                    'total_halls' => 1,
                    'total_booths' => 300,
                    'halls' => [
                        ['Hall 1 - Machine Automation', 300],
                    ],
                ]
            ],
            'sustainability-world-expo' => [
                [
                    'title' => 'Renewable Energy Pavilion',
                    'description' => 'Solar power, wind, carbon reduction, and grid technology',
                    'image' => 'assets/images/pavilions/sustainability-pavilion.png',
                    'total_halls' => 2,
                    'total_booths' => 500,
                    'halls' => [
                        ['Hall 1 - Solar Energy Grid', 250],
                        ['Hall 2 - Eco Tech Systems', 250],
                    ],
                ]
            ]
        ];

        foreach ($pavilionMap as $slug => $pvs) {
            $exhibition = $exhibitions[$slug] ?? null;
            if (!$exhibition) {
                continue;
            }

            foreach ($pvs as $pavilionData) {
                $pavilion = Pavilion::updateOrCreate(
                    [
                        'exhibition_id' => $exhibition->id,
                        'slug' => Str::slug($pavilionData['title']),
                    ],
                    [
                        'title' => $pavilionData['title'],
                        'description' => $pavilionData['description'],
                        'image' => $pavilionData['image'],
                        'total_halls' => $pavilionData['total_halls'],
                        'total_booths' => $pavilionData['total_booths'],
                        'status' => 'active',
                    ]
                );

                foreach ($pavilionData['halls'] as $index => [$title, $booths]) {
                    $hall = Hall::updateOrCreate(
                        [
                            'pavilion_id' => $pavilion->id,
                            'slug' => Str::slug($title),
                        ],
                        [
                            'title' => $title,
                            'description' => $pavilionData['description'],
                            'image' => $pavilionData['image'],
                            'floor_plan_image' => null,
                            'total_booths' => $booths,
                            'status' => 'active',
                        ]
                    );

                    HallBoothLayoutSync::sync($hall, $boothSizes);
                }
            }
        }
    }
}
