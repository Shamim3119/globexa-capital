<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExecuteIncomeIb extends Command
{
    protected $signature = 'app:execute-income-ib';

    protected $description = 'Execute income IB calculation';

    public function handle()
    {
        $this->info('Starting execute_income_ib...');

        DB::statement('CALL execute_income_ib()');

        $this->info('execute_income_ib completed successfully.');

        return self::SUCCESS;
    }
}