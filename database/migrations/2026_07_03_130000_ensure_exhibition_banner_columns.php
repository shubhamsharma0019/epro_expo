<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('exhibitions')) {
            return;
        }

        Schema::table('exhibitions', function (Blueprint $table) {
            if (! Schema::hasColumn('exhibitions', 'banner_image')) {
                $table->string('banner_image')->nullable()->after('description');
            }

            if (! Schema::hasColumn('exhibitions', 'banner_url')) {
                $table->string('banner_url')->nullable()->after('banner_image');
            }
        });
    }

    public function down(): void
    {
        // Keep banner columns; they are used across visitor and company flows.
    }
};
