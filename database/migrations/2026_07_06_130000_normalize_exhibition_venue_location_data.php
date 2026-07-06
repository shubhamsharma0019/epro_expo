<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = DB::table('exhibitions')->select('id', 'venue', 'location')->get();

        foreach ($rows as $row) {
            $venue = trim((string) ($row->venue ?? ''));
            $location = trim((string) ($row->location ?? ''));

            if ($venue === '' || $location === '') {
                continue;
            }

            if (strcasecmp($venue, $location) === 0 || str_contains(strtolower($venue), strtolower($location))) {
                $cityCountry = collect(explode(',', $venue))
                    ->map(fn ($part) => trim($part))
                    ->filter()
                    ->reject(fn ($part) => strcasecmp($part, $location) === 0)
                    ->values()
                    ->implode(', ');

                DB::table('exhibitions')->where('id', $row->id)->update([
                    'location' => $cityCountry !== '' ? $cityCountry : $location,
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Non-destructive data cleanup migration.
    }
};
