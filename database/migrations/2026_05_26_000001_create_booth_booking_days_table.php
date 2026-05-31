<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_booking_days')) {
            return;
        }

        Schema::create('booth_booking_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booth_booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booth_id')->constrained()->cascadeOnDelete();
            $table->date('booking_date');
            $table->string('label')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['booth_id', 'booking_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booth_booking_days');
    }
};
