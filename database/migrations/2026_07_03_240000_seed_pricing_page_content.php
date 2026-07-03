<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $now = now();

        $this->upsertSingleton('pricing', 'hero', [
            'subtitle' => 'Simple pricing',
            'title' => 'Flexible Pricing Plans',
            'body' => 'Start for events, then expand as you grow. Flexible packages for exhibitions, teams, and enterprise reach.',
            'meta' => json_encode([
                'toggle_1_label' => 'Per Event',
                'toggle_2_label' => 'Annual',
                'cta_title' => 'Any event. Every audience. Everywhere.',
                'cta_subtitle' => 'Join thousands of organisers and exhibitors already reaching new audiences on eproexpo.',
                'button_1_label' => 'Create Event',
                'button_1_url' => '/company/event-company/login',
                'button_2_label' => 'Book a Demo',
                'button_2_url' => '/company',
                'contact_email' => 'hello@eproexpo.com',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $this->upsertSingleton('pricing', 'section_headings', [
            'meta' => json_encode([
                'why_eyebrow' => 'Why eproexpo',
                'why_title' => 'Why teams choose eproexpo',
                'faq_eyebrow' => 'Integrated functionality',
                'faq_title' => 'Frequently asked questions',
                'faq_card_title' => 'Still have a question?',
                'faq_card_body' => "Can't find the answer you're looking for? Send us an email and we'll get back to you as soon as possible.",
                'cta_eyebrow' => 'Start today',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $plans = [
            [
                'title' => 'Starter Plan',
                'subtitle' => 'Perfect for small teams and startups',
                'icon' => 'far fa-ticket-alt',
                'link_label' => 'Get Started Free',
                'link_url' => null,
                'sort_order' => 1,
                'meta' => [
                    'price' => '$0',
                    'period' => '/event',
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
                'sort_order' => 2,
                'meta' => [
                    'price' => 'Custom',
                    'period' => '/event',
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
                'sort_order' => 3,
                'meta' => [
                    'price' => 'Custom',
                    'period' => '/event',
                    'highlight' => false,
                    'features' => [
                        'Dedicated account manager',
                        'Custom integrations & SSO',
                        '24/7 dedicated support',
                        'Custom data storage options',
                    ],
                ],
            ],
        ];

        foreach ($plans as $plan) {
            $this->upsertPlan($plan, $now);
        }

        $faqs = [
            ['title' => 'Can I start for free?', 'body' => 'Yes. You can create and publish standard events at no charge for as long as you like, no card required.', 'sort_order' => 1],
            ['title' => 'Do I need to upgrade to run an exhibition?', 'body' => 'Standard exhibitions support one hall and basic booths — upgrade to Professional to unlock multi-hall exhibitions.', 'sort_order' => 2],
            ['title' => 'Is ticketing secure?', 'body' => 'All payments are processed through PCI-compliant checkout, and every transaction is encrypted end-to-end.', 'sort_order' => 3],
            ['title' => 'Can exhibitors book booths online?', 'body' => 'Yes — exhibitors can browse available booth types, compare packages, and book instantly online.', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            $this->upsertFaq($faq, $now);
        }

        $benefits = [
            ['title' => 'Secure Ticketing', 'body' => 'PCI-compliant checkout, every time.', 'icon' => 'fas fa-lock', 'sort_order' => 1],
            ['title' => 'Reliable Platform', 'body' => '99.9% uptime across every event.', 'icon' => 'fas fa-shield-alt', 'sort_order' => 2],
            ['title' => 'Instant Reach', 'body' => 'Publish and go live in minutes.', 'icon' => 'fas fa-bolt', 'sort_order' => 3],
            ['title' => '24/7 Support', 'body' => 'Real humans, whenever you need.', 'icon' => 'fas fa-headset', 'sort_order' => 4],
        ];

        foreach ($benefits as $benefit) {
            $this->upsertBenefit($benefit, $now);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'pricing')
            ->delete();
    }

    private function upsertSingleton(string $page, string $sectionKey, array $data): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->first();

        $row = array_merge([
            'page' => $page,
            'section_key' => $sectionKey,
            'title' => null,
            'subtitle' => null,
            'body' => null,
            'image_url' => null,
            'link_url' => null,
            'link_label' => null,
            'icon' => null,
            'color' => null,
            'meta' => null,
            'sort_order' => 0,
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now(),
        ], $data);

        if (isset($row['meta']) && is_array($row['meta'])) {
            $row['meta'] = json_encode($row['meta']);
        }

        if ($existing) {
            unset($row['created_at']);
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert($row);
    }

    private function upsertPlan(array $plan, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'pricing')
            ->where('section_key', 'pricing_plan')
            ->where('title', $plan['title'])
            ->first();

        $meta = $plan['meta'];
        $row = [
            'page' => 'pricing',
            'section_key' => 'pricing_plan',
            'title' => $plan['title'],
            'subtitle' => $plan['subtitle'],
            'icon' => $plan['icon'],
            'link_label' => $plan['link_label'],
            'link_url' => $plan['link_url'],
            'meta' => json_encode($meta),
            'sort_order' => $plan['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }

    private function upsertFaq(array $faq, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'pricing')
            ->where('section_key', 'pricing_faq')
            ->where('title', $faq['title'])
            ->first();

        $row = [
            'page' => 'pricing',
            'section_key' => 'pricing_faq',
            'title' => $faq['title'],
            'body' => $faq['body'],
            'sort_order' => $faq['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }

    private function upsertBenefit(array $benefit, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'pricing')
            ->where('section_key', 'pricing_benefit')
            ->where('title', $benefit['title'])
            ->first();

        $row = [
            'page' => 'pricing',
            'section_key' => 'pricing_benefit',
            'title' => $benefit['title'],
            'body' => $benefit['body'],
            'icon' => $benefit['icon'],
            'sort_order' => $benefit['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }
};
