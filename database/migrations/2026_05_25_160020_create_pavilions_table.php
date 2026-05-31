<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pavilions')) {
            return;
        }

        Schema::create('pavilions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('total_halls')->default(0);
            $table->unsignedInteger('total_booths')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['exhibition_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pavilions');
    }
};
