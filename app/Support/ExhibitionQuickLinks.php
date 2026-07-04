<?php

namespace App\Support;

class ExhibitionQuickLinks
{
    /** @return list<array{title: string, desc: string, href: string, action: string, icon: string}> */
    public static function boothLinks(): array
    {
        return [
            ['title' => 'Company Details', 'desc' => 'About the exhibitor and booth overview.', 'href' => '#company-details', 'action' => 'View Details', 'icon' => 'ph ph-buildings'],
            ['title' => 'Brochures', 'desc' => 'Download product and company brochures.', 'href' => '#brochures', 'action' => 'Download', 'icon' => 'ph ph-file-text'],
            ['title' => 'Company Video', 'desc' => 'Watch the company overview video.', 'href' => '#company-video', 'action' => 'Watch Video', 'icon' => 'ph ph-play-circle'],
            ['title' => 'Live Session', 'desc' => 'Request a one-to-one meeting with the team.', 'href' => '#meeting', 'action' => 'Request Meeting', 'icon' => 'ph ph-video-camera'],
            ['title' => 'Conference', 'desc' => 'Join upcoming booth sessions and webinars.', 'href' => '#sessions', 'action' => 'Join Session', 'icon' => 'ph ph-presentation'],
            ['title' => 'Photo Gallery', 'desc' => 'Browse booth photos and media assets.', 'href' => '#photo-gallery', 'action' => 'View Gallery', 'icon' => 'ph ph-images'],
            ['title' => 'Products', 'desc' => 'Explore products and services on display.', 'href' => '#products', 'action' => 'View Products', 'icon' => 'ph ph-package'],
        ];
    }

    /** @return list<array{title: string, desc: string, href: string, action: string, icon: string}> */
    public static function lobbyLinks(string $slug): array
    {
        return [
            ['title' => 'Participating Companies', 'desc' => 'Browse exhibitor profiles, products and booth locations.', 'href' => route('frontend.user.exhibitions.halls', $slug), 'action' => 'View Companies', 'icon' => 'ph ph-buildings'],
            ['title' => 'Floor Map & Halls', 'desc' => 'Open halls, floor plans and booth positions.', 'href' => route('frontend.user.exhibitions.halls', $slug), 'action' => 'Open Map', 'icon' => 'ph ph-map-trifold'],
            ['title' => 'Sessions & Webinars', 'desc' => 'Join live product demos and expert talks.', 'href' => route('frontend.user.dashboard', ['slug' => $slug]), 'action' => 'Join Session', 'icon' => 'ph ph-presentation'],
            ['title' => 'My Meetings', 'desc' => 'Manage one-to-one meetings with exhibitors.', 'href' => route('frontend.user.meetings'), 'action' => 'View Meetings', 'icon' => 'ph ph-video-camera'],
            ['title' => 'Notifications', 'desc' => 'Check alerts, updates and reminders.', 'href' => route('frontend.user.dashboard'), 'action' => 'Open Alerts', 'icon' => 'ph ph-bell'],
            ['title' => 'QR Pass', 'desc' => 'Open your visitor QR pass for exhibition entry.', 'href' => route('frontend.user.passes'), 'action' => 'View Pass', 'icon' => 'ph ph-qr-code'],
            ['title' => 'Visitor Dashboard', 'desc' => 'See tickets, passes, meetings and activity.', 'href' => route('frontend.user.dashboard'), 'action' => 'Open Dashboard', 'icon' => 'ph ph-gauge'],
        ];
    }
}
