<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncSqliteToMysql extends Command
{
    protected $signature = 'db:sync-sqlite-to-mysql
                            {--fresh-migrate : Run migrations on MySQL before copying data}
                            {--chunk=500 : Number of rows copied per batch}
                            {--only=* : Sync only the given table name; can be repeated}';

    protected $description = 'Incrementally copy all existing SQLite application data into the configured MySQL database using upserts.';

    public function handle(): int
    {
        if (config('database.default') !== 'mysql') {
            $this->error('Set DB_CONNECTION=mysql in .env before running this command.');

            return self::FAILURE;
        }

        $sqlitePath = database_path('database.sqlite');
        if (! is_file($sqlitePath)) {
            $this->error('SQLite database file not found at database/database.sqlite');

            return self::FAILURE;
        }

        try {
            DB::connection('mysql')->getPdo();
        } catch (\Throwable $exception) {
            $this->error('MySQL connection failed: ' . $exception->getMessage());

            return self::FAILURE;
        }

        if ($this->option('fresh-migrate')) {
            $this->info('Running migrations on MySQL...');
            Artisan::call('migrate', ['--force' => true]);
            $this->line(Artisan::output());
        }

        config(['database.connections.sqlite_source' => [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]]);

        $sqlite = DB::connection('sqlite_source');
        $mysql = DB::connection('mysql');
        $onlyTables = array_filter((array) $this->option('only'));

        $tables = collect($sqlite->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'"))
            ->pluck('name')
            ->reject(fn ($name) => in_array($name, ['migrations'], true))
            ->when($onlyTables !== [], fn ($collection) => $collection->filter(fn ($name) => in_array($name, $onlyTables, true)))
            ->values();

        if ($tables->isEmpty()) {
            $this->warn('No SQLite tables matched for sync.');

            return self::SUCCESS;
        }

        $mysql->statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            foreach ($tables as $table) {
                $this->syncTable($table, $sqlite, $mysql);
            }
        } finally {
            $mysql->statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $this->info('SQLite to MySQL sync completed.');

        return self::SUCCESS;
    }

    private function syncTable(string $table, $sqlite, $mysql): void
    {
        if (! Schema::connection('mysql')->hasTable($table)) {
            $this->warn("Skipping {$table}: not present on MySQL (run migrations).");

            return;
        }

        $sqliteCount = (int) $sqlite->table($table)->count();
        if ($sqliteCount === 0) {
            $this->line("{$table}: no rows");

            return;
        }

        $sqliteColumns = Schema::connection('sqlite_source')->getColumnListing($table);
        $mysqlColumns = Schema::connection('mysql')->getColumnListing($table);
        $copyColumns = array_values(array_intersect($sqliteColumns, $mysqlColumns));
        $missingColumns = array_values(array_diff($sqliteColumns, $mysqlColumns));

        if ($copyColumns === []) {
            $this->warn("{$table}: skipped; no shared columns between SQLite and MySQL");

            return;
        }

        if ($missingColumns !== []) {
            $this->warn("{$table}: MySQL is missing SQLite columns: " . implode(', ', $missingColumns));
        }

        $uniqueBy = $this->uniqueColumns($table, $copyColumns);
        $updateColumns = array_values(array_diff($copyColumns, $uniqueBy));
        $chunkSize = max(1, (int) $this->option('chunk'));
        $before = (int) $mysql->table($table)->count();
        $synced = 0;
        $errors = 0;

        foreach ($sqlite->table($table)->select($copyColumns)->orderBy($uniqueBy[0])->cursor()->chunk($chunkSize) as $rows) {
            $payload = $rows
                ->map(fn ($row) => (array) json_decode(json_encode($row), true))
                ->all();

            try {
                if ($updateColumns === []) {
                    $mysql->table($table)->insertOrIgnore($payload);
                } else {
                    $mysql->table($table)->upsert($payload, $uniqueBy, $updateColumns);
                }

                $synced += count($payload);
            } catch (\Throwable $exception) {
                $errors++;
                $this->warn("{$table}: failed to sync a {$chunkSize}-row batch: " . $exception->getMessage());
            }
        }

        $after = (int) $mysql->table($table)->count();
        $this->info("{$table}: synced {$synced}/{$sqliteCount} rows, MySQL {$before} -> {$after}, errors {$errors}");
    }

    private function uniqueColumns(string $table, array $copyColumns): array
    {
        $indexes = Schema::connection('mysql')->getIndexes($table);

        foreach ($indexes as $index) {
            $columns = $index['columns'] ?? [];
            $isPrimary = (bool) ($index['primary'] ?? false);
            $isUnique = (bool) ($index['unique'] ?? false);

            if (($isPrimary || $isUnique) && $columns !== [] && count(array_diff($columns, $copyColumns)) === 0) {
                return $columns;
            }
        }

        if (in_array('id', $copyColumns, true)) {
            return ['id'];
        }

        return [$copyColumns[0]];
    }
}

