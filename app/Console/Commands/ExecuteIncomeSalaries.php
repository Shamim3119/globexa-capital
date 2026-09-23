<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExecuteIncomeSalaries extends Command
{
    protected $signature = 'app:execute-income-salaries';

    protected $description = 'Execute monthly client income salaries';

    public function handle()
    {
        $this->info('Starting execute_income_salaries...');

        DB::statement('CALL execute_income_salaries()');

        $this->info('execute_income_salaries completed successfully.');

        return self::SUCCESS;
    }
}