<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P2P;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\GlobalSettings;

class P2PController extends Controller
{
    /**
     * GET
     * List all transfers or a single transfer
     */
    public function index(Request $request)
    {
        $query = P2P::with([
            'sender:id,name',
            'receiver:id,name',
        ]);

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('from_id')) {
            $query->where('from_id', $request->from_id);
        }

        if ($request->filled('to_id')) {
            $query->where('to_id', $request->to_id);
        }

        if ($request->filled('both_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('from_id', $request->both_id)
                ->orWhere('to_id', $request->both_id);
            });
        }

        $transfers = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $transfers
        ]);
    }

    /**
     * POST
     * Insert or Update
     */
    public function save(Request $request)
    {
        $request->validate([
            'from_id' => 'required|exists:clients,id',
            'to_id'   => 'required|exists:clients,id|different:from_id',
            'amount'  => 'required|numeric|min:0.01',
        ]);

        // =====================================================
        // Global Settings
        // =====================================================

        $setting = GlobalSettings::first();

        if (!$setting) {

            return response()->json([
                'status' => false,
                'message' => 'Global settings not found.'
            ], 500);
        }

        // =====================================================
        // Minimum P2P Restriction
        // =====================================================

        if ($request->amount < $setting->min_p2p) {

            return response()->json([
                'status' => false,
                'message' => 'Minimum P2P transfer amount is ' . $setting->min_p2p . '.'
            ], 422);
        }

        // =====================================================
        // Maximum P2P Restriction
        // =====================================================

        if ($request->amount > $setting->max_p2p) {

            return response()->json([
                'status' => false,
                'message' => 'Maximum P2P transfer amount is ' . $setting->max_p2p . '.'
            ], 422);
        }

        // =====================================================
        // Transaction
        // =====================================================

        DB::beginTransaction();

        try {

            $sender = Client::lockForUpdate()
                ->find($request->from_id);

            $receiver = Client::lockForUpdate()
                ->find($request->to_id);

            // Check sender and receiver BEFORE using them
            if (!$sender || !$receiver) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Sender or receiver not found.'
                ], 404);
            }

            // =====================================================
            // Check Sender Balance
            // =====================================================

            if ($sender->deposit_balance < $request->amount) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient deposit balance.'
                ], 422);
            }

            // =====================================================
            // Deduct Sender Balance
            // =====================================================

            $sender->decrement(
                'deposit_balance',
                $request->amount
            );

            // =====================================================
            // Add Receiver Balance
            // =====================================================

            $receiver->increment(
                'deposit_balance',
                $request->amount
            );

            // =====================================================
            // Create Transfer Record
            // =====================================================

            $p2p = P2P::create([
                'from_id' => $request->from_id,
                'to_id'   => $request->to_id,
                'amount'  => $request->amount,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'P2P transfer completed successfully.',
                'data'    => $p2p
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