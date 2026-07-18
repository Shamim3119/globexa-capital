<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
 

class ClientController extends Controller
{
    public function show(Request $request)
    {
        $client = Client::select('id','name','phone')
            ->find($request->id);

        if (!$client) {
            return response()->json([
                'status' => false,
                'message' => 'Receiver not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $client
        ]);
    }
}