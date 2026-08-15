<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\GlobalSettings;
use App\Models\BussinessAccount;

class DepositController extends Controller
{
    /**
     * GET LIST
     */
    public function index(Request $request)
    {
        $query = Deposit::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('deposit_by')) {
            $query->where('deposit_by', $request->deposit_by);
        }

        $data = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * INSERT / UPDATE
     */
    public function save(Request $request)
    {
        $request->validate([
            'deposit_by'  => 'nullable|integer',
            'account_id'  => 'nullable|integer',
            'amount' => 'required|numeric|min:0.01',
            'status_id'   => 'nullable|integer',
            'trxid'       => 'required|string|max:255',
            'deposit_doc' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        if ($request->filled('id')) {

            $deposit = \App\Models\Deposit::find($request->id);

            if (!$deposit) {
                return response()->json([
                    'status' => false,
                    'message' => 'Deposit not found'
                ], 404);
            }

            $deposit->update([
                'deposit_by'  => $request->deposit_by,
                'account_id'  => $request->account_id,
                'amount'      => $request->amount,
                'status_id'   => 1,
                'trxid'       => $request->trxid,
                'deposit_doc' => $deposit->deposit_doc,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Deposit updated successfully',
                'data' => $deposit
            ]);
        }

        $globalSetting = GlobalSettings::first();
        if (!$globalSetting) {

            return response()->json([
                'status' => false,
                'message' => 'Global settings not found.'
            ], 500);
        }

        if ($request->amount < $globalSetting->min_deposit) {

            return response()->json([
                'status' => false,
                'message' => 'Minimum deposit amount is ' .
                    $globalSetting->min_deposit . '.'
            ], 422);
        }

        if ($request->amount > $globalSetting->max_deposit) {

            return response()->json([
                'status' => false,
                'message' => 'Maximum deposit amount is ' .
                    $globalSetting->max_deposit . '.'
            ], 422);
        }


        $filePath = null;
        // ✅ upload image to public/storage/deposit
        if ($request->hasFile('deposit_doc')) {

            $file = $request->file('deposit_doc');

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destination = public_path('storage/deposit');

            // make sure folder exists
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            $file->move($destination, $fileName);

            $filePath = 'storage/deposit/' . $fileName;
        }


        $bussinessAccount = BussinessAccount::with('operator')->find($request->account_id);
        $currencyId = $bussinessAccount?->operator?->currency_id;

        $exchange_amount = $request->amount;
        if($currencyId != 1){
            $exchange_amount = $request->amount * $globalSetting?->deposit_rate;
        }

        $deposit = \App\Models\Deposit::create([
            'deposit_by'  => $request->deposit_by,
            'account_id'  => $request->account_id,
            'amount'      => $request->amount,
            'status_id'   => 1,
            'trxid'       => $request->trxid,
            'deposit_doc' => $filePath,
            'exchange_amount' => $exchange_amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Deposit created successfully',
            'data' => $deposit
        ], 201);
    }
}