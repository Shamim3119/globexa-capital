<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\SalarySlot;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalSettings;


class LoginController extends Controller
{

    private function getLegData($parentId, $site)
    {
        $result = DB::select("
            WITH RECURSIVE tree AS (
                SELECT id, investment_balance
                FROM clients
                WHERE ref_id = ? AND site = ?

                UNION ALL

                SELECT c.id, c.investment_balance
                FROM clients c
                INNER JOIN tree t ON c.ref_id = t.id
            )
            SELECT
                COUNT(*) AS total,
                COALESCE(SUM(investment_balance),0) AS balance
            FROM tree
        ", [$parentId, $site]);

        return [
            'count' => $result[0]->total ?? 0,
            'balance' => $result[0]->balance ?? 0,
        ];
    }
 
    public function login(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' => 'required',
        ]);

        $client = Client::where('id', $request->userid)->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'User ID not found'
            ], 404);
        }

        if (!Hash::check($request->password, $client->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password'
            ], 401);
        }

        $leftBalance = $this->getLegData($client->id, 0);
        $rightBalance = $this->getLegData($client->id, 1);
        
        $minLeg = min($leftBalance['balance'], $rightBalance['balance']);


        $designation = SalarySlot::where('left_amount', '<=', $minLeg)
            ->where('right_amount', '<=', $minLeg)
            ->orderBy('salary_amount', 'desc')
            ->first();


        $global_settings = GlobalSettings::where('id', 1)->first();
        $deposit_rate = $global_settings->deposit_rate;
        $withdraw_rate = $global_settings->withdraw_rate;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $client->id,
                'name' => $client->name,
                'phone' => $client->phone,
                'email' => $client->email,
                'address' => $client->address,
                'photo' => $client->photo,
                'income_balance' => $client->income_balance,
                'deposit_balance' => $client->deposit_balance,
                'investment_balance' => $client->investment_balance,


                'deposit_rate' => $deposit_rate,
                'withdraw_rate' => $withdraw_rate,

                'left_balance' => $leftBalance['balance'],
                'right_balance' => $rightBalance['balance'],

                'rank' => $designation ? $designation->rank : '',
                'designation' => $designation ? $designation->name : '',
                'salary_amount' => $designation ? $designation->salary_amount : 0,

            ]
        ]);
    }

}
