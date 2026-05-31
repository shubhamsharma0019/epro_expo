<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_booking_summaries')) {
            return;
        }

        Schema::create('booth_booking_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booth_booking_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exhibition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pavilion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booth_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booth_size_id')->nullable()->constrained()->nullOnDelete();
            $table->string('pavilion_title')->nullable();
            $table->string('hall_title')->nullable();
            $table->string('booth_number')->nullable();
            $table->string('booth_size_title')->nullable();
            $table->unsignedInteger('selected_days_count')->default(0);
            $table->json('selected_days')->nullable();
            $table->decimal('booth_price', 10, 2)->default(0);
            $table->decimal('days_amount', 10, 2)->default(0);
            $table->decimal('services_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('booking_status')->default('draft');
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booth_booking_summaries');
    }
};
