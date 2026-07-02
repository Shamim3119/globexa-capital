<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Withdraw;


use App\Models\IncomeDaily;
use App\Models\IncomeGeneration;
use App\Models\IncomeIB;
use App\Models\IncomeReference;
use App\Models\IncomeSalary;


class DashboardController extends Controller
{

    public function incomeBreakdown(Request $request)
    {
        $userId = $request->user_id;
        $type = $request->type;

        $query = function($model) use ($userId, $type) {
            $q = $model::where('client_id', $userId);

            if ($type === 'today') {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereBetween('created_at', [
                    now()->subDays(7),
                    now()
                ]);
            }

            return $q->sum('amount');
        };

        $daily = $query(\App\Models\IncomeDaily::class);
        $generation = $query(\App\Models\IncomeGeneration::class);
        $ib = $query(\App\Models\IncomeIB::class);
        $reference = $query(\App\Models\IncomeReference::class);
        $salary = $query(\App\Models\IncomeSalary::class);

        return response()->json([
            "daily" => $daily,
            "generation" => $generation,
            "ib" => $ib,
            "reference" => $reference,
            "salary" => $salary,
            "total" => $daily + $generation + $ib + $reference + $salary,
        ]);
    }


    public function dashboardSummary(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json([
                "message" => "user_id is required"
            ], 400);
        }

        // Today
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        // Previous 7 days (excluding today)
        $lastWeekStart = now()->subDays(7)->startOfDay();
        $lastWeekEnd = now()->subDay()->endOfDay();

        return response()->json([

            "deposit" => [
                "today" => Deposit::where('deposit_by', $userId)
                    ->whereBetween('created_at', [$todayStart, $todayEnd])
                    ->sum('amount'),

                "lastWeek" => Deposit::where('deposit_by', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

            "investment" => [
                "today" => Investment::where('client_id', $userId)
                    ->whereBetween('created_at', [$todayStart, $todayEnd])
                    ->sum('amount'),

                "lastWeek" => Investment::where('client_id', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

            "income" => [

                "today" =>
                    IncomeDaily::where('client_id', $userId)->whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount')
                    +
                    IncomeGeneration::where('client_id', $userId)->whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount')
                    +
                    IncomeIB::where('client_id', $userId)->whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount')
                    +
                    IncomeReference::where('client_id', $userId)->whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount')
                    +
                    IncomeSalary::where('client_id', $userId)->whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount'),

                "lastWeek" =>
                    IncomeDaily::where('client_id', $userId)->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('amount')
                    +
                    IncomeGeneration::where('client_id', $userId)->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('amount')
                    +
                    IncomeIB::where('client_id', $userId)->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('amount')
                    +
                    IncomeReference::where('client_id', $userId)->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('amount')
                    +
                    IncomeSalary::where('client_id', $userId)->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('amount'),
            ],

            "withdraw" => [
                "today" => Withdraw::where('withdraw_by', $userId)
                    ->whereBetween('created_at', [$todayStart, $todayEnd])
                    ->sum('amount'),

                "lastWeek" => Withdraw::where('withdraw_by', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

        ]);
    }
}