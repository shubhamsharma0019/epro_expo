<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admin_system_settings')) {
            return;
        }

        $settings = [
            [
                'category' => 'auth',
                'key' => 'admin_login_title',
                'value' => 'Welcome Back, Admin',
                'value_type' => 'string',
                'description' => 'Admin login page heading',
            ],
            [
                'category' => 'auth',
                'key' => 'admin_login_subtitle',
                'value' => 'Sign in to your admin dashboard',
                'value_type' => 'string',
                'description' => 'Admin login page subheading',
            ],
            [
                'category' => 'auth',
                'key' => 'admin_login_illustration',
                'value' => 'admin_assets/illustration.png',
                'value_type' => 'string',
                'description' => 'Admin login illustration asset path',
            ],
            [
                'category' => 'auth',
                'key' => 'admin_login_footer_text',
                'value' => 'All rights reserved.',
                'value_type' => 'string',
                'description' => 'Admin login footer suffix',
            ],
        ];

        foreach ($settings as $setting) {
            $exists = DB::table('admin_system_settings')->where('key', $setting['key'])->exists();
            if ($exists) {
                continue;
            }

            DB::table('admin_system_settings')->insert($setting + [
                'is_encrypted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('admin_system_settings')) {
            return;
        }

        DB::table('admin_system_settings')->whereIn('key', [
            'admin_login_title',
            'admin_login_subtitle',
            'admin_login_illustration',
            'admin_login_footer_text',
        ])->delete();
    }
};
