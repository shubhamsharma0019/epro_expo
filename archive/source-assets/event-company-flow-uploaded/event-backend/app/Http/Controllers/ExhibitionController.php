<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use App\Models\Exhibitor;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    /**
     * Get all exhibitions. Seeds mock records if database is empty.
     */
    public function index()
    {
        $exhibitions = Exhibition::all();

        if ($exhibitions->isEmpty()) {
            $mockExhibitions = [
                [
                    'name' => 'Global Tech Summit 2024',
                    'start_date' => '2026-05-15',
                    'end_date' => '2026-05-17',
                    'venue' => 'Jio World Convention Centre, Mumbai, India',
                    'description' => 'Experience next-generation tech breakthroughs in enterprise systems and engineering.',
                    'companies_count' => 120,
                    'banner_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ],
                [
                    'name' => 'Future of AI Expo',
                    'start_date' => '2026-06-10',
                    'end_date' => '2026-06-12',
                    'venue' => 'Bengaluru Convention Centre, Bengaluru, India',
                    'description' => 'Explore deep neural structures, machine learning platforms, and automation algorithms.',
                    'companies_count' => 80,
                    'banner_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ],
                [
                    'name' => 'Sustainability World Expo',
                    'start_date' => '2026-08-08',
                    'end_date' => '2026-08-10',
                    'venue' => 'Pune International Exhibition Centre, Pune, India',
                    'description' => 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.',
                    'companies_count' => 85,
                    'banner_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ];

            foreach ($mockExhibitions as $mock) {
                Exhibition::create($mock);
            }

            $exhibitions = Exhibition::all();
        }

        return response()->json($exhibitions);
    }

    /**
     * Get specific exhibition details.
     */
    public function show($id)
    {
        $exhibition = Exhibition::find($id);

        if (!$exhibition) {
            // Find by name if id is not numeric (matches page titles)
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }

        if (!$exhibition) {
            return response()->json(['message' => 'Exhibition not found'], 404);
        }

        return response()->json($exhibition);
    }

    /**
     * Get exhibitors for an exhibition. Seeds mock booths if empty.
     */
    public function getExhibitors($exhibition_id)
    {
        // Resolve exhibition ID
        $exhibition = Exhibition::find($exhibition_id);
        if (!$exhibition) {
            $exhibition = Exhibition::orderBy('created_at', 'asc')->first();
        }
        
        $exhibitionId = $exhibition ? $exhibition->id : null;

        $exhibitors = Exhibitor::where('exhibition_id', $exhibitionId)->get();

        if ($exhibitors->isEmpty() && $exhibitionId) {
            $mockExhibitors = [
                [
                    'exhibition_id' => $exhibitionId,
                    'hall_name' => 'Hall 1 - AI & IA',
                    'booth_number' => 'Booth 101',
                    'name' => 'TechNext Solutions Pvt. Ltd.',
                    'category' => 'AI & Automation',
                    'description' => 'Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.',
                    'website' => 'www.technext.com',
                    'email' => 'info@technext.com',
                    'country' => 'India',
                    'rep_name' => 'Rahul Sharma',
                    'rep_title' => 'Business Development Manager',
                    'rep_email' => 'rahul.sharma@technext.com',
                    'rep_phone' => '+91 98765 43210',
                    'rep_img_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
                    'logo_color' => 'bg-blue-500',
                    'logo_text' => 'TN'
                ],
                [
                    'exhibition_id' => $exhibitionId,
                    'hall_name' => 'Hall 1 - AI & IA',
                    'booth_number' => 'Booth 102',
                    'name' => 'InnovaAI Labs',
                    'category' => 'Machine Learning',
                    'description' => 'Building intelligent models for real-world impact and actionable data analytics.',
                    'website' => 'www.innovaalabs.com',
                    'email' => 'contact@innovaalabs.com',
                    'country' => 'United States',
                    'rep_name' => 'Sarah Jenkins',
                    'rep_title' => 'Lead Data Scientist',
                    'rep_email' => 'sarah.j@innovaalabs.com',
                    'rep_phone' => '+1 555-0198',
                    'rep_img_url' => 'https://randomuser.me/api/portraits/women/44.jpg',
                    'logo_color' => 'bg-indigo-600',
                    'logo_text' => '<i class="ph-fill ph-chart-bar"></i>'
                ],
                [
                    'exhibition_id' => $exhibitionId,
                    'hall_name' => 'Hall 1 - AI & IA',
                    'booth_number' => 'Booth 103',
                    'name' => 'DataMind Analytics',
                    'category' => 'Data & Analytics',
                    'description' => 'Data analytics platforms for smarter decisions and operational intelligence.',
                    'website' => 'www.datamind.io',
                    'email' => 'hello@datamind.io',
                    'country' => 'United Kingdom',
                    'rep_name' => 'David Chen',
                    'rep_title' => 'VP of Sales',
                    'rep_email' => 'david.c@datamind.io',
                    'rep_phone' => '+44 20 7123 4567',
                    'rep_img_url' => 'https://randomuser.me/api/portraits/men/62.jpg',
                    'logo_color' => 'bg-blue-600',
                    'logo_text' => '<i class="ph-fill ph-database mr-1"></i> DM'
                ],
                [
                    'exhibition_id' => $exhibitionId,
                    'hall_name' => 'Hall 1 - AI & IA',
                    'booth_number' => 'Booth 104',
                    'name' => 'CloudSphere Tech',
                    'category' => 'Cloud Computing',
                    'description' => 'Scalable cloud solutions for modern businesses.',
                    'website' => 'www.cloudsphere.tech',
                    'email' => 'support@cloudsphere.tech',
                    'country' => 'Canada',
                    'rep_name' => 'Elena Rodriguez',
                    'rep_title' => 'Cloud Solutions Architect',
                    'rep_email' => 'elena.r@cloudsphere.tech',
                    'rep_phone' => '+1 416 555 0192',
                    'rep_img_url' => 'https://randomuser.me/api/portraits/women/68.jpg',
                    'logo_color' => 'bg-[#0F172A]',
                    'logo_text' => '<i class="ph-fill ph-cloud text-sky-400"></i>'
                ]
            ];

            foreach ($mockExhibitors as $mock) {
                Exhibitor::create($mock);
            }

            $exhibitors = Exhibitor::where('exhibition_id', $exhibitionId)->get();
        }

        return response()->json($exhibitors);
    }

    /**
     * Get individual exhibitor details.
     */
    public function showExhibitor($id)
    {
        $exhibitor = Exhibitor::find($id);

        if (!$exhibitor) {
            // Find by booth or name matches
            $exhibitor = Exhibitor::where('booth_number', $id)->orWhere('name', 'like', '%' . $id . '%')->first();
        }

        if (!$exhibitor) {
            return response()->json(['message' => 'Exhibitor not found'], 404);
        }

        return response()->json($exhibitor);
    }
}
