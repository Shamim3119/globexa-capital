<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankOperator;

class BankOperatorController extends Controller
{
    public function index()
    {
        $operators = BankOperator::with(['bank_type', 'currency'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $operators
        ]);
    }
}