<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P2P;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

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

        if ($request->filled('id')) {
            // Your existing update logic...
        }

        DB::beginTransaction();

        try {

            $sender = Client::lockForUpdate()->find($request->from_id);
            $receiver = Client::lockForUpdate()->find($request->to_id);

            if ($sender->deposit_balance < $request->amount) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient deposit balance.'
                ], 400);
            }

            // Deduct sender balance
            $sender->decrement('deposit_balance', $request->amount);

            // Add receiver balance
            $receiver->increment('deposit_balance', $request->amount);

            // Create transfer record
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