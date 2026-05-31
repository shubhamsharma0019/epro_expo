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
        Schema::create('visitor_pavilions', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. tech, manufacturing, etc.
            $table->string('title');
            $table->string('badge');
            $table->string('subtitle');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('companies_count')->nullable();
            $table->string('products_count')->nullable();
            $table->string('visitors_count')->nullable();
            $table->string('category')->nullable();
            $table->text('about_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_pavilions');
    }
};
