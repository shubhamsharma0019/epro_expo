<?php

// Load Laravel bootstrap
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Set SQLite path absolutely
config(['database.connections.sqlite.database' => database_path('database.sqlite')]);

$sqliteConn = DB::connection('sqlite');
$mysqlConn = DB::connection('mysql');

try {
    $tables = $sqliteConn->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
    
    echo "TABLE ROW COUNTS (SQLite vs MySQL):\n";
    echo str_pad("Table Name", 40) . " | " . str_pad("SQLite Count", 15) . " | " . str_pad("MySQL Count", 15) . "\n";
    echo str_repeat("-", 76) . "\n";

    foreach ($tables as $tableObj) {
        $table = $tableObj->name;
        
        $sqliteCount = 0;
        try {
            $sqliteCount = $sqliteConn->table($table)->count();
        } catch (\Exception $e) {
            $sqliteCount = 'Error';
        }

        $mysqlCount = 0;
        try {
            if (Schema::connection('mysql')->hasTable($table)) {
                $mysqlCount = $mysqlConn->table($table)->count();
            } else {
                $mysqlCount = 'No Table';
            }
        } catch (\Exception $e) {
            $mysqlCount = 'Error: ' . $e->getMessage();
        }

        echo str_pad($table, 40) . " | " . str_pad($sqliteCount, 15) . " | " . str_pad($mysqlCount, 15) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
