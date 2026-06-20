<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;


class LoginController extends Controller
{
 
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

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $client->id,
                'name' => $client->name,
            ]
        ]);
    }

}
