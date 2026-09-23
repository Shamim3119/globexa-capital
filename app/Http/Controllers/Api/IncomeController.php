<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\IncomeDaily;
use App\Models\IncomeReference;
use App\Models\IncomeGeneration;
use App\Models\IncomeSalary;
use App\Models\IncomeIB;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        switch ($request->type) {

            case 'Daily Income':
                $model = IncomeDaily::class;
                break;

            case 'References Income':
                $model = IncomeReference::class;
                break;

            case 'Generation Income':
                $model = IncomeGeneration::class;
                break;

            case 'Salaries Income':
                $model = IncomeSalary::class;
                break;

            case 'IB Income':
            case 'IBS Income':
                $model = IncomeIB::class;
                break;

            default:
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Income Type'
                ], 400);
        }

        $rows = $model::where('client_id', $request->client_id)
            ->whereDate('created_at', '>=', $request->from_date)
            ->whereDate('created_at', '<=', $request->to_date)
            ->orderBy('created_at', 'asc')
            ->get([
                'amount',
                'created_at'
            ]);

        return response()->json([
            'status' => true,
            'type' => $request->type,
            'total' => $rows->sum('amount'),
            'data' => $rows
        ]);
    }
}
