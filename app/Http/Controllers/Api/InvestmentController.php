<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investment;
use Illuminate\Validation\Rule;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalSettings;
use App\Models\IncomeReference;
use App\Models\IncomeDaily;
use App\Models\Refund;

class InvestmentController extends Controller
{
    /**
     * GET
     * List all accounts or single account
     */


    public function index(Request $request)
    {
        $query = Investment::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $accounts = $query
            ->with([
                'commission_info:id,level,day,deposite_commission'
            ])
            ->addSelect([
                'total_income' => IncomeDaily::selectRaw('COALESCE(SUM(amount),0)')
                    ->whereColumn('income_dailies.client_id', 'investments.client_id')
                    ->whereColumn('income_dailies.invest_id', 'investments.id'),

                'refund_status' => Refund::select('status_id')
                    ->whereColumn('refunds.investment_id', 'investments.id')
                    ->limit(1),
            ])
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $accounts
        ]);
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:investments,id',
            'investment_id' => 'required|exists:deposite_commissions,id',
        ]);

        $investment = Investment::findOrFail($request->id);

        if ($request->investment_id <= $investment->investment_id) {
            return response()->json([
                'status' => false,
                'message' => 'Only upgrade allowed.'
            ], 422);
        }

        $investment->investment_id = $request->investment_id;
        $investment->save();

        return response()->json([
            'status' => true,
            'message' => 'Investment upgraded successfully.'
        ]);
    }

    /**
     * POST
     * Insert or Update
     */
    public function save(Request $request)
    {
        $request->validate([
            'client_id'     => 'required|exists:clients,id',
            'investment_id' => 'required|integer',
            'amount'        => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {

            $client = Client::find($request->client_id);

            if (!$client) {
                return response()->json([
                    'status' => false,
                    'message' => 'Client not found.'
                ], 404);
            }

            // Update Investment
            if ($request->filled('id')) {

                $investment = Investment::find($request->id);

                if (!$investment) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Investment not found.'
                    ], 404);
                }

                $investment->update([
                    'investment_id' => $request->investment_id,
                    'amount'        => $request->amount,
                ]);

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Investment updated successfully.',
                    'data' => $investment
                ]);
            }

            // Create Investment

            $beforeInvest = $client->deposit_balance;

            if ($beforeInvest < $request->amount) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient deposit balance.'
                ], 422);
            }

            $afterInvest = $beforeInvest - $request->amount;

            $investment = Investment::create([
                'client_id'      => $request->client_id,
                'investment_id'  => $request->investment_id,
                'amount'         => $request->amount,
                'before_invest'  => $beforeInvest,
                'after_invest'   => $afterInvest,
            ]);

            $client->deposit_balance = $afterInvest;
            $client->investment_balance += $request->amount;
            $client->inactive = 0;
            $client->save();

            $setting = GlobalSettings::first();

            if ($setting && $setting->ref_comm > 0 && $client->ref_id) {

                $refCommission = ($request->amount * $setting->ref_comm) / 100;

                $refClient = Client::find($client->ref_id);

                $refClient = Client::where('id', $client->ref_id)
                ->where('inactive', 0)
                ->first();

                if ($refClient) {

                    // update ref client balance
                    $refClient->income_balance += $refCommission;
                    $refClient->save();

                    // insert income reference record
                    IncomeReference::create([
                        'client_id' => $client->ref_id,
                        'amount'    => $refCommission,
                        'invest_id' => $investment->id,
                    ]);
                }
            }
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Investment created successfully.',
                'data' => $investment
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
