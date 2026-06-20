<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Domain\Shared\Models\User;
use App\Domain\Company\Models\Company;

echo "=== SEEDED USERS ===\n";
foreach (User::take(5)->get() as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | Email: {$u->email}\n";
}

echo "\n=== SEEDED COMPANIES ===\n";
foreach (Company::take(5)->get() as $c) {
    echo "ID: {$c->id} | Name: {$c->company_name} | Email: {$c->email} | Status: {$c->status}\n";
}

echo "\n=== ADMINS ===\n";
$admins = DB::table('admins')->get();
foreach ($admins as $a) {
    echo "ID: {$a->id} | Name: {$a->name} | Email: {$a->email}\n";
}
