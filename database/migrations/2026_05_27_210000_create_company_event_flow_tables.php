<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('event_type')->default('in_person');
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('event_mode')->default('in_person');
            $table->string('status')->default('draft');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('website')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->json('highlights')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->string('visibility')->default('private');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status']);
        });

        Schema::create('company_event_brandings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_event_id')->constrained('company_events')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('brochure_path')->nullable();
            $table->string('primary_color', 20)->nullable();
            $table->string('secondary_color', 20)->nullable();
            $table->string('accent_color', 20)->nullable();
            $table->string('theme_template')->nullable();
            $table->string('headline')->nullable();
            $table->text('tagline')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->json('social_links')->nullable();
            $table->timestamps();

            $table->unique('company_event_id');
        });

        Schema::create('company_event_ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_event_id')->constrained('company_events')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('currency', 3)->default('INR');
            $table->unsignedInteger('quantity_total')->nullable();
            $table->unsignedInteger('quantity_sold')->default(0);
            $table->dateTime('sales_start_at')->nullable();
            $table->dateTime('sales_end_at')->nullable();
            $table->string('status')->default('active');
            $table->json('benefits')->nullable();
            $table->timestamps();

            $table->index(['company_event_id', 'status']);
        });

        Schema::create('company_event_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_event_id')->constrained('company_events')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('session_type')->default('session');
            $table->string('location')->nullable();
            $table->string('stream_url')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->index(['company_event_id', 'starts_at']);
        });

        Schema::create('company_event_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_event_id')->constrained('company_events')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('organization')->nullable();
            $table->string('email')->nullable();
            $table->string('photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->json('social_links')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['company_event_id', 'status']);
        });

        Schema::create('company_event_publish_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_event_id')->constrained('company_events')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->text('company_notes')->nullable();
            $table->text('review_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_event_publish_requests');
        Schema::dropIfExists('company_event_speakers');
        Schema::dropIfExists('company_event_sessions');
        Schema::dropIfExists('company_event_ticket_types');
        Schema::dropIfExists('company_event_brandings');
        Schema::dropIfExists('company_events');
    }
};
