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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('pavilion_id')->nullable();
            $table->string('booking_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('industry')->nullable();
            $table->string('company_size')->nullable();
            $table->text('business_address')->nullable();
            $table->string('pass_type')->default('Free Visitor Pass');
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('payment_status')->default('pending');
            $table->boolean('checkin_status')->default(false);
            $table->string('checkin_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
