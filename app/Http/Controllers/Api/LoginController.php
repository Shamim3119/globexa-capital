<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\SalarySlot;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalSettings;
use App\Models\ClientDevice;
use App\Models\LoginOtp;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeviceVerificationOtpMail;

class LoginController extends Controller
{

    private function getLegData($parentId, $site)
    {
        $result = DB::select("
            WITH RECURSIVE tree AS (
                SELECT id, investment_balance
                FROM clients
                WHERE ref_id = ? AND site = ?

                UNION ALL

                SELECT c.id, c.investment_balance
                FROM clients c
                INNER JOIN tree t ON c.ref_id = t.id
            )
            SELECT
                COUNT(*) AS total,
                COALESCE(SUM(investment_balance),0) AS balance
            FROM tree
        ", [$parentId, $site]);

        return [
            'count' => $result[0]->total ?? 0,
            'balance' => $result[0]->balance ?? 0,
        ];
    }
 
    /*
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

        $leftBalance = $this->getLegData($client->id, 0);
        $rightBalance = $this->getLegData($client->id, 1);
        
        $minLeg = min($leftBalance['balance'], $rightBalance['balance']);


        $designation = SalarySlot::where('left_amount', '<=', $minLeg)
            ->where('right_amount', '<=', $minLeg)
            ->orderBy('salary_amount', 'desc')
            ->first();


        $global_settings = GlobalSettings::where('id', 1)->first();
        $deposit_rate = $global_settings->deposit_rate;
        $withdraw_rate = $global_settings->withdraw_rate;

        $token = $client->createToken('client-web')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $client->id,
                'name' => $client->name,
                'phone' => $client->phone,
                'email' => $client->email,
                'address' => $client->address,
                'photo' => $client->photo,
                
                'income_balance' => number_format($client->income_balance, 2, '.', ''),
                'deposit_balance' => number_format($client->deposit_balance, 2, '.', ''),
                'investment_balance' => number_format($client->investment_balance, 2, '.', ''),

 


                'deposit_rate' => $deposit_rate,
                'withdraw_rate' => $withdraw_rate,

                'left_balance' => $leftBalance['balance'],
                'right_balance' => $rightBalance['balance'],

                'rank' => $designation ? $designation->rank : '',
                'designation' => $designation ? $designation->name : '',
                'salary_amount' => $designation ? $designation->salary_amount : 0,

            ]
        ]);
    }
    */

    public function login(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' => 'required',
            'device_id' => 'required|string|max:191',
            'device_name' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:50',
        ]);


        $client = Client::where(
            'id',
            $request->userid
        )->first();


        if (!$client) {

            return response()->json([
                'success' => false,
                'message' => 'User ID not found',
            ], 404);

        }


        if (!Hash::check(
            $request->password,
            $client->password
        )) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid password',
            ], 401);

        }


        /*
        |--------------------------------------------------------------------------
        | Check Trusted Device
        |--------------------------------------------------------------------------
        */

        $device = ClientDevice::where(
            'client_id',
            $client->id
        )
            ->where(
                'device_id',
                $request->device_id
            )
            ->whereNotNull('verified_at')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Existing Trusted Device
        |--------------------------------------------------------------------------
        */

        if ($device) {

            $device->update([
                'last_login_at' => now(),
                'device_name' => $request->device_name,
                'platform' => $request->platform,
            ]);


            return $this->successfulLogin(
                $client,
                'Login successful.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | New Device
        |--------------------------------------------------------------------------
        */

        // Invalidate old OTPs for this device
        LoginOtp::where('client_id', $client->id)
            ->where('device_id', $request->device_id)
            ->whereNull('verified_at')
            ->update([
                'verified_at' => now(),
            ]);


        /*
        |--------------------------------------------------------------------------
        | Generate 6 Digit OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(
            100000,
            999999
        );


        LoginOtp::create([
            'client_id' => $client->id,

            'device_id' => $request->device_id,

            'otp_hash' => Hash::make($otp),

            'expires_at' => now()->addMinutes(10),

            'attempts' => 0,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send OTP Email
        |--------------------------------------------------------------------------
        */

 

        Mail::to($client->email)
            ->send(new DeviceVerificationOtpMail($otp));


        return response()->json([
            'success' => true,

            'device_verification_required' => true,

            'message' =>
                'A verification code has been sent to your registered email address.',

            'email' => $this->maskEmail(
                $client->email
            ),
        ], 202);
    }

    public function verifyDevice(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'device_id' => 'required|string|max:191',
            'otp' => 'required|digits:6',
            'device_name' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:50',
        ]);


        $client = Client::find($request->userid);


        if (!$client) {

            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);

        }


        $otpRecord = LoginOtp::where(
            'client_id',
            $client->id
        )
            ->where(
                'device_id',
                $request->device_id
            )
            ->whereNull('verified_at')
            ->latest('id')
            ->first();


        if (!$otpRecord) {

            return response()->json([
                'success' => false,
                'message' => 'Verification code not found.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Expired
        |--------------------------------------------------------------------------
        */

        if ($otpRecord->expires_at->isPast()) {

            return response()->json([
                'success' => false,
                'message' => 'Verification code has expired.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Maximum Attempts
        |--------------------------------------------------------------------------
        */

        if ($otpRecord->attempts >= 5) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Too many incorrect attempts. Please login again.',
            ], 429);

        }


        /*
        |--------------------------------------------------------------------------
        | Verify OTP
        |--------------------------------------------------------------------------
        */

        if (!Hash::check(
            $request->otp,
            $otpRecord->otp_hash
        )) {

            $otpRecord->increment('attempts');

            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Mark OTP Verified
        |--------------------------------------------------------------------------
        */

        $otpRecord->update([
            'verified_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Approve Device
        |--------------------------------------------------------------------------
        */

        ClientDevice::updateOrCreate(
            [
                'client_id' => $client->id,
                'device_id' => $request->device_id,
            ],
            [
                'device_name' => $request->device_name,
                'platform' => $request->platform,
                'verified_at' => now(),
                'last_login_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Create Sanctum Token
        |--------------------------------------------------------------------------
        */

        return $this->successfulLogin(
            $client,
            'Device verified. Login successful.'
        );
    }

    private function successfulLogin(Client $client,string $message)
    {
        $leftBalance =
            $this->getLegData($client->id, 0);

        $rightBalance =
            $this->getLegData($client->id, 1);


        $minLeg = min(
            $leftBalance['balance'],
            $rightBalance['balance']
        );


        $designation = SalarySlot::where(
            'left_amount',
            '<=',
            $minLeg
        )
            ->where(
                'right_amount',
                '<=',
                $minLeg
            )
            ->orderBy(
                'salary_amount',
                'desc'
            )
            ->first();


        $global_settings =
            GlobalSettings::where('id', 1)->first();


        $deposit_rate =
            $global_settings->deposit_rate;

        $withdraw_rate =
            $global_settings->withdraw_rate;

        $withdraw_rate_banking =
            $global_settings->withdraw_rate_banking;

            


        $token =
            $client
                ->createToken('client-web')
                ->plainTextToken;


        return response()->json([

            'success' => true,

            'message' => $message,

            'token' => $token,

            'user' => [

                'id' => $client->id,

                'name' => $client->name,

                'phone' => $client->phone,

                'email' => $client->email,

                'address' => $client->address,

                'photo' => $client->photo,

                'income_balance' =>
                    number_format(
                        $client->income_balance,
                        2,
                        '.',
                        ''
                    ),

                'deposit_balance' =>
                    number_format(
                        $client->deposit_balance,
                        2,
                        '.',
                        ''
                    ),

                'investment_balance' =>
                    number_format(
                        $client->investment_balance,
                        2,
                        '.',
                        ''
                    ),

                'deposit_rate' =>
                    $deposit_rate,

                'withdraw_rate' =>
                    $withdraw_rate,

                'withdraw_rate_banking' =>
                    $withdraw_rate_banking,


                'left_balance' =>
                    $leftBalance['balance'],

                'right_balance' =>
                    $rightBalance['balance'],

                'rank' =>
                    $designation
                        ? $designation->rank
                        : '',

                'designation' =>
                    $designation
                        ? $designation->name
                        : '',

                'salary_amount' =>
                    $designation
                        ? $designation->salary_amount
                        : 0,
            ],
        ]);
    }


    private function maskEmail($email)
    {
        if (!$email || !str_contains($email, '@')) {
            return '';
        }


        [$name, $domain] =
            explode('@', $email, 2);


        $visible =
            substr($name, 0, 2);


        return $visible
            . str_repeat('*', max(1, strlen($name) - 2))
            . '@'
            . $domain;
    }
}
