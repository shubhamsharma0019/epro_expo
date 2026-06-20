<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('visitor_booth_messages')) {
            Schema::create('visitor_booth_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exhibition_id')->constrained('exhibitions')->cascadeOnDelete();
                $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
                $table->string('visitor_booking_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('sender_type', 20);
                $table->string('sender_name')->nullable();
                $table->text('message');
                $table->timestamps();

                $table->index(['exhibition_id', 'company_id', 'visitor_booking_id'], 'vb_msg_expo_co_book_idx');
            });

            return;
        }

        $indexExists = collect(Schema::getConnection()->select(
            "SHOW INDEX FROM visitor_booth_messages WHERE Key_name = 'vb_msg_expo_co_book_idx'"
        ))->isNotEmpty();

        if (! $indexExists) {
            Schema::table('visitor_booth_messages', function (Blueprint $table) {
                $table->index(['exhibition_id', 'company_id', 'visitor_booking_id'], 'vb_msg_expo_co_book_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_booth_messages');
    }
};
