<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('exhibition_ticket_visitor_registrations')) {
            Schema::create('exhibition_ticket_visitor_registrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('exhibition_id')->nullable()->constrained('exhibitions')->cascadeOnDelete();
                $table->string('exhibition_slug');
                $table->string('name');
                $table->string('email');
                $table->string('phone', 30)->nullable();
                $table->string('gender', 40)->nullable();
                $table->string('city')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'exhibition_slug'], 'exh_ticket_visitor_regs_user_slug_uq');
            });

            return;
        }

        Schema::table('exhibition_ticket_visitor_registrations', function (Blueprint $table) {
            $table->unique(['user_id', 'exhibition_slug'], 'exh_ticket_visitor_regs_user_slug_uq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibition_ticket_visitor_registrations');
    }
};
