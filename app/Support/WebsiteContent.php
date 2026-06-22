<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WebsiteContent
{
    public static function publishedItems(string $page, string $sectionKey): Collection
    {
        if (! self::tableExists()) {
            return collect();
        }

        return DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public static function hero(string $page = 'home'): array
    {
        $row = self::publishedItems($page, 'hero')->first();

        if (! $row) {
            return self::defaultHero();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultHero(), [
            'title_line_1' => $row->title ?: self::defaultHero()['title_line_1'],
            'title_line_2' => $row->subtitle ?: self::defaultHero()['title_line_2'],
            'title_highlight' => $meta['title_highlight'] ?? self::defaultHero()['title_highlight'],
            'subtitle' => $row->body ?: self::defaultHero()['subtitle'],
            'image_url' => $row->image_url ?: self::defaultHero()['image_url'],
            'button_1_label' => $meta['button_1_label'] ?? ($row->link_label ?: self::defaultHero()['button_1_label']),
            'button_1_url' => $meta['button_1_url'] ?? ($row->link_url ?: self::defaultHero()['button_1_url']),
            'button_2_label' => $meta['button_2_label'] ?? self::defaultHero()['button_2_label'],
            'button_2_url' => $meta['button_2_url'] ?? self::defaultHero()['button_2_url'],
            'button_3_label' => $meta['button_3_label'] ?? self::defaultHero()['button_3_label'],
            'button_3_url' => $meta['button_3_url'] ?? self::defaultHero()['button_3_url'],
            'button_4_label' => $meta['button_4_label'] ?? self::defaultHero()['button_4_label'],
            'button_4_url' => $meta['button_4_url'] ?? self::defaultHero()['button_4_url'],
        ]);
    }

    public static function sectionOrDefaults(string $page, string $sectionKey, array $defaults): array
    {
        $items = self::publishedItems($page, $sectionKey);

        if ($items->isEmpty()) {
            return $defaults;
        }

        return $items->map(function ($row) {
            $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

            return [
                'title' => $row->title,
                'subtitle' => $row->subtitle,
                'body' => $row->body,
                'image_url' => $row->image_url,
                'link_url' => $row->link_url,
                'link_label' => $row->link_label,
                'icon' => $row->icon,
                'color' => $row->color,
                'meta' => $meta,
            ];
        })->all();
    }

    public static function cta(string $page = 'home'): array
    {
        $row = self::publishedItems($page, 'cta')->first();

        if (! $row) {
            return self::defaultCta();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultCta(), [
            'title' => $row->title ?: self::defaultCta()['title'],
            'subtitle' => $row->body ?: self::defaultCta()['subtitle'],
            'button_1_label' => $meta['button_1_label'] ?? ($row->link_label ?: self::defaultCta()['button_1_label']),
            'button_1_url' => $meta['button_1_url'] ?? ($row->link_url ?: self::defaultCta()['button_1_url']),
            'button_2_label' => $meta['button_2_label'] ?? self::defaultCta()['button_2_label'],
            'button_2_url' => $meta['button_2_url'] ?? self::defaultCta()['button_2_url'],
        ]);
    }

    public static function footer(string $page = 'home'): array
    {
        $row = self::publishedItems($page, 'footer')->first();

        if (! $row) {
            return self::defaultFooter();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultFooter(), [
            'copyright' => $row->body ?: self::defaultFooter()['copyright'],
            'links' => self::sectionOrDefaults($page, 'footer_link', self::defaultFooter()['links']),
            'social' => self::sectionOrDefaults($page, 'social', self::defaultFooter()['social']),
            'contact_email' => $meta['contact_email'] ?? self::defaultFooter()['contact_email'],
            'contact_phone' => $meta['contact_phone'] ?? self::defaultFooter()['contact_phone'],
        ]);
    }

    public static function defaultHero(): array
    {
        return [
            'title_line_1' => 'Millions of',
            'title_line_2' => 'Small Events.',
            'title_highlight' => 'Limitless Opportunities.',
            'subtitle' => 'For details and ticketing of any event - big or small. And virtual exhibitions that bring the world together, with pavilions, halls and booths - just like offline, only better.',
            'image_url' => asset('images/home/hero-expo-new-clear.png'),
            'button_1_label' => 'Explore Events',
            'button_1_url' => null,
            'button_2_label' => 'Explore Exhibitions',
            'button_2_url' => null,
            'button_3_label' => 'Book a Booth',
            'button_3_url' => null,
            'button_4_label' => 'Create Company Event',
            'button_4_url' => null,
        ];
    }

    public static function defaultCta(): array
    {
        return [
            'title' => 'Any Event. Every Audience. Everywhere.',
            'subtitle' => 'eproexpo is your all-in-one platform for events and exhibitions that connect, engage and deliver results.',
            'button_1_label' => 'Get Started Free',
            'button_1_url' => null,
            'button_2_label' => 'Exhibit Your Company',
            'button_2_url' => null,
        ];
    }

    public static function defaultFooter(): array
    {
        return [
            'copyright' => '© ' . date('Y') . ' eproexpo. All rights reserved.',
            'contact_email' => null,
            'contact_phone' => null,
            'links' => [
                ['title' => 'Privacy Policy', 'link_url' => '#'],
                ['title' => 'Terms of Service', 'link_url' => '#'],
                ['title' => 'Contact Us', 'link_url' => '#'],
            ],
            'social' => [
                ['icon' => 'fab fa-linkedin-in', 'link_url' => '#'],
                ['icon' => 'fab fa-twitter', 'link_url' => '#'],
                ['icon' => 'fab fa-facebook-f', 'link_url' => '#'],
                ['icon' => 'fab fa-youtube', 'link_url' => '#'],
            ],
        ];
    }

    public static function defaultStats(): array
    {
        return [
            ['icon' => 'far fa-calendar-check', 'color' => '#6325E6', 'title' => 'Millions', 'subtitle' => 'of Events'],
            ['icon' => 'fas fa-users', 'color' => '#FF9B41', 'title' => 'Thousands', 'subtitle' => 'of Organizers'],
            ['icon' => 'fas fa-ticket-alt', 'color' => '#3478E5', 'title' => 'Millions', 'subtitle' => 'of Tickets Sold'],
            ['icon' => 'fas fa-globe', 'color' => '#48C4AE', 'title' => 'Global', 'subtitle' => 'Community'],
        ];
    }

    public static function defaultFeaturePills(): array
    {
        return [
            ['icon' => 'far fa-comment-dots', 'title' => 'Live Chat'],
            ['icon' => 'fas fa-video', 'title' => 'Video Call'],
            ['icon' => 'far fa-file-alt', 'title' => 'Brochures'],
            ['icon' => 'far fa-question-circle', 'title' => 'Enquiries'],
            ['icon' => 'far fa-calendar-alt', 'title' => 'Appointments'],
            ['icon' => 'fas fa-trophy', 'title' => 'Leaderboard'],
        ];
    }

    public static function defaultFlowCards(): array
    {
        return [
            ['icon' => 'far fa-calendar-alt', 'color' => '#6D28D9', 'bg' => '#F4F0FF', 'title' => 'Event User Flow', 'body' => 'Explore events, view details, book tickets, and access event features.', 'link_label' => 'Open Events', 'link_url' => null, 'route' => 'events.home', 'border' => '#6D28D9'],
            ['icon' => 'far fa-building', 'color' => '#0F9F8F', 'bg' => '#E9FFF8', 'title' => 'Exhibition Visitor Flow', 'body' => 'Browse exhibitions, visit companies, get visitor pass, and open dashboard.', 'link_label' => 'Open Exhibitions', 'link_url' => '/exhibitions', 'route' => null, 'border' => '#0F9F8F'],
            ['icon' => 'fas fa-store', 'color' => '#FF8A1D', 'bg' => '#FFF4E8', 'title' => 'Exhibition Company Flow', 'body' => 'Choose an exhibition, book booth space, and manage exhibitor tools.', 'link_label' => 'Book Booth', 'link_url' => null, 'route' => 'backend.company.dashboard', 'border' => '#FF9B41'],
            ['icon' => 'fas fa-calendar-plus', 'color' => '#5B32F6', 'bg' => '#F4F0FF', 'title' => 'Event Company Flow', 'body' => 'Login as a company, create your own event, set tickets, preview, and submit for review.', 'link_label' => 'Create Event', 'link_url' => null, 'route' => 'backend.company.event-company.login', 'border' => '#5B32F6'],
        ];
    }

    public static function defaultFeatures(): array
    {
        return [
            ['icon' => 'far fa-calendar-alt', 'color' => '#8B2DE8', 'title' => "Small Events,\nBig Impact", 'body' => 'Create, manage and promote events of any size. From webinars to workshops, concerts to community meetups.'],
            ['icon' => 'fas fa-ticket-alt', 'color' => '#FF9B41', 'title' => "Details & Ticketing\nMade Simple", 'body' => 'Share event details, manage registrations and sell tickets securely with real-time analytics.'],
            ['icon' => 'fas fa-university', 'color' => '#48C4AE', 'title' => "Virtual Exhibitions\nRedefined", 'body' => 'Host stunning virtual exhibitions with pavilions, halls and booths that replicate real-world experiences.'],
            ['icon' => 'fas fa-store', 'color' => '#3478E5', 'title' => "Booths That\nEngage", 'body' => 'Exhibitors can showcase, share documents, videos and interact with visitors seamlessly.'],
            ['icon' => 'fas fa-user-friends', 'color' => '#8C2FE6', 'title' => "Networking That\nWorks", 'body' => 'Chat, meet, schedule appointments and build meaningful connections globally.'],
            ['icon' => 'fas fa-chart-bar', 'color' => '#FF9B41', 'title' => "Insights That\nMatter", 'body' => 'Track performance, visitor behavior and engagement with powerful analytics and reports.'],
        ];
    }

    public static function defaultSteps(): array
    {
        return [
            ['icon' => 'fas fa-user', 'color' => '#8B2DE8', 'step' => '1', 'title' => 'Create', 'body' => 'Sign up and create your event or exhibition in minutes.'],
            ['icon' => 'far fa-building', 'color' => '#FF9B41', 'step' => '2', 'title' => 'Customize', 'body' => 'Build your venue - pavilions, halls, booths and more.'],
            ['icon' => 'far fa-paper-plane', 'color' => '#4A5CF6', 'step' => '3', 'title' => 'Publish', 'body' => 'Share with your audience and start registrations.'],
            ['icon' => 'fas fa-users', 'color' => '#35C88D', 'step' => '4', 'title' => 'Engage', 'body' => 'Interact, network and make your event/exhibition a success.'],
        ];
    }

    public static function defaultPartners(): array
    {
        return [
            ['title' => 'Google'],
            ['title' => 'Microsoft', 'icon' => 'fab fa-microsoft'],
            ['title' => 'Deloitte.'],
            ['title' => 'P&G', 'meta' => ['style' => 'serif']],
            ['title' => 'Unilever', 'meta' => ['style' => 'unilever']],
            ['title' => 'IBM', 'meta' => ['style' => 'tracking']],
            ['title' => 'Infosys', 'meta' => ['style' => 'serif-lg']],
            ['title' => 'SIEMENS', 'meta' => ['style' => 'tracking-sm']],
            ['title' => 'accenture'],
        ];
    }

    public static function defaultCtaBenefits(): array
    {
        return [
            ['icon' => 'far fa-check-square', 'title' => 'Secure Ticketing', 'subtitle' => '100% safe & secure'],
            ['icon' => 'fas fa-chart-line', 'title' => 'Scalable Platform', 'subtitle' => 'For events of any size'],
            ['icon' => 'fas fa-globe', 'title' => 'Global Reach', 'subtitle' => 'Connect worldwide'],
            ['icon' => 'fas fa-headset', 'title' => '24/7 Support', 'subtitle' => "We're here to help"],
        ];
    }

    private static function tableExists(): bool
    {
        return DbGuard::hasTable('website_content_items');
    }
}
