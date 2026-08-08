<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

#[Signature('app:execute-daily-generation-commission')]
#[Description('Execute daily generation commission')]

class ExecuteDailyGenerationCommission extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::statement("CALL execute_generation_commissions()");
            
            $this->info("Stored procedure executed successfully.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            Log::error($e->getMessage());
        }
    }
}