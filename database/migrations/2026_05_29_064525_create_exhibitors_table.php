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
        Schema::create('exhibitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('name');
            $table->string('category');
            $table->text('description');
            $table->string('hall_name');
            $table->string('booth_number');
            $table->string('website')->nullable();
            $table->string('email');
            $table->string('country');
            $table->string('rep_name');
            $table->string('rep_title');
            $table->string('rep_email');
            $table->string('rep_phone');
            $table->string('rep_img_url')->nullable();
            $table->string('logo_color')->default('bg-blue-500');
            $table->string('logo_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibitors');
    }
};
