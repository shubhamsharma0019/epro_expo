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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('booking_id')->unique();
            $table->string('ticket_type')->nullable();
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('booking_date')->nullable();
            $table->string('attendee_name')->nullable();
            $table->string('attendee_email')->nullable();
            $table->boolean('checkin_status')->default(false);
            $table->string('checkin_time')->nullable();
            $table->timestamps();

            // Foreign key relation (optional cascade on delete)
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
