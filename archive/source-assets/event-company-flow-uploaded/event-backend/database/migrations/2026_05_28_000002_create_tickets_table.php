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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('type'); // Early Bird Pass, General Admission, VIP Pass, etc.
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('quantity')->default('Unlimited'); // Can be integer or string "Unlimited"
            $table->string('sales_start')->nullable();
            $table->string('sales_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
