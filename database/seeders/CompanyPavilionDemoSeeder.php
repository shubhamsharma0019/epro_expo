<?php

namespace Database\Seeders;

use App\Models\Exhibition;
use App\Models\Booth;
use App\Models\BoothSize;
use App\Models\Hall;
use App\Models\Pavilion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanyPavilionDemoSeeder extends Seeder
{
    public function run(): void
    {
        $exhibition = Exhibition::updateOrCreate(
            ['slug' => 'global-tech-expo-2024'],
            [
                'title' => 'Global Tech Expo 2024',
                'description' => 'A premium exhibition for technology, business, healthcare, education, sustainability, and mobility companies.',
                'location' => 'Virtual Expo',
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-14',
                'banner_image' => 'images/exhibitions/hero-book-exhibition.png',
                'status' => 'active',
            ]
        );

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

        $boothPositions = [
            [18, 28, 'reserved'], [78, 30, 'reserved'], [138, 30, 'reserved'], [198, 30, 'reserved'], [258, 30, 'reserved'], [318, 30, 'reserved'], [386, 30, 'available'], [446, 30, 'available'], [506, 30, 'available'], [640, 28, 'reserved'],
            [18, 82, 'available'], [640, 82, 'available'], [18, 136, 'available'], [640, 136, 'available'], [18, 190, 'available'], [640, 190, 'available'], [18, 244, 'available'], [640, 244, 'available'], [18, 304, 'reserved'], [640, 304, 'reserved'],
            [120, 122, 'available'], [250, 122, 'available'], [380, 122, 'available'], [510, 122, 'booked'], [78, 248, 'available'], [138, 248, 'available'], [198, 248, 'reserved'], [258, 248, 'reserved'], [318, 248, 'reserved'], [386, 248, 'reserved'],
            [446, 248, 'available'], [506, 248, 'available'], [78, 306, 'available'], [138, 306, 'available'], [198, 306, 'reserved'], [258, 306, 'reserved'], [318, 306, 'available'], [386, 306, 'available'], [446, 306, 'available'], [506, 306, 'available'],
        ];

        $pavilions = [
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
        ];

        foreach ($pavilions as $pavilionData) {
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

                foreach ($boothPositions as $positionIndex => [$x, $y, $status]) {
                    $boothSize = $boothSizes[$positionIndex % $boothSizes->count()];
                    $boothNumber = 'B' . str_pad((string) ($positionIndex + 1), 2, '0', STR_PAD_LEFT);

                    Booth::updateOrCreate(
                        [
                            'hall_id' => $hall->id,
                            'booth_number' => $boothNumber,
                        ],
                        [
                            'booth_size_id' => $boothSize->id,
                            'position_x' => $x,
                            'position_y' => $y,
                            'price' => $boothSize->price,
                            'status' => $status,
                        ]
                    );
                }
            }
        }
    }
}
