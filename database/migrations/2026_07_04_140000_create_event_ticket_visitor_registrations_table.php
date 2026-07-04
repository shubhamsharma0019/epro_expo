<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('event_ticket_visitor_registrations')) {
            return;
        }

        Schema::create('event_ticket_visitor_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('company_event_id')->nullable()->constrained('company_events')->cascadeOnDelete();
            $table->string('event_slug');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('gender', 40)->nullable();
            $table->string('city')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'event_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_ticket_visitor_registrations');
    }
};
