<?php
 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepositeCommission;
use Illuminate\Http\Request;
use App\Models\Client; 

class DepositeCommissionController extends Controller
{
    public function index(Request $request)
    {
        $plans = DepositeCommission::orderBy('day')->get();

        $clientId = $request->client_id;

        $depositBalance = 0;

        if ($clientId) {
            $client = Client::find($clientId);
            $depositBalance = $client ? $client->deposit_balance : 0;
        }

        return response()->json([
            'status' => true,
            'deposit_balance' => $depositBalance,
            'data' => $plans,
        ]);
    }
}