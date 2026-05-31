<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('timezone')->nullable();
            $table->string('venue')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            
            // Branding configurations
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('primary_color')->default('#5B32F6');
            $table->string('secondary_color')->default('#00B894');
            $table->string('accent_color')->default('#FF8A00');
            $table->string('text_color')->default('#0F172A');
            
            // Organizer Contact
            $table->string('organizer_name')->nullable();
            $table->string('organizer_email')->nullable();
            $table->string('organizer_phone')->nullable();
            
            // Status and PDF Documents
            $table->string('status')->default('draft'); // draft, pending, approved
            $table->string('brochure_path')->nullable();
            $table->string('sponsorship_guide_path')->nullable();
            $table->text('review_notes')->nullable();
            
            // Additional registration settings
            $table->boolean('allow_group_registrations')->default(false);
            $table->boolean('show_remaining_tickets')->default(false);
            $table->boolean('waiting_list')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
