<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('company_event_id')->constrained('company_events')->cascadeOnDelete();
                $table->foreignId('ticket_type_id')->nullable()->constrained('company_event_ticket_types')->nullOnDelete();
                $table->foreignId('visitor_ticket_id')->nullable()->constrained('visitor_tickets')->nullOnDelete();
                $table->string('booking_number')->unique();
                $table->string('ticket_type')->nullable();
                $table->unsignedInteger('quantity')->default(1);
                $table->decimal('amount', 12, 2)->default(0);
                $table->string('payment_status')->default('pending');
                $table->string('razorpay_order_id')->nullable();
                $table->string('razorpay_payment_id')->nullable();
                $table->string('status')->default('confirmed');
                $table->json('meta')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['company_event_id', 'status']);
                $table->index('user_id');
            });
        }

        if (! Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->string('ticket_no')->unique();
                $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
                $table->foreignId('visitor_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('event_id')->constrained('company_events')->cascadeOnDelete();
                $table->string('ticket_type');
                $table->unsignedInteger('quantity')->default(1);
                $table->string('qr_token')->unique();
                $table->string('qr_url');
                $table->enum('status', ['pending', 'confirmed', 'cancelled', 'used'])->default('confirmed');
                $table->boolean('checked_in')->default(false);
                $table->timestamp('checked_in_at')->nullable();
                $table->string('payment_status')->default('paid');
                $table->decimal('amount', 12, 2)->default(0);
                $table->json('meta')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['event_id', 'status']);
                $table->index(['visitor_id', 'status']);
                $table->index('qr_token');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('bookings');
    }
};
