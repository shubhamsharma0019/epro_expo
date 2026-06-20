<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_meeting_availabilities')) {
            Schema::table('booth_meeting_availabilities', function (Blueprint $table) {
                if (! Schema::hasColumn('booth_meeting_availabilities', 'max_capacity')) {
                    $table->unsignedInteger('max_capacity')->nullable()->default(1)->after('assigned_team_member_id');
                }
                if (! Schema::hasColumn('booth_meeting_availabilities', 'allow_one_to_one')) {
                    $table->boolean('allow_one_to_one')->default(true)->after('max_capacity');
                }
                if (! Schema::hasColumn('booth_meeting_availabilities', 'allow_one_to_many')) {
                    $table->boolean('allow_one_to_many')->default(false)->after('allow_one_to_one');
                }
            });
        }

        if (Schema::hasTable('booth_meeting_slots')) {
            Schema::table('booth_meeting_slots', function (Blueprint $table) {
                if (! Schema::hasColumn('booth_meeting_slots', 'max_capacity')) {
                    $table->unsignedInteger('max_capacity')->default(1)->after('meeting_type');
                }
                if (! Schema::hasColumn('booth_meeting_slots', 'allow_one_to_one')) {
                    $table->boolean('allow_one_to_one')->default(true)->after('max_capacity');
                }
                if (! Schema::hasColumn('booth_meeting_slots', 'allow_one_to_many')) {
                    $table->boolean('allow_one_to_many')->default(false)->after('allow_one_to_one');
                }
            });
        }

        if (! Schema::hasTable('meeting_notifications')) {
            Schema::create('meeting_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('visitor_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
                $table->foreignId('visitor_meeting_booking_id')->nullable()->constrained('visitor_meeting_bookings')->cascadeOnDelete();
                $table->string('type'); // created, approved, rejected, rescheduled, reminder, completed
                $table->string('title');
                $table->text('message');
                $table->string('status')->default('unread'); // unread, read
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_notifications');

        if (Schema::hasTable('booth_meeting_slots')) {
            Schema::table('booth_meeting_slots', function (Blueprint $table) {
                foreach (['max_capacity', 'allow_one_to_one', 'allow_one_to_many'] as $column) {
                    if (Schema::hasColumn('booth_meeting_slots', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('booth_meeting_availabilities')) {
            Schema::table('booth_meeting_availabilities', function (Blueprint $table) {
                foreach (['max_capacity', 'allow_one_to_one', 'allow_one_to_many'] as $column) {
                    if (Schema::hasColumn('booth_meeting_availabilities', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
