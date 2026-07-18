<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientAccount;
use Illuminate\Validation\Rule;

class ClientAccountController extends Controller
{
    /**
     * GET
     * List all accounts or single account
     */
    public function index(Request $request)
    {
        $query = ClientAccount::with([
            'operator:id,name,type_id,currency_id',
            'operator.bank_type:id,name',
            'operator.currency:id,name',
        ]);

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $accounts = $query
            ->orderByDesc('id')
            ->get();


        return response()->json([
            'status' => true,
            'data' => $accounts
        ]);
    }

    /**
     * POST
     * Insert or Update
     */
    public function save(Request $request)
    {
        $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'account_name' => 'required|string|max:255',
            'account_no'   => 'required|string|max:255',
            'operator_id'  => 'required|integer',
            'balance'      => 'nullable|numeric',
            'inactive'     => 'nullable|boolean',
        ]);

        if ($request->filled('id')) {

            $account = ClientAccount::find($request->id);

            if (!$account) {
                return response()->json([
                    'status' => false,
                    'message' => 'Account not found.'
                ], 404);
            }

            $account->update([
                'client_id'    => $request->client_id,
                'account_name' => $request->account_name,
                'account_no'   => $request->account_no,
                'operator_id'  => $request->operator_id,
                'balance'      => $request->balance ?? 0,
                'inactive'     => $request->inactive ?? 0,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Account updated successfully.',
                'data' => $account
            ]);
        }

        $account = ClientAccount::create([
            'client_id'    => $request->client_id,
            'account_name' => $request->account_name,
            'account_no'   => $request->account_no,
            'operator_id'  => $request->operator_id,
            'balance'      => $request->balance ?? 0,
            'inactive'     => $request->inactive ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Account created successfully.',
            'data' => $account
        ], 201);
    }
}