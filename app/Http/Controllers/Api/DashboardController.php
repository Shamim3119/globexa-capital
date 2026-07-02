<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Income;
use App\Models\Withdraw;

class DashboardController extends Controller
{
    public function dashboardSummary(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json([
                "message" => "user_id is required"
            ], 400);
        }

        $today = now()->toDateString();
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();

        return response()->json([

            "deposit" => [
                "today" => Deposit::where('deposit_by', $userId)
                    ->whereDate('created_at', $today)
                    ->sum('amount'),

                "lastWeek" => Deposit::where('deposit_by', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

            "investment" => [
                "today" => Investment::where('client_id', $userId)
                    ->whereDate('created_at', $today)
                    ->sum('amount'),

                "lastWeek" => Investment::where('client_id', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

            "income" => [
                "today" => Income::where('client_id', $userId)
                    ->whereDate('created_at', $today)
                    ->sum('amount'),

                "lastWeek" => Income::where('client_id', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

            "withdraw" => [
                "today" => Withdraw::where('withdraw_by', $userId)
                    ->whereDate('created_at', $today)
                    ->sum('amount'),

                "lastWeek" => Withdraw::where('withdraw_by', $userId)
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('amount'),
            ],

        ]);
    }
}