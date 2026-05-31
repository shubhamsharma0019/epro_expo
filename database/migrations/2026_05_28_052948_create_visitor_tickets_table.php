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
        Schema::create('visitor_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_event_id')->nullable()->constrained('company_events')->onDelete('cascade');
            $table->foreignId('ticket_type_id')->nullable()->constrained('company_event_ticket_types')->onDelete('set null');
            $table->string('event_slug')->nullable(); // fallback for static events
            $table->string('ticket_name'); // e.g. "VIP Pass", "General Pass"
            $table->string('order_number')->unique();
            $table->integer('quantity');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('confirmed');
            $table->string('qr_code_path')->nullable();
            
            $table->string('attendee_name')->nullable();
            $table->string('attendee_email')->nullable();
            $table->string('attendee_phone')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_tickets');
    }
};
