<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('exhibitions')) {
            Schema::table('exhibitions', function (Blueprint $table) {
                if (! Schema::hasColumn('exhibitions', 'approval_status')) {
                    $table->string('approval_status')->default('approved')->after('status');
                }
                if (! Schema::hasColumn('exhibitions', 'publish_status')) {
                    $table->string('publish_status')->default('draft')->after('approval_status');
                }
                if (! Schema::hasColumn('exhibitions', 'approved_at')) {
                    $table->timestamp('approved_at')->nullable()->after('publish_status');
                }
                if (! Schema::hasColumn('exhibitions', 'published_at')) {
                    $table->timestamp('published_at')->nullable()->after('approved_at');
                }
            });

            foreach (DB::table('exhibitions')->orderBy('id')->get() as $row) {
                $status = (string) ($row->status ?? 'active');
                $publishStatus = in_array($status, ['active', 'published', 'live'], true) ? 'published' : 'draft';
                DB::table('exhibitions')->where('id', $row->id)->update([
                    'approval_status' => 'approved',
                    'publish_status' => $publishStatus,
                    'published_at' => $publishStatus === 'published' ? now() : null,
                    'approved_at' => now(),
                ]);
            }
        }

        if (Schema::hasTable('company_events')) {
            Schema::table('company_events', function (Blueprint $table) {
                if (! Schema::hasColumn('company_events', 'publish_status')) {
                    $table->string('publish_status')->default('unpublished')->after('status');
                }
            });

            foreach (DB::table('company_events')->orderBy('id')->get() as $row) {
                $publishStatus = in_array((string) ($row->status ?? ''), ['published', 'live'], true)
                    ? 'published'
                    : 'unpublished';
                DB::table('company_events')->where('id', $row->id)->update([
                    'publish_status' => $publishStatus,
                ]);
            }
        }

        if (Schema::hasTable('company_meetings')) {
            Schema::table('company_meetings', function (Blueprint $table) {
                if (! Schema::hasColumn('company_meetings', 'zoom_meeting_id')) {
                    $table->string('zoom_meeting_id')->nullable()->after('meeting_link');
                }
                if (! Schema::hasColumn('company_meetings', 'zoom_passcode')) {
                    $table->string('zoom_passcode')->nullable()->after('zoom_meeting_id');
                }
                if (! Schema::hasColumn('company_meetings', 'meeting_agenda')) {
                    $table->text('meeting_agenda')->nullable()->after('zoom_passcode');
                }
                if (! Schema::hasColumn('company_meetings', 'meeting_date')) {
                    $table->date('meeting_date')->nullable()->after('meeting_agenda');
                }
                if (! Schema::hasColumn('company_meetings', 'meeting_time')) {
                    $table->time('meeting_time')->nullable()->after('meeting_date');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('exhibitions')) {
            Schema::table('exhibitions', function (Blueprint $table) {
                foreach (['approval_status', 'publish_status', 'approved_at', 'published_at'] as $column) {
                    if (Schema::hasColumn('exhibitions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('company_events')) {
            Schema::table('company_events', function (Blueprint $table) {
                if (Schema::hasColumn('company_events', 'publish_status')) {
                    $table->dropColumn('publish_status');
                }
            });
        }

        if (Schema::hasTable('company_meetings')) {
            Schema::table('company_meetings', function (Blueprint $table) {
                foreach (['zoom_meeting_id', 'zoom_passcode', 'meeting_agenda', 'meeting_date', 'meeting_time'] as $column) {
                    if (Schema::hasColumn('company_meetings', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
