<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;

use App\Models\GlobalSettings;
use App\Models\ClientAccount;
use Illuminate\Support\Facades\DB;
use App\Mail\AdminWithdrawNotification;
use App\Mail\WithdrawOtpMail;
use App\Models\Business;


class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdraw::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('withdraw_by')) {
            $query->where('withdraw_by', $request->withdraw_by);
        }

        $data = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }



    public function sendOtp(Request $request)
    {
        $request->validate([
            'withdraw_by' => 'required|integer',
        ]);

        $client = Client::find($request->withdraw_by);

        if (!$client) {
            return response()->json([
                'status' => false,
                'message' => 'Client not found.'
            ],404);
        }

        if (empty($client->email)) {
            return response()->json([
                'status' => false,
                'message' => 'Client email not found.'
            ]);
        }

        $otp = rand(100000,999999);

        $client->update([
            'otp' => $otp
        ]);

        Mail::to($client->email)
            ->send(new WithdrawOtpMail($otp));

            /*
        Mail::raw("Your withdrawal OTP is: {$otp}", function($message) use ($client){
            $message->to($client->email)
                    ->subject('Withdrawal OTP');
        });

        */

        return response()->json([
            'status'=>true,
            'message'=>'OTP sent successfully.'
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'withdraw_by' => 'required|integer',
            'account_id'  => 'required|integer',
            'amount'      => 'required|numeric|min:0.01',
            'otp'         => 'required|string',
        ]);

        // Start a database transaction and lock the client row for update
        DB::beginTransaction();

        try {
            // lockForUpdate() prevents other concurrent requests from reading 
            // or modifying this client record until this transaction commits/rolls back.
            $client = Client::where('id', $request->withdraw_by)->lockForUpdate()->first();

            if (!$client) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Client not found'
                ], 404);
            }

            if ((string)$client->otp !== (string)$request->otp) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP'
                ], 422);
            }

            // Prevent negative balance (Now safely protected by the row lock)
            if ($client->income_balance < $request->amount) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient income balance.'
                ], 422);
            }

            $account = ClientAccount::with('operator.currency')
                ->findOrFail($request->account_id);

            $settings = GlobalSettings::first();

            $currency = strtoupper(
                $account->operator->currency->name ?? ''
            );

            if ($currency == 'USD') {
                $conversionAmount = $request->amount;
            } else {
                $conversionAmount = $request->amount * ($settings->withdraw_rate ?? 1);
            }

            $conversionRate = ($currency == 'USD')
            ? 1
            : ($settings->withdraw_rate ?? 1);

            $withdraw = Withdraw::create([
                'withdraw_by'       => $request->withdraw_by,
                'account_id'        => $request->account_id,
                'amount'            => $request->amount,
                'rate'              => $conversionRate,
                'send_amount'       => $conversionAmount,
                'status_id'         => 1,
            ]);

            // Deduct income balance
            $client->decrement('income_balance', $request->amount);

            // Clear OTP (Also invalidates the OTP so it can't be reused)
            $client->update([
                'otp' => null
            ]);

            $business = Business::first();

            if (
                $business &&
                !empty($business->notification_email)
            ) {
                Mail::to($business->notification_email)
                    ->send(
                        new AdminWithdrawNotification(
                            $withdraw,
                            $client,
                            $account
                        )
                    );
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Withdraw created successfully',
                'data' => $withdraw
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