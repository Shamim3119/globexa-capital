<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BussinessAccount;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalSettings;
use App\Models\Business;

class BusinessAccountController extends Controller
{


    public function pdf_doc()
    {
        $business = Business::first();

        if (!$business || !$business->company_doc) {
            return response()->json([
                'status' => false,
                'message' => 'Company document not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'company_doc' => asset('storage/'.$business->company_doc)
            ]
        ]);
    }


    public function index()
    {
        $data = BussinessAccount::query()
            ->leftJoin('bank_operators as o', 'o.id', '=', 'bussiness_accounts.operator_id')
            ->leftJoin('parameters as c', 'c.id', '=', 'o.currency_id')
            ->leftJoin('parameters as t', 't.id', '=', 'o.type_id')
            ->select(
                'bussiness_accounts.id',
                'bussiness_accounts.account_no',
                'bussiness_accounts.account_name',
                'bussiness_accounts.qr_code',
                'o.name as operator',
                'c.name as currency',
                't.name as banking'
            )
            ->orderBy('bussiness_accounts.account_name')
            ->get();

        $globalSetting = GlobalSettings::first();

        return response()->json([
            'status' => true,
            'withdraw_rate' => $globalSetting?->withdraw_rate,
            'deposit_rate' => $globalSetting?->deposit_rate,
            'data' => $data
        ]);

    }
}