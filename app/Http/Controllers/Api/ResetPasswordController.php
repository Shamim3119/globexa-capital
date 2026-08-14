<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordOtpMail;

class ResetPasswordController extends Controller
{
    /**
     * Send OTP for password reset
     */
    public function checkID(Request $request)
    {
        $request->validate([
            'userid' => 'required|integer',
        ]);

        $userid = $request->userid;

        $client = Client::find($userid);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid User ID'
            ], 400);
        }

        if (empty($client->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not found for this account.'
            ], 400);
        }

        try {

            // Generate 6 digit OTP
            $otp = random_int(100000, 999999);

            // Save OTP
            $client->update([
                'otp' => $otp,
            ]);

            // Send OTP email
            Mail::to($client->email)
                ->send(new ResetPasswordOtpMail($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'userid' => $userid,
                'email' => $client->email,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to send OTP. Please try again.'
            ], 500);
        }
    }


    /**
     * Verify OTP
     */
    public function checkOtp(Request $request)
    {
        $request->validate([
            'userid' => 'required|integer',
            'otp' => 'required|string',
        ]);

        $userid = $request->userid;
        $otp = $request->otp;

        $client = Client::find($userid);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid User ID'
            ], 400);
        }

        if (empty($client->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP not found. Please request a new OTP.'
            ], 400);
        }

        if ((string) $otp !== (string) $client->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP Code.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            'userid' => $userid,
            'otp' => $otp,
        ], 200);
    }


    /**
     * Reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'userid' => 'required|integer',
            'otp' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $userid = $request->userid;
        $otp = $request->otp;
        $password = $request->password;

        $client = Client::find($userid);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid User ID'
            ], 400);
        }

        if (empty($client->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP not found. Please request a new OTP.'
            ], 400);
        }

        // Verify OTP
        if ((string) $otp !== (string) $client->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP Code.'
            ], 400);
        }

        try {

            // Update password
            $client->update([
                'password' => Hash::make($password),

                // Clear OTP after successful password reset
                'otp' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password reset has been successful.'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to reset password. Please try again.'
            ], 500);
        }
    }
}

