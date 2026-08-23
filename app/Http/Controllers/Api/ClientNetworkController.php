<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;  
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientNetworkController extends Controller
{
    public function getNetworkInvestmentBalances(Request $request, $id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }

        // Extract query parameters with defaults
        $startDate = $request->input('start_date'); // e.g. 2026-01-01
        $endDate = $request->input('end_date');       // e.g. 2026-12-31
        $inactive = $request->input('inactive', -1); // -1 = All, 0 = Active, 1 = Inactive
        $filterClientId = $request->input('client_id'); // Specific investment client_id

        // Calculate balances using filters
        $leftInvestmentBalance = $client->getLegInvestmentBalance(0, $startDate, $endDate, $inactive, $filterClientId);
        $rightInvestmentBalance = $client->getLegInvestmentBalance(1, $startDate, $endDate, $inactive, $filterClientId);

        return response()->json([
            'success' => true,
            'client_id' => $client->id,
            'client_name' => $client->name,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'inactive' => $inactive,
                'client_id' => $filterClientId,
            ],
            'left_investment_balance' => $leftInvestmentBalance,
            'right_investment_balance' => $rightInvestmentBalance,
        ]);
    }
}