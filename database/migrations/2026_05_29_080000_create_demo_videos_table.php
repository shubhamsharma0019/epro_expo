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
        Schema::create('demo_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibitor_id')->constrained('exhibitors')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('duration');
            $table->string('video_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->integer('views_count')->default(0);
            $table->string('published_date');
            $table->string('presenter_name')->nullable();
            $table->string('presenter_title')->nullable();
            $table->string('badge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_videos');
    }
};
