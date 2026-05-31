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
        Schema::create('exhibition_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_id');
            $table->unsignedBigInteger('exhibitor_id');
            $table->string('meeting_date');
            $table->string('meeting_time');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, accepted, declined
            $table->timestamps();

            $table->foreign('visitor_id')->references('id')->on('exhibition_visitors')->onDelete('cascade');
            $table->foreign('exhibitor_id')->references('id')->on('exhibitors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_meetings');
    }
};
