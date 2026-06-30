<?php

namespace App\Support;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Visitor\Models\Visitor;
use Illuminate\Support\Facades\Auth;

class VisitorDashboardNav
{
    /** @return array{activeSlug: string, passFlowHref: string, passFlowLocked: bool, links: list<array{label: string, href: string, icon: string, active: bool}>} */
    public static function context(): array
    {
        $activeSlug = request()->route('slug')
            ?? session('activeExhibitionSlug')
            ?? Exhibition::query()->orderBy('start_date')->value('slug')
            ?? 'global-tech-expo-2024';

        $exhibition = Exhibition::query()->where('slug', $activeSlug)->first();

        $visitor = null;
        if (Auth::check() && $exhibition) {
            $visitor = Visitor::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('email', Auth::user()->email)
                ->orderByDesc('created_at')
                ->first();
        }

        $hasExhibitionPass = $visitor ? $visitor->payment_status === 'completed' : false;
        $passFlowHref = $exhibition
            ? route('exhibitions.tickets.visitor-details', $activeSlug)
            : route('frontend.user.dashboard');
        $passFlowLocked = $exhibition
            && Auth::check()
            && ! $hasExhibitionPass
            && session('exhibition_booking_path');

        return [
            'activeSlug' => $activeSlug,
            'passFlowHref' => $passFlowHref,
            'passFlowLocked' => $passFlowLocked,
            'links' => self::buildLinks($activeSlug, $exhibition, $passFlowHref, $passFlowLocked),
        ];
    }

    /** @return list<array{label: string, href: string, icon: string, active: bool}> */
    public static function links(): array
    {
        return self::context()['links'];
    }

    /** @return list<array{title: string, desc: string, href: string, action: string, icon: string}> */
    public static function quickLinks(int $limit = 7): array
    {
        return collect(self::links())
            ->reject(fn (array $link) => ($link['label'] ?? '') === 'Dashboard')
            ->take($limit)
            ->map(fn (array $link) => [
                'title' => $link['label'],
                'desc' => self::quickLinkDescription($link['label']),
                'href' => $link['href'],
                'action' => 'Open',
                'icon' => 'ph ' . $link['icon'],
            ])
            ->values()
            ->all();
    }

    /** @return list<array{label: string, href: string, icon: string, active: bool}> */
    private static function buildLinks(
        string $activeSlug,
        ?Exhibition $exhibition,
        string $passFlowHref,
        bool $passFlowLocked,
    ): array {
        $links = [
            [
                'label' => 'Dashboard',
                'href' => $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard'),
                'icon' => 'ph-chart-pie-slice',
                'active' => request()->routeIs('frontend.user.dashboard'),
            ],
        ];

        if ($exhibition) {
            $links = array_merge($links, [
                [
                    'label' => 'Exhibition Lobby',
                    'href' => route('exhibitions.visit', $activeSlug),
                    'icon' => 'ph-door-open',
                    'active' => request()->routeIs('exhibitions.visit'),
                ],
                [
                    'label' => 'Companies',
                    'href' => route('exhibitions.visitor.companies', $activeSlug),
                    'icon' => 'ph-storefront',
                    'active' => request()->routeIs('exhibitions.visitor.companies*'),
                ],
                [
                    'label' => 'Halls & Map',
                    'href' => route('exhibitions.visitor.floor-map', $activeSlug),
                    'icon' => 'ph-map-trifold',
                    'active' => request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.visitor.halls*'),
                ],
                [
                    'label' => 'Sessions',
                    'href' => route('exhibitions.visitor.sessions', $activeSlug),
                    'icon' => 'ph-play-circle',
                    'active' => request()->routeIs('exhibitions.visitor.sessions'),
                ],
                [
                    'label' => 'My Meetings',
                    'href' => route('exhibitions.visitor.meetings', $activeSlug),
                    'icon' => 'ph-calendar-check',
                    'active' => request()->routeIs('exhibitions.visitor.meetings'),
                ],
                [
                    'label' => 'Notifications',
                    'href' => route('exhibitions.visitor.notifications', $activeSlug),
                    'icon' => 'ph-bell',
                    'active' => request()->routeIs('exhibitions.visitor.notifications'),
                ],
                [
                    'label' => 'QR Pass',
                    'href' => $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.qr-pass', $activeSlug),
                    'icon' => 'ph-qr-code',
                    'active' => request()->routeIs('exhibitions.visitor.qr-pass'),
                ],
            ]);
        }

        return array_merge($links, [
            [
                'label' => 'My Passes',
                'href' => $passFlowLocked ? $passFlowHref : route('frontend.user.passes'),
                'icon' => 'ph-ticket',
                'active' => request()->routeIs('frontend.user.passes', 'frontend.user.tickets.*'),
            ],
            [
                'label' => 'Upcoming Events',
                'href' => url('/events/listings'),
                'icon' => 'ph-calendar-blank',
                'active' => request()->is('events/listings*'),
            ],
            [
                'label' => 'My Bookings',
                'href' => url('/exhibitions/booking/my-bookings'),
                'icon' => 'ph-calendar-check',
                'active' => request()->is('exhibitions/booking/my-bookings*'),
            ],
            [
                'label' => 'Profile',
                'href' => route('frontend.user.profile'),
                'icon' => 'ph-user',
                'active' => request()->routeIs('frontend.user.profile'),
            ],
        ]);
    }

    private static function quickLinkDescription(string $label): string
    {
        return match ($label) {
            'Exhibition Lobby' => 'Enter the exhibition lobby and start exploring.',
            'Companies' => 'Browse exhibitor companies and booth listings.',
            'Halls & Map' => 'Open halls, floor plans, and booth locations.',
            'Sessions' => 'View and join scheduled exhibition sessions.',
            'My Meetings' => 'Manage your booked and pending meetings.',
            'Notifications' => 'Check alerts, updates, and reminders.',
            'QR Pass' => 'Open your visitor QR pass for entry.',
            'My Passes' => 'Review all tickets and exhibition passes.',
            'Upcoming Events' => 'Discover upcoming events to book.',
            'My Bookings' => 'Track your exhibition booking history.',
            'Profile' => 'Update your visitor profile details.',
            default => 'Open this visitor dashboard section.',
        };
    }
}
