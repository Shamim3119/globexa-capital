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

        // =====================================================
        // Global Settings
        // =====================================================

        $settings = GlobalSettings::first();

        if (!$settings) {

            return response()->json([
                'status' => false,
                'message' => 'Global settings not found.'
            ], 500);
        }

        // =====================================================
        // Withdrawal Account
        // =====================================================

        $account = ClientAccount::with('operator.currency')
            ->find($request->account_id);

        if (!$account) {

            return response()->json([
                'status' => false,
                'message' => 'Withdrawal account not found.'
            ], 404);
        }

        $currency = strtoupper($account->operator->currency->name ?? '');

        // =====================================================
        // Withdrawal Limit
        // =====================================================

        if ($currency === 'USD') {

            $minWithdrawal = $settings->min_withdrawal;
            $maxWithdrawal = $settings->max_withdrawal;

        } elseif ($currency === 'BDT') {

            // type_id = 3
            if ($operatorTypeId === 3) {
                $minWithdrawal = $settings->min_withdrawal_bdt;
                $maxWithdrawal = $settings->max_withdrawal_bdt;
            }
            // General Banking
            // type_id = 7
            elseif ($operatorTypeId === 7) {
                $minWithdrawal = $settings->min_withdrawal_bank_bdt;
                $maxWithdrawal = $settings->max_withdrawal_bank_bdt;
            }
            // Unknown BDT operator type
            else {

                return response()->json([
                    'status' => false,
                    'message' => 'Unsupported BDT payment operator type.'
                ], 422);
            }

        } else {

            return response()->json([
                'status' => false,
                'message' => 'Unsupported withdrawal currency.'
            ], 422);
        }

        // =====================================================
        // Minimum Withdrawal Restriction
        // =====================================================

        if ($request->amount < $minWithdrawal) {

            return response()->json([
                'status' => false,
                'message' => 'Minimum ' . $currency .
                    ' withdrawal amount is ' . $minWithdrawal . '.'
            ], 422);
        }

        // =====================================================
        // Maximum Withdrawal Restriction
        // =====================================================

        if ($request->amount > $maxWithdrawal) {

            return response()->json([
                'status' => false,
                'message' => 'Maximum ' . $currency .
                    ' withdrawal amount is ' . $maxWithdrawal . '.'
            ], 422);
        }

        // =====================================================
        // Database Transaction
        // =====================================================

        DB::beginTransaction();

        try {

            // Lock client row
            $client = Client::where('id', $request->withdraw_by)
                ->lockForUpdate()
                ->first();

            if (!$client) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Client not found.'
                ], 404);
            }

            // =====================================================
            // OTP Verification
            // =====================================================

            if ((string) $client->otp !== (string) $request->otp) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP.'
                ], 422);
            }

            // =====================================================
            // Check Income Balance
            // =====================================================

            if ($client->income_balance < $request->amount) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient income balance.'
                ], 422);
            }

            // =====================================================
            // Conversion
            // =====================================================



            $operatorTypeId = (int) (
                $account->operator->type_id ?? 0
            );


            if ($currency === 'USD') {

                $conversionAmount = $request->amount;
                $conversionRate = 1;

            } else {

                $conversionRate = $settings->withdraw_rate ?? 1;

                $conversionAmount =
                    $request->amount * $conversionRate;
            }

            // =====================================================
            // Create Withdrawal
            // =====================================================

            $withdraw = Withdraw::create([
                'withdraw_by' => $request->withdraw_by,
                'account_id'  => $request->account_id,
                'amount'      => $request->amount,
                'rate'        => $conversionRate,
                'send_amount' => $conversionAmount,
                'status_id'   => 1,
            ]);

            // =====================================================
            // Deduct Income Balance
            // =====================================================

            $client->decrement(
                'income_balance',
                $request->amount
            );

            // =====================================================
            // Clear OTP
            // =====================================================

            $client->update([
                'otp' => null
            ]);

            // =====================================================
            // Admin Notification
            // =====================================================

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
                'message' => 'Withdraw created successfully.',
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