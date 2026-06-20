<?php

namespace App\Console\Commands;

use Database\Seeders\MockFlowDemoSeeder;
use Illuminate\Console\Command;

class SeedMockFlowsCommand extends Command
{
    protected $signature = 'demo:mock-flows';

    protected $description = 'Seed mock exhibition and event for company, visitor, and admin flow testing';

    public function handle(): int
    {
        $this->call('db:seed', ['--class' => MockFlowDemoSeeder::class]);

        return self::SUCCESS;
    }
}
