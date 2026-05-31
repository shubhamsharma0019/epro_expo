<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_profiles')) {
            return;
        }

        Schema::create('booth_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booth_booking_id')->constrained()->cascadeOnDelete();
            $table->string('booth_title');
            $table->string('booth_banner')->nullable();
            $table->text('welcome_text')->nullable();
            $table->string('brand_color')->nullable();
            $table->string('video_url')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();
            $table->string('status')->default('approved');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->unique('booth_booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booth_profiles');
    }
};
