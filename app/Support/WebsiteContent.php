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
        $defaults = $page === 'events'
            ? self::defaultEventsHero()
            : self::defaultHero();

        $row = self::publishedItems($page, 'hero')->first();

        if (! $row) {
            return $defaults;
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        if ($page === 'events') {
            return array_merge($defaults, [
                'eyebrow' => $row->subtitle ?: $defaults['eyebrow'],
                'page_title' => $row->title ?: ($defaults['page_title'] ?? 'eproexpo — Discover Events. Book Tickets. Join Live.'),
                'title_line_1' => $meta['title_line_1'] ?? $defaults['title_line_1'],
                'title_accent_1' => $meta['title_accent_1'] ?? $defaults['title_accent_1'],
                'title_line_2' => $meta['title_line_2'] ?? $defaults['title_line_2'],
                'title_accent_2' => $meta['title_accent_2'] ?? $defaults['title_accent_2'],
                'title_line_3' => $meta['title_line_3'] ?? $defaults['title_line_3'],
                'subtitle' => $row->body ?: $defaults['subtitle'],
                'subtitle_template' => $meta['subtitle_template'] ?? $defaults['subtitle_template'],
                'page_font_family' => $meta['page_font_family'] ?? $defaults['page_font_family'],
                'heading_font_family' => $meta['heading_font_family'] ?? $defaults['heading_font_family'],
                'hero_gradient' => $meta['hero_gradient'] ?? $defaults['hero_gradient'],
                'nav_font_family' => $meta['nav_font_family'] ?? $defaults['nav_font_family'],
                'nav_font_size' => $meta['nav_font_size'] ?? $defaults['nav_font_size'],
                'nav_font_weight' => $meta['nav_font_weight'] ?? $defaults['nav_font_weight'],
                'hero_heading_color' => $meta['hero_heading_color'] ?? $defaults['hero_heading_color'],
                'hero_accent_color' => $meta['hero_accent_color'] ?? $defaults['hero_accent_color'],
                'hero_body_color' => $meta['hero_body_color'] ?? $defaults['hero_body_color'],
                'hero_eyebrow_bg' => $meta['hero_eyebrow_bg'] ?? $defaults['hero_eyebrow_bg'],
                'hero_eyebrow_color' => $meta['hero_eyebrow_color'] ?? $defaults['hero_eyebrow_color'],
                'hero_eyebrow_border' => $meta['hero_eyebrow_border'] ?? $defaults['hero_eyebrow_border'],
            ]);
        }

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

    public static function featuresHero(): array
    {
        $row = self::publishedItems('features', 'hero')->first();

        if (! $row) {
            return self::defaultFeaturesHero();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultFeaturesHero(), [
            'eyebrow' => $row->subtitle ?: self::defaultFeaturesHero()['eyebrow'],
            'title' => $row->title ?: self::defaultFeaturesHero()['title'],
            'subtitle' => $row->body ?: self::defaultFeaturesHero()['subtitle'],
            'button_1_label' => $meta['button_1_label'] ?? self::defaultFeaturesHero()['button_1_label'],
            'button_1_url' => $meta['button_1_url'] ?? self::defaultFeaturesHero()['button_1_url'],
            'button_2_label' => $meta['button_2_label'] ?? self::defaultFeaturesHero()['button_2_label'],
            'button_2_url' => $meta['button_2_url'] ?? self::defaultFeaturesHero()['button_2_url'],
            'cta_title' => $meta['cta_title'] ?? self::defaultFeaturesHero()['cta_title'],
            'cta_subtitle' => $meta['cta_subtitle'] ?? self::defaultFeaturesHero()['cta_subtitle'],
        ]);
    }

    public static function featuresSectionHeadings(): array
    {
        $row = self::publishedItems('features', 'section_headings')->first();

        if (! $row) {
            return self::defaultFeaturesSectionHeadings();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultFeaturesSectionHeadings(), array_filter($meta, fn ($value) => $value !== null && $value !== ''));
    }

    public static function defaultFeaturesHero(): array
    {
        return [
            'eyebrow' => 'Platform features',
            'title' => 'Everything you need to run events & exhibitions',
            'subtitle' => 'From self-serve event creation to large-scale virtual expos, eproexpo gives organisers, exhibitors, and visitors one connected platform for building, publishing, and growing live experiences.',
            'button_1_label' => 'Explore Events',
            'button_1_url' => null,
            'button_2_label' => 'Browse Exhibitions',
            'button_2_url' => null,
            'cta_title' => 'Ready to explore the platform?',
            'cta_subtitle' => 'Start with events, exhibitions, or a program that grows with your ambition.',
        ];
    }

    public static function defaultFeaturesSectionHeadings(): array
    {
        return [
            'audience_eyebrow' => 'Built for every audience',
            'audience_title' => 'Tools tuned to real event experiences',
            'audience_subtitle' => 'Powerful tools for event organisers, exhibition companies, and visitors — all in one seamless experience.',
            'steps_eyebrow' => 'How it works',
            'steps_title' => 'From setup to a live event, in four steps',
            'flows_eyebrow' => 'User flows',
            'flows_title' => 'Built for every role in the room',
            'cta_eyebrow' => 'Get started',
        ];
    }

    public static function pricingHero(): array
    {
        $row = self::publishedItems('pricing', 'hero')->first();

        if (! $row) {
            return self::defaultPricingHero();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultPricingHero(), [
            'eyebrow' => $row->subtitle ?: self::defaultPricingHero()['eyebrow'],
            'title' => $row->title ?: self::defaultPricingHero()['title'],
            'subtitle' => $row->body ?: self::defaultPricingHero()['subtitle'],
            'toggle_1_label' => $meta['toggle_1_label'] ?? self::defaultPricingHero()['toggle_1_label'],
            'toggle_2_label' => $meta['toggle_2_label'] ?? self::defaultPricingHero()['toggle_2_label'],
            'cta_title' => $meta['cta_title'] ?? self::defaultPricingHero()['cta_title'],
            'cta_subtitle' => $meta['cta_subtitle'] ?? self::defaultPricingHero()['cta_subtitle'],
            'button_1_label' => $meta['button_1_label'] ?? self::defaultPricingHero()['button_1_label'],
            'button_1_url' => $meta['button_1_url'] ?? self::defaultPricingHero()['button_1_url'],
            'button_2_label' => $meta['button_2_label'] ?? self::defaultPricingHero()['button_2_label'],
            'button_2_url' => $meta['button_2_url'] ?? self::defaultPricingHero()['button_2_url'],
            'contact_email' => $meta['contact_email'] ?? self::defaultPricingHero()['contact_email'],
        ]);
    }

    public static function pricingSectionHeadings(): array
    {
        $row = self::publishedItems('pricing', 'section_headings')->first();

        if (! $row) {
            return self::defaultPricingSectionHeadings();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultPricingSectionHeadings(), array_filter($meta, fn ($value) => $value !== null && $value !== ''));
    }

    public static function pricingPlans(): array
    {
        $items = self::sectionOrDefaults('pricing', 'pricing_plan', self::defaultPricingPlans());

        return array_map(fn (array $plan) => self::normalizePricingPlan($plan), $items);
    }

    public static function pricingFaqs(): array
    {
        $items = self::sectionOrDefaults('pricing', 'pricing_faq', self::defaultPricingFaqs());

        return array_map(fn (array $faq) => [
            'q' => $faq['title'] ?? '',
            'a' => $faq['body'] ?? '',
        ], $items);
    }

    public static function pricingBenefits(): array
    {
        return self::sectionOrDefaults('pricing', 'pricing_benefit', self::defaultPricingBenefits());
    }

    public static function defaultPricingHero(): array
    {
        return [
            'eyebrow' => 'Simple pricing',
            'title' => 'Flexible Pricing Plans',
            'subtitle' => 'Start for events, then expand as you grow. Flexible packages for exhibitions, teams, and enterprise reach.',
            'toggle_1_label' => 'Per Event',
            'toggle_2_label' => 'Annual',
            'cta_title' => 'Any event. Every audience. Everywhere.',
            'cta_subtitle' => 'Join thousands of organisers and exhibitors already reaching new audiences on eproexpo.',
            'button_1_label' => 'Create Event',
            'button_1_url' => null,
            'button_2_label' => 'Book a Demo',
            'button_2_url' => null,
            'contact_email' => null,
        ];
    }

    public static function defaultPricingSectionHeadings(): array
    {
        return [
            'why_eyebrow' => 'Why eproexpo',
            'why_title' => 'Why teams choose eproexpo',
            'faq_eyebrow' => 'Integrated functionality',
            'faq_title' => 'Frequently asked questions',
            'faq_card_title' => 'Still have a question?',
            'faq_card_body' => "Can't find the answer you're looking for? Send us an email and we'll get back to you as soon as possible.",
            'cta_eyebrow' => 'Start today',
        ];
    }

    public static function defaultPricingPlans(): array
    {
        return [
            [
                'title' => 'Starter Plan',
                'subtitle' => 'Perfect for small teams and startups',
                'icon' => 'far fa-ticket-alt',
                'link_label' => 'Get Started Free',
                'link_url' => null,
                'meta' => [
                    'price' => '$0',
                    'period' => '/event',
                    'annual_price' => '$0',
                    'annual_period' => '/year',
                    'highlight' => false,
                    'route' => 'company.event-company.login',
                    'features' => [
                        'Create and publish events',
                        'Basic ticketing & RSVP tools',
                        'Event page and one booth',
                        'Email support',
                    ],
                ],
            ],
            [
                'title' => 'Professional Plan',
                'subtitle' => 'Perfect for growing organisers',
                'icon' => 'fas fa-bolt',
                'link_label' => 'Talk to Sales',
                'link_url' => null,
                'meta' => [
                    'price' => 'Custom',
                    'period' => '/event',
                    'annual_price' => 'Custom',
                    'annual_period' => '/year',
                    'highlight' => true,
                    'route' => 'events.home',
                    'features' => [
                        'Full suite of analytics tools',
                        'Multi-hall virtual exhibitions',
                        'Live chat, booths & appointments',
                        'Priority email support',
                    ],
                ],
            ],
            [
                'title' => 'Enterprise Plan',
                'subtitle' => 'Solution for Large Organisations',
                'icon' => 'far fa-building',
                'link_label' => 'Contact Us',
                'link_url' => '/about#contact',
                'meta' => [
                    'price' => 'Custom',
                    'period' => '/event',
                    'annual_price' => 'Custom',
                    'annual_period' => '/year',
                    'highlight' => false,
                    'route' => null,
                    'features' => [
                        'Dedicated account manager',
                        'Custom integrations & SSO',
                        '24/7 dedicated support',
                        'Custom data storage options',
                    ],
                ],
            ],
        ];
    }

    public static function defaultPricingFaqs(): array
    {
        return [
            ['title' => 'Can I start for free?', 'body' => 'Yes. You can create and publish standard events at no charge for as long as you like, no card required.'],
            ['title' => 'Do I need to upgrade to run an exhibition?', 'body' => 'Standard exhibitions support one hall and basic booths — upgrade to Professional to unlock multi-hall exhibitions.'],
            ['title' => 'Is ticketing secure?', 'body' => 'All payments are processed through PCI-compliant checkout, and every transaction is encrypted end-to-end.'],
            ['title' => 'Can exhibitors book booths online?', 'body' => 'Yes — exhibitors can browse available booth types, compare packages, and book instantly online.'],
        ];
    }

    public static function defaultPricingBenefits(): array
    {
        return [
            ['icon' => 'fas fa-lock', 'title' => 'Secure Ticketing', 'body' => 'PCI-compliant checkout, every time.'],
            ['icon' => 'fas fa-shield-alt', 'title' => 'Reliable Platform', 'body' => '99.9% uptime across every event.'],
            ['icon' => 'fas fa-bolt', 'title' => 'Instant Reach', 'body' => 'Publish and go live in minutes.'],
            ['icon' => 'fas fa-headset', 'title' => '24/7 Support', 'body' => 'Real humans, whenever you need.'],
        ];
    }

    private static function normalizePricingPlan(array $plan): array
    {
        $meta = $plan['meta'] ?? [];
        $url = null;

        if (! empty($meta['route'])) {
            try {
                $url = route($meta['route']);
            } catch (\Throwable) {
                $url = null;
            }
        }

        if (! $url && filled($plan['link_url'] ?? null)) {
            $linkUrl = (string) $plan['link_url'];
            if (str_starts_with($linkUrl, 'http://') || str_starts_with($linkUrl, 'https://')) {
                $url = $linkUrl;
            } elseif (str_starts_with($linkUrl, '/')) {
                $url = url($linkUrl);
            } else {
                try {
                    $url = route($linkUrl);
                } catch (\Throwable) {
                    $url = url($linkUrl);
                }
            }
        }

        return [
            'name' => $plan['title'] ?? '',
            'description' => $plan['subtitle'] ?? '',
            'price' => $meta['price'] ?? 'Custom',
            'period' => $meta['period'] ?? '/event',
            'annual_price' => $meta['annual_price'] ?? ($meta['price'] ?? 'Custom'),
            'annual_period' => $meta['annual_period'] ?? '/year',
            'highlight' => (bool) ($meta['highlight'] ?? false),
            'features' => $meta['features'] ?? [],
            'button' => $plan['link_label'] ?? 'Get Started',
            'url' => $url ?: route('company.event-company.login'),
            'icon' => $plan['icon'] ?? 'far fa-circle',
        ];
    }

    public static function aboutHero(): array
    {
        $row = self::publishedItems('about', 'hero')->first();

        if (! $row) {
            return self::defaultAboutHero();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultAboutHero(), [
            'eyebrow' => $row->subtitle ?: self::defaultAboutHero()['eyebrow'],
            'title' => $row->title ?: self::defaultAboutHero()['title'],
            'subtitle' => $row->body ?: self::defaultAboutHero()['subtitle'],
            'button_1_label' => $meta['button_1_label'] ?? self::defaultAboutHero()['button_1_label'],
            'button_1_url' => $meta['button_1_url'] ?? self::defaultAboutHero()['button_1_url'],
            'button_2_label' => $meta['button_2_label'] ?? self::defaultAboutHero()['button_2_label'],
            'button_2_url' => $meta['button_2_url'] ?? self::defaultAboutHero()['button_2_url'],
            'cta_title' => $meta['cta_title'] ?? self::defaultAboutHero()['cta_title'],
            'cta_subtitle' => $meta['cta_subtitle'] ?? self::defaultAboutHero()['cta_subtitle'],
            'cta_button_1_label' => $meta['cta_button_1_label'] ?? self::defaultAboutHero()['cta_button_1_label'],
            'cta_button_1_url' => $meta['cta_button_1_url'] ?? self::defaultAboutHero()['cta_button_1_url'],
            'cta_button_2_label' => $meta['cta_button_2_label'] ?? self::defaultAboutHero()['cta_button_2_label'],
            'cta_button_2_url' => $meta['cta_button_2_url'] ?? self::defaultAboutHero()['cta_button_2_url'],
            'contact_email' => $meta['contact_email'] ?? null,
        ]);
    }

    public static function aboutSectionHeadings(): array
    {
        $row = self::publishedItems('about', 'section_headings')->first();

        if (! $row) {
            return self::defaultAboutSectionHeadings();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultAboutSectionHeadings(), array_filter($meta, fn ($value) => $value !== null && $value !== ''));
    }

    public static function aboutValues(): array
    {
        return self::sectionOrDefaults('about', 'about_value', self::defaultAboutValues());
    }

    public static function aboutStats(): array
    {
        return self::sectionOrDefaults('about', 'about_stat', self::defaultAboutStats());
    }

    public static function aboutMilestones(): array
    {
        $items = self::sectionOrDefaults('about', 'about_milestone', self::defaultAboutMilestones());

        return array_map(fn (array $item) => [
            'year' => $item['subtitle'] ?? ($item['meta']['year'] ?? ''),
            'title' => $item['title'] ?? '',
            'body' => $item['body'] ?? '',
        ], $items);
    }

    public static function aboutPartners(): array
    {
        return self::sectionOrDefaults('about', 'about_partner', self::defaultAboutPartners());
    }

    public static function defaultAboutHero(): array
    {
        return [
            'eyebrow' => 'About eproexpo',
            'title' => 'Connecting the world through events & exhibitions',
            'subtitle' => 'eproexpo is an all-in-one platform for virtual events and exhibitions. We help organisers publish events, sell tickets, and engage audiences — while enabling companies to showcase products in immersive booth experiences.',
            'button_1_label' => 'Explore Events',
            'button_1_url' => null,
            'button_2_label' => 'View Features',
            'button_2_url' => null,
            'cta_title' => 'Connect. Explore. Engage.',
            'cta_subtitle' => 'Ready to learn more or partner with us? Start exploring events and exhibitions today.',
            'cta_button_1_label' => 'Explore Events',
            'cta_button_1_url' => null,
            'cta_button_2_label' => 'View Features',
            'cta_button_2_url' => null,
        ];
    }

    public static function defaultAboutSectionHeadings(): array
    {
        return [
            'stats_eyebrow' => 'By the Numbers',
            'stats_title' => 'Platform at a glance',
            'journey_eyebrow' => 'Our Journey',
            'journey_title' => 'Building the future of connected events',
            'partners_title' => 'Trusted by organisations worldwide',
            'cta_eyebrow' => 'Get connected',
        ];
    }

    public static function defaultAboutValues(): array
    {
        return [
            ['icon' => 'fas fa-bullseye', 'color' => '#6D28D9', 'title' => 'Our Mission', 'body' => 'To connect people, companies, and communities through seamless virtual events and exhibitions that bring real value to every interaction.'],
            ['icon' => 'fas fa-rocket', 'color' => '#6D28D9', 'title' => 'Our Vision', 'body' => 'A world where every event — big or small — can host its most impactful audience, without the barriers of distance or infrastructure.'],
            ['icon' => 'fas fa-gem', 'color' => '#6D28D9', 'title' => 'Our Values', 'body' => 'Innovation, accountability, trust, and authentic connection — everything we build is engineered around forming lasting engagement.'],
        ];
    }

    public static function defaultAboutStats(): array
    {
        return [
            ['title' => '3.2M+', 'subtitle' => 'Events Hosted'],
            ['title' => '18K+', 'subtitle' => 'Organisers'],
            ['title' => '7.4M+', 'subtitle' => 'Tickets Sold'],
            ['title' => '120+', 'subtitle' => 'Countries'],
        ];
    }

    public static function defaultAboutMilestones(): array
    {
        return [
            ['subtitle' => '2021', 'title' => 'Platform Launch', 'body' => 'Standard events with a lean toolkit meant for scaling organisers of every size.'],
            ['subtitle' => '2022', 'title' => 'Virtual Exhibitions', 'body' => 'Immersive pavilions, halls, and interactive booths for global exhibitors.'],
            ['subtitle' => '2023', 'title' => 'Global Growth', 'body' => 'Expansion to enterprise organisers, exhibitors, and visitors across 120+ countries.'],
            ['subtitle' => '2024', 'title' => 'All-in-One Platform', 'body' => 'Unified events, exhibitions, ticketing, networking, and analytics under one roof.'],
        ];
    }

    public static function defaultAboutPartners(): array
    {
        return [
            ['title' => 'Google'],
            ['title' => 'Microsoft'],
            ['title' => 'Deloitte'],
            ['title' => 'P&G'],
            ['title' => 'UBS'],
            ['title' => 'IBM'],
            ['title' => 'Infosys'],
            ['title' => 'SIEMENS'],
            ['title' => 'accenture'],
        ];
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

    public static function defaultEventsHero(): array
    {
        return array_merge([
            'page_title' => 'eproexpo — Discover Events. Book Tickets. Join Live.',
            'eyebrow' => 'Live events, near you',
            'title_line_1' => 'Discover',
            'title_accent_1' => 'Events.',
            'title_line_2' => 'Book',
            'title_accent_2' => 'Tickets.',
            'title_line_3' => 'Join Live.',
            'subtitle' => 'Explore events across categories and countries. Book tickets and get access to live sessions in one seamless platform.',
            'subtitle_template' => 'Explore {event_count} live events across {category_count} categories and {country_count} countries. Book tickets and get access to live sessions in one seamless platform.',
        ], self::defaultEventsHeroTheme());
    }

  /** @return array<string, string> */
    public static function defaultEventsHeroTheme(): array
    {
        return [
            'hero_gradient' => 'linear-gradient(135deg, #F6F3FF 0%, #EFE9FE 30%, #F8FAFF 68%, #FFFFFF 100%)',
            'page_font_family' => 'Inter, sans-serif',
            'heading_font_family' => 'Inter, sans-serif',
            'nav_font_family' => 'Inter, sans-serif',
            'nav_font_size' => '14px',
            'nav_font_weight' => '600',
            'hero_heading_color' => '#071044',
            'hero_accent_color' => '#6D28D9',
            'hero_body_color' => '#1F2B55',
            'hero_eyebrow_bg' => 'rgba(109, 40, 217, 0.08)',
            'hero_eyebrow_color' => '#6D28D9',
            'hero_eyebrow_border' => 'rgba(109, 40, 217, 0.18)',
        ];
    }

    public static function defaultEventsSteps(): array
    {
        return [
            ['title' => 'Find Your Event', 'body' => 'Browse events by category, location, or specific topics.'],
            ['title' => 'Choose Your Slot', 'body' => 'Select your preferred time slot for available dates.'],
            ['title' => 'Book & Pay', 'body' => 'Secure your spot with a quick and safe checkout.'],
            ['title' => 'Get Your Ticket', 'body' => 'Receive your e-ticket instantly and enjoy the show.'],
        ];
    }

    public static function eventsSections(): array
    {
        $defaults = self::defaultEventsSections();
        $row = self::publishedItems('events', 'sections')->first();

        if (! $row) {
            return $defaults;
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge($defaults, $meta);
    }

    public static function defaultEventsSections(): array
    {
        return [
            'page_title' => 'eproexpo — Discover Events. Book Tickets. Join Live.',
            'search_tab_events' => 'Events',
            'search_tab_exhibitions' => 'Exhibitions',
            'search_label' => 'Search Events',
            'search_placeholder' => 'Search events, organisers...',
            'category_label' => 'Category',
            'category_all' => 'All Categories',
            'country_label' => 'Country',
            'country_all' => 'All Countries',
            'date_label' => 'Date',
            'date_placeholder' => 'mm/dd/yyyy',
            'search_button' => 'Search Events',
            'categories_title' => 'Browse Events by Category',
            'categories_link' => 'View All Categories →',
            'categories_link_url' => '/events/listings/categories',
            'trending_title' => 'Trending Events',
            'trending_link' => 'View All Events →',
            'how_it_works_title' => 'How It Works',
            'slots_title' => 'Ticket Booking & Slots',
            'slots_fallback_event' => 'Upcoming Events',
            'slots_cta' => 'View More Slots',
            'empty_categories_title' => 'No categories yet',
            'empty_categories_body' => 'Published events will populate categories automatically.',
            'empty_events_title' => 'No published events yet',
            'empty_events_body' => 'Published company events will appear here automatically.',
            'empty_slots_title' => 'No ticket slots available yet',
            'empty_slots_body' => 'Published events with dates will appear here.',
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
            ['icon' => 'far fa-calendar-alt', 'color' => '#6D28D9', 'bg' => '#F4F0FF', 'title' => 'Event User Flow', 'body' => 'Browse events, secure a ticket, and join live sessions — all from one visitor dashboard.', 'link_label' => 'Open Guide', 'link_url' => null, 'route' => 'events.home', 'border' => '#6D28D9', 'meta' => ['headline' => 'Discover, register, and attend']],
            ['icon' => 'far fa-building', 'color' => '#0F9F8F', 'bg' => '#E9FFF8', 'title' => 'Exhibition Visitor Flow', 'body' => 'Walk virtual halls, chat with exhibitors, and collect brochures in one visit.', 'link_label' => 'Open Guide', 'link_url' => '/exhibitions', 'route' => null, 'border' => '#0F9F8F', 'meta' => ['headline' => 'Explore halls and connect with booths']],
            ['icon' => 'fas fa-store', 'color' => '#FF8A1D', 'bg' => '#FFF4E8', 'title' => 'Exhibition Company Flow', 'body' => 'Set up your booth, upload assets, and manage incoming visitor leads live.', 'link_label' => 'Book Booth', 'link_url' => null, 'route' => 'company.dashboard', 'border' => '#FF9B41', 'meta' => ['headline' => 'Design your booth and manage leads']],
            ['icon' => 'fas fa-calendar-plus', 'color' => '#5B32F6', 'bg' => '#F4F0FF', 'title' => 'Event Company Flow', 'body' => 'Create your event, sell tickets, and support attendees end-to-end.', 'link_label' => 'Get Started', 'link_url' => null, 'route' => 'company.event-company.login', 'border' => '#5B32F6', 'meta' => ['headline' => 'Publish, sell, and support attendees']],
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

    public static function sectionHeadings(string $page = 'home'): array
    {
        $row = self::publishedItems($page, 'section_headings')->first();

        if (! $row) {
            return self::defaultSectionHeadings();
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge(self::defaultSectionHeadings(), array_filter($meta, fn ($value) => $value !== null && $value !== ''));
    }

    public static function defaultSectionHeadings(): array
    {
        return [
            'features_title' => 'Everything You Need, In One Platform',
            'how_it_works_title' => 'How It Works',
            'experience_title' => 'Virtual Exhibition Experience',
            'partners_title' => 'Trusted by Organizations Worldwide',
            'featured_events_title' => 'Featured Events',
            'featured_events_subtitle' => 'Discover upcoming events curated for you.',
            'featured_exhibitions_title' => 'Featured Exhibitions',
            'featured_exhibitions_subtitle' => 'Explore live virtual expos and meet top companies.',
            'get_started_label' => 'Get Started',
            'get_started_url' => null,
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

    public static function homeBoothPreviewSettings(): array
    {
        $defaults = [
            'demo_only' => true,
            'label' => 'Demo preview',
        ];

        $row = self::publishedItems('home', 'booth_preview')->first();
        if (! $row) {
            return $defaults;
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];

        return array_merge($defaults, $meta);
    }

    private static function tableExists(): bool
    {
        return DbGuard::hasTable('website_content_items');
    }
}
