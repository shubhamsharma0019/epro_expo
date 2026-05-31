<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booths')) {
            return;
        }

        Schema::create('booths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booth_size_id')->nullable()->constrained()->nullOnDelete();
            $table->string('booth_number');
            $table->integer('position_x')->nullable();
            $table->integer('position_y')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('status')->default('available');
            $table->timestamps();

            $table->unique(['hall_id', 'booth_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booths');
    }
};
