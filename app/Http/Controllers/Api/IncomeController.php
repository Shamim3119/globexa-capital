<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\IncomeDaily;
use App\Models\IncomeReferences;
use App\Models\IncomeGeneration;
use App\Models\IncomeSalaries;
use App\Models\IncomeIBS;

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
                $model = IncomeReferences::class;
                break;

            case 'Generation Income':
                $model = IncomeGeneration::class;
                break;

            case 'Salaries Income':
                $model = IncomeSalaries::class;
                break;

            case 'IBS Income':
                $model = IncomeIBS::class;
                break;

            default:
                return response()->json([
                    'status'=>false,
                    'message'=>'Invalid Income Type'
                ]);
        }

        $rows = $model::where('client_id',$request->client_id)
            ->whereDate('create_date','>=',$request->from_date)
            ->whereDate('create_date','<=',$request->to_date)
            ->orderBy('create_date')
            ->get([
                'amount',
                'create_date'
            ]);

        return response()->json([
            'status'=>true,
            'type'=>$request->type,
            'total'=>$rows->sum('amount'),
            'data'=>$rows
        ]);
    }
}