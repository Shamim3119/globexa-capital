<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\InvestmentCharge;
use App\Models\Refund;
use Carbon\Carbon;
 
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{

    public function index(Request $request)
    {

        $request->validate([
            'id' => 'required|integer'
        ]);


        $investment = Investment::with('investor')
            ->find($request->id);


        if(!$investment){

            return response()->json([
                'status'=>false,
                'message'=>'Investment not found'
            ],404);

        }



        // Calculate passed days

        $createdDate = Carbon::parse($investment->created_at);

        $daysPassed = $createdDate->diffInDays(Carbon::now());



        /*
            Find charge slab

            Example:
            day 90 charge 10%
            day 120 charge 8%
            day 180 charge 5%

            If daysPassed is 60
            use 90 days charge
        */


        $chargeRule = InvestmentCharge::where('day','>=',$daysPassed)
            ->orderBy('day','asc')
            ->first();



        // If already above maximum day use last charge

        if(!$chargeRule){

            $chargeRule = InvestmentCharge::orderBy('day','desc')
                ->first();

        }



        $chargePercent = $chargeRule 
            ? $chargeRule->charge 
            : 0;



        // Calculate refund

        $chargeAmount = 
            ($investment->amount * $chargePercent) / 100;


        $payableAmount = 
            $investment->amount - $chargeAmount;



        return response()->json([

            'status'=>true,

            'data'=>[

                'investment'=>$investment,

                'days_passed'=>$daysPassed,

                'charge'=>[
                    'day'=>$chargeRule->day ?? null,
                    'percentage'=>$chargePercent,
                    'amount'=>number_format($chargeAmount,2)
                ],


                'refund'=>[
                    'amount'=>number_format($payableAmount,2)
                ]

            ]

        ]);


    }


    public function save(Request $request)
    {
        $request->validate([
            'investment_id' => 'required|integer|exists:investments,id'
        ]);

        $investment = Investment::find($request->investment_id);

        if (!$investment) {
            return response()->json([
                'status' => false,
                'message' => 'Investment not found'
            ], 404);
        }

        // Prevent duplicate refund
        $lastRefund = Refund::where('investment_id', $investment->id)
            ->latest('id')
            ->first();

        if ($lastRefund && $lastRefund->status_id != 3) {
            return response()->json([
                'status' => false,
                'message' => 'Refund already submitted.'
            ], 400);
        }

        $daysPassed = Carbon::parse($investment->created_at)
            ->diffInDays(Carbon::now());

        $chargeRule = InvestmentCharge::where('day', '>=', $daysPassed)
            ->orderBy('day')
            ->first();

        if (!$chargeRule) {
            $chargeRule = InvestmentCharge::orderByDesc('day')->first();
        }

        $chargePercent = $chargeRule ? $chargeRule->charge : 0;

        $chargeAmount = ($investment->amount * $chargePercent) / 100;

        $returnAmount = $investment->amount - $chargeAmount;

        DB::beginTransaction();

        try {

        $lastRefund = Refund::where('investment_id', $investment->id)
        ->latest('id')
        ->first();

        if ($lastRefund) {

            // Latest request is not cancelled
            if ($lastRefund->status_id != 3) {
                return response()->json([
                    'status' => false,
                    'message' => 'Refund already submitted.'
                ], 400);
            }

            // Latest request was cancelled, reuse it
            $lastRefund->update([
                'client_id'      => $investment->client_id,
                'amount'         => $investment->amount,
                'charge'         => $chargePercent,
                'deduct'         => $chargeAmount,
                'pass_day'       => $daysPassed,
                'return_amount'  => $returnAmount,
                'status_id'      => 1, // Pending
            ]);

        } else {

            // No previous refund request
            Refund::create([
                'client_id'      => $investment->client_id,
                'investment_id'  => $investment->id,
                'amount'         => $investment->amount,
                'charge'         => $chargePercent,
                'deduct'         => $chargeAmount,
                'pass_day'       => $daysPassed,
                'return_amount'  => $returnAmount,
                'status_id'      => 1, // Pending
            ]);

        }
 
 

            $investment->update([
                'inactive' => 1,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Refund request submitted successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}