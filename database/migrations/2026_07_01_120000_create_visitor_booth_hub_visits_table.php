<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_booth_hub_visits')) {
            return;
        }

        Schema::create('visitor_booth_hub_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('visitor_pass_id')->nullable()->constrained('visitors')->nullOnDelete();
            $table->foreignId('exhibition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hall_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booth_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booth_booking_id')->constrained('booth_bookings')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source')->default('hall_layout');
            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();

            $table->index(['user_id', 'booth_booking_id']);
            $table->index(['exhibition_id', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_booth_hub_visits');
    }
};
