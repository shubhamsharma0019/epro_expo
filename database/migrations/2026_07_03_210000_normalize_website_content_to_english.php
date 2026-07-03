<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Normalize any legacy Hinglish CMS copy to English across admin forms.
     */
    public function up(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $now = now();

        $englishByKey = [
            'admin_exhibition_form.duration_days_help' => 'Set how many days this exhibition will run. The end date is calculated automatically.',
            'admin_exhibition_form.duration_days_placeholder' => 'e.g. 3',
            'admin_exhibition_form.banner_image_help' => 'Recommended size 1920x600px. PNG, JPG or WebP. Max 2MB.',
            'admin_pavilion_form.banner_image_help' => 'Recommended size 1600x600px. PNG, JPG or WebP. Max 2MB.',
            'admin_dashboard.welcome_clear' => 'All queues are clear. Here is your live platform snapshot.',
            'admin_dashboard.visitor_signups_label' => 'Last 7 days',
            'admin_dashboard.revenue_mix_label' => 'Live split across platform revenue streams',
        ];

        foreach ($englishByKey as $compoundKey => $body) {
            [$page, $sectionKey] = explode('.', $compoundKey, 2);

            DB::table('website_content_items')
                ->where('page', $page)
                ->where('section_key', $sectionKey)
                ->update([
                    'body' => $body,
                    'status' => 'published',
                    'updated_at' => $now,
                ]);
        }

        DB::table('website_content_items')
            ->where(function ($query) {
                $query->where('body', 'like', '%karega%')
                    ->orWhere('body', 'like', '%chlegi%')
                    ->orWhere('body', 'like', '%hogi%')
                    ->orWhere('body', 'like', '%yahan%')
                    ->orWhere('body', 'like', '%karo%')
                    ->orWhere('body', 'like', '%nahi%')
                    ->orWhere('body', 'like', '%hain%')
                    ->orWhere('body', 'like', '%lagao%')
                    ->orWhere('body', 'like', '%dikhe%')
                    ->orWhere('body', 'like', '%upload karo%')
                    ->orWhere('body', 'like', '%select karo%')
                    ->orWhere('title', 'like', '%karega%')
                    ->orWhere('title', 'like', '%chlegi%');
            })
            ->update([
                'body' => 'Please use the fields above. Contact support if you need help.',
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        // Content normalization is not reversed.
    }
};
