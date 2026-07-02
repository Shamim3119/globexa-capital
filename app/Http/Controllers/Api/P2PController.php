<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P2P;

class P2PController extends Controller
{
    /**
     * GET
     * List all transfers or a single transfer
     */
    public function index(Request $request)
    {
        $query = P2P::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('from_id')) {
            $query->where('from_id', $request->from_id);
        }

        if ($request->filled('to_id')) {
            $query->where('to_id', $request->to_id);
        }

        $transfers = $query->orderBy('id', 'desc')->get();

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

            $p2p = P2P::find($request->id);

            if (!$p2p) {
                return response()->json([
                    'status' => false,
                    'message' => 'P2P transfer not found.'
                ], 404);
            }

            $p2p->update([
                'from_id' => $request->from_id,
                'to_id'   => $request->to_id,
                'amount'  => $request->amount,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'P2P transfer updated successfully.',
                'data' => $p2p
            ]);
        }

        $p2p = P2P::create([
            'from_id' => $request->from_id,
            'to_id'   => $request->to_id,
            'amount'  => $request->amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'P2P transfer created successfully.',
            'data' => $p2p
        ], 201);
    }
}