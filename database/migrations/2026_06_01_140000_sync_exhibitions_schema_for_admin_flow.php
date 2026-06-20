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
            if (! Schema::hasColumn('exhibitions', 'title')) {
                $table->string('title')->nullable();
            }
            if (! Schema::hasColumn('exhibitions', 'slug')) {
                $table->string('slug')->nullable();
            }
            if (! Schema::hasColumn('exhibitions', 'location')) {
                $table->string('location')->nullable();
            }
            if (! Schema::hasColumn('exhibitions', 'banner_image')) {
                $table->string('banner_image')->nullable();
            }
            if (! Schema::hasColumn('exhibitions', 'status')) {
                $table->string('status')->default('active');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('exhibitions')) {
            return;
        }

        Schema::table('exhibitions', function (Blueprint $table) {
            foreach (['title', 'slug', 'location', 'banner_image', 'status'] as $column) {
                if (Schema::hasColumn('exhibitions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
