<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{

    public function index(Request $request)
    {
        $query = Transfer::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $data = $query->orderByDesc('id')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount'    => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {

            $client = Client::lockForUpdate()->findOrFail($request->client_id);

            if ($request->amount > $client->income_balance) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Insufficient Income Balance.'
                ], 422);
            }

            $beforeIncome  = $client->income_balance;
            $beforeDeposit = $client->deposit_balance;

            $afterIncome   = $beforeIncome - $request->amount;
            $afterDeposit  = $beforeDeposit + $request->amount;

            // Update client balances
            $client->update([
                'income_balance'  => $afterIncome,
                'deposit_balance' => $afterDeposit,
            ]);

            // Save transfer history
            Transfer::create([
                'client_id'       => $client->id,
                'bofore_incom'    => $beforeIncome,
                'before_deposit'  => $beforeDeposit,
                'amount'          => $request->amount,
                'after_incom'     => $afterIncome,
                'after_deposit'   => $afterDeposit,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Transfer completed successfully.',
                'data'    => [
                    'income_balance'  => $afterIncome,
                    'deposit_balance' => $afterDeposit,
                ]
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}