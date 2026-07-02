<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:run-daily-procedure')]
#[Description('Command description')]

class RunDailyProcedure extends Command
{
 
    public function handle()
    {
        try {
            DB::statement("CALL execute_daily_calculation()");

            $this->info('Procedure executed successfully');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}



 