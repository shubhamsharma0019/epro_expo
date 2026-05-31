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
            $table->unsignedBigInteger('exhibition_id')->nullable();
            $table->string('hall_name');
            $table->string('booth_number');
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->nullable();
            $table->string('rep_name')->nullable();
            $table->string('rep_title')->nullable();
            $table->string('rep_email')->nullable();
            $table->string('rep_phone')->nullable();
            $table->string('rep_img_url')->nullable();
            $table->string('logo_color')->nullable();
            $table->string('logo_text')->nullable();
            $table->timestamps();

            $table->foreign('exhibition_id')->references('id')->on('exhibitions')->onDelete('cascade');
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
