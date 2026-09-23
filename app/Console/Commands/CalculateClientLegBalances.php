<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateClientLegBalances extends Command
{
    protected $signature = 'app:calculate-client-leg-balances';

    protected $description = 'Calculate client left/right balances and ranks';

    public function handle()
    {
        $this->info('Starting calculate_client_leg_balances...');

        DB::statement('CALL calculate_client_leg_balances()');

        $this->info('calculate_client_leg_balances completed successfully.');

        return self::SUCCESS;
    }
}