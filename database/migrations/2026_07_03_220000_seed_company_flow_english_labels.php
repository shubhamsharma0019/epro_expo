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

        $rows = [
            [
                'page' => 'company_dashboard',
                'section_key' => 'welcome_hint',
                'title' => 'Dashboard welcome hint',
                'body' => 'Book a booth at an upcoming exhibition to showcase your products, capture leads, and arrange B2B meetings.',
            ],
            [
                'page' => 'company_booking',
                'section_key' => 'booth_days_help',
                'title' => 'Booth days help',
                'body' => 'Booth booking duration is configured by the exhibition admin. All assigned days are included automatically in your booking amount.',
            ],
            [
                'page' => 'company_event_flow',
                'section_key' => 'ticket_setup_hint',
                'title' => 'Ticket setup hint',
                'body' => 'Add ticket types, pricing, and sales windows before publishing your event.',
            ],
        ];

        foreach ($rows as $row) {
            $existing = DB::table('website_content_items')
                ->where('page', $row['page'])
                ->where('section_key', $row['section_key'])
                ->first();

            if ($existing) {
                DB::table('website_content_items')
                    ->where('id', $existing->id)
                    ->update([
                        'body' => $row['body'],
                        'title' => $row['title'],
                        'status' => 'published',
                        'updated_at' => $now,
                    ]);

                continue;
            }

            DB::table('website_content_items')->insert($row + [
                'status' => 'published',
                'sort_order' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('website_content_items')
            ->where(function ($query) {
                $query->where('page', 'like', 'company_%')
                    ->orWhere('page', 'company_dashboard')
                    ->orWhere('page', 'company_booking')
                    ->orWhere('page', 'company_event_flow');
            })
            ->where(function ($query) {
                $query->where('body', 'like', '%karega%')
                    ->orWhere('body', 'like', '%chlegi%')
                    ->orWhere('body', 'like', '%hogi%')
                    ->orWhere('body', 'like', '%yahan%')
                    ->orWhere('body', 'like', '%karo%')
                    ->orWhere('body', 'like', '%nahi%');
            })
            ->update([
                'body' => 'Please use the fields above. Contact support if you need help.',
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->whereIn('page', ['company_dashboard', 'company_booking', 'company_event_flow'])
            ->whereIn('section_key', ['welcome_hint', 'booth_days_help', 'ticket_setup_hint'])
            ->delete();
    }
};
