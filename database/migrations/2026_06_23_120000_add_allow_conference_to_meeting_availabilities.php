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
                if (! Schema::hasColumn('booth_meeting_availabilities', 'allow_conference')) {
                    $table->boolean('allow_conference')->default(false)->after('allow_one_to_many');
                }
            });
        }

        if (Schema::hasTable('booth_meeting_slots')) {
            Schema::table('booth_meeting_slots', function (Blueprint $table) {
                if (! Schema::hasColumn('booth_meeting_slots', 'allow_conference')) {
                    $table->boolean('allow_conference')->default(false)->after('allow_one_to_many');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('booth_meeting_slots')) {
            Schema::table('booth_meeting_slots', function (Blueprint $table) {
                if (Schema::hasColumn('booth_meeting_slots', 'allow_conference')) {
                    $table->dropColumn('allow_conference');
                }
            });
        }

        if (Schema::hasTable('booth_meeting_availabilities')) {
            Schema::table('booth_meeting_availabilities', function (Blueprint $table) {
                if (Schema::hasColumn('booth_meeting_availabilities', 'allow_conference')) {
                    $table->dropColumn('allow_conference');
                }
            });
        }
    }
};
