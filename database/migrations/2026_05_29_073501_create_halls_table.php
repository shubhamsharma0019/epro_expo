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
        Schema::create('visitor_halls', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. hall1, hall2, etc.
            $table->string('badge'); // e.g. Hall 1
            $table->string('title');
            $table->string('subtitle');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('category')->nullable();
            $table->string('area')->nullable();
            $table->string('exhibitors_count')->nullable();
            $table->string('booths_count')->nullable();
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_halls');
    }
};
