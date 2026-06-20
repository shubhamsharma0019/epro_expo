<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            Schema::create('website_content_items', function (Blueprint $table) {
                $table->id();
                $table->string('page')->default('home');
                $table->string('section_key');
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->text('body')->nullable();
                $table->string('image_url')->nullable();
                $table->string('link_url')->nullable();
                $table->string('link_label')->nullable();
                $table->string('icon')->nullable();
                $table->string('color')->nullable();
                $table->json('meta')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->string('status')->default('published');
                $table->timestamps();

                $table->index(['page', 'section_key', 'status']);
            });
        }

        if (Schema::hasTable('exhibitions') && ! Schema::hasColumn('exhibitions', 'is_home_featured')) {
            Schema::table('exhibitions', function (Blueprint $table) {
                $table->boolean('is_home_featured')->default(false)->after('publish_status');
            });
        }

        if (Schema::hasTable('company_events') && ! Schema::hasColumn('company_events', 'is_home_featured')) {
            Schema::table('company_events', function (Blueprint $table) {
                $table->boolean('is_home_featured')->default(false)->after('publish_status');
            });
        }

        if (Schema::hasTable('companies') && ! Schema::hasColumn('companies', 'is_home_featured')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->boolean('is_home_featured')->default(false)->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('exhibitions') && Schema::hasColumn('exhibitions', 'is_home_featured')) {
            Schema::table('exhibitions', fn (Blueprint $table) => $table->dropColumn('is_home_featured'));
        }

        if (Schema::hasTable('company_events') && Schema::hasColumn('company_events', 'is_home_featured')) {
            Schema::table('company_events', fn (Blueprint $table) => $table->dropColumn('is_home_featured'));
        }

        if (Schema::hasTable('companies') && Schema::hasColumn('companies', 'is_home_featured')) {
            Schema::table('companies', fn (Blueprint $table) => $table->dropColumn('is_home_featured'));
        }

        Schema::dropIfExists('website_content_items');
    }
};
