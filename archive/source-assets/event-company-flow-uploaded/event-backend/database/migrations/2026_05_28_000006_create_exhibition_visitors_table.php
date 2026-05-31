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
        Schema::create('exhibition_visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exhibition_id')->nullable();
            $table->string('booking_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('job_title');
            $table->string('company');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('industry');
            $table->string('company_size');
            $table->string('business_address');
            $table->string('pass_type');
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('payment_status')->default('pending'); // pending, completed
            $table->boolean('checkin_status')->default(false);
            $table->string('checkin_time')->nullable();
            $table->timestamps();

            $table->foreign('exhibition_id')->references('id')->on('exhibitions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_visitors');
    }
};
