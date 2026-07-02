<?php

use App\Support\MeetingJoinUrls;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('company_meetings')) {
            return;
        }

        Schema::table('company_meetings', function (Blueprint $table) {
            if (! Schema::hasColumn('company_meetings', 'google_calendar_link')) {
                $table->string('google_calendar_link', 500)->nullable()->after('zoom_start_url');
            }
        });

        DB::table('company_meetings')
            ->orderBy('id')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    $startUrl = $row->zoom_start_url;
                    $joinUrl = $row->zoom_join_url ?: $row->meeting_link;
                    $calendarLink = null;

                    if ($startUrl && ! str_contains($startUrl, 'meet.google.com')) {
                        $calendarLink = $startUrl;
                    }

                    $meetUrl = MeetingJoinUrls::normalize($joinUrl)
                        ?: MeetingJoinUrls::normalize($startUrl);

                    if (! $meetUrl) {
                        continue;
                    }

                    $payload = MeetingJoinUrls::syncPayload($meetUrl, $calendarLink);

                    DB::table('company_meetings')->where('id', $row->id)->update($payload);
                }
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('company_meetings')) {
            return;
        }

        Schema::table('company_meetings', function (Blueprint $table) {
            if (Schema::hasColumn('company_meetings', 'google_calendar_link')) {
                $table->dropColumn('google_calendar_link');
            }
        });
    }
};
