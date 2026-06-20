<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_meeting_bookings')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                if (! Schema::hasColumn('visitor_meeting_bookings', 'meeting_topic')) {
                    $table->string('meeting_topic')->nullable()->after('visitor_phone');
                }
                if (! Schema::hasColumn('visitor_meeting_bookings', 'preferred_date')) {
                    $table->date('preferred_date')->nullable()->after('meeting_topic');
                }
                if (! Schema::hasColumn('visitor_meeting_bookings', 'preferred_time')) {
                    $table->time('preferred_time')->nullable()->after('preferred_date');
                }
                if (! Schema::hasColumn('visitor_meeting_bookings', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('status');
                }
                if (! Schema::hasColumn('visitor_meeting_bookings', 'updated_by')) {
                    $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
                }
                if (! Schema::hasColumn('visitor_meeting_bookings', 'completed_at')) {
                    $table->timestamp('completed_at')->nullable()->after('updated_by');
                }
            });
        }

        if (Schema::hasTable('company_meetings')) {
            Schema::table('company_meetings', function (Blueprint $table) {
                if (! Schema::hasColumn('company_meetings', 'zoom_join_url')) {
                    $table->string('zoom_join_url', 500)->nullable()->after('meeting_link');
                }
                if (! Schema::hasColumn('company_meetings', 'zoom_start_url')) {
                    $table->string('zoom_start_url', 500)->nullable()->after('zoom_join_url');
                }
                if (! Schema::hasColumn('company_meetings', 'zoom_duration')) {
                    $table->unsignedSmallInteger('zoom_duration')->nullable()->after('zoom_start_url');
                }
                if (! Schema::hasColumn('company_meetings', 'zoom_meeting_status')) {
                    $table->string('zoom_meeting_status')->nullable()->after('zoom_duration');
                }
            });
        }

        if (! Schema::hasTable('visitor_session_registrations')) {
            Schema::create('visitor_session_registrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booth_session_id')->constrained()->cascadeOnDelete();
                $table->foreignId('exhibition_id')->constrained()->cascadeOnDelete();
                $table->string('visitor_booking_id')->nullable()->index();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('visitor_email')->nullable();
                $table->string('status')->default('registered');
                $table->timestamps();

                $table->index(['booth_session_id', 'visitor_booking_id'], 'vs_reg_session_book_idx');
                $table->index(['booth_session_id', 'user_id'], 'vs_reg_session_user_idx');
            });

            return;
        }

        $connection = Schema::getConnection();
        $sessionBookIndexExists = collect($connection->select(
            "SHOW INDEX FROM visitor_session_registrations WHERE Key_name = 'vs_reg_session_book_idx'"
        ))->isNotEmpty();
        $sessionUserIndexExists = collect($connection->select(
            "SHOW INDEX FROM visitor_session_registrations WHERE Key_name = 'vs_reg_session_user_idx'"
        ))->isNotEmpty();

        Schema::table('visitor_session_registrations', function (Blueprint $table) use ($sessionBookIndexExists, $sessionUserIndexExists) {
            if (! $sessionBookIndexExists) {
                $table->index(['booth_session_id', 'visitor_booking_id'], 'vs_reg_session_book_idx');
            }
            if (! $sessionUserIndexExists) {
                $table->index(['booth_session_id', 'user_id'], 'vs_reg_session_user_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_session_registrations');

        if (Schema::hasTable('company_meetings')) {
            Schema::table('company_meetings', function (Blueprint $table) {
                foreach (['zoom_join_url', 'zoom_start_url', 'zoom_duration', 'zoom_meeting_status'] as $column) {
                    if (Schema::hasColumn('company_meetings', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('visitor_meeting_bookings')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                foreach (['meeting_topic', 'preferred_date', 'preferred_time', 'created_by', 'updated_by', 'completed_at'] as $column) {
                    if (Schema::hasColumn('visitor_meeting_bookings', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
