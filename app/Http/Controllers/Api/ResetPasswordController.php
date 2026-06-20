<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{

 
    public function checkID(Request $request)
    {
 
    	$userid = $request->input('userid');
    
        if($userid != null)
        {
            $client = Client::find($userid);

            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
            }

            try {
 
                $otp = random_int(100000, 999999);
    
    			$email = $client->email; 
            
                Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
                    $message->to($email)
                            ->subject('Verification Code');
                });

                $client->update([
                    'otp' => $otp,
                ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Valid User ID',
                    'userid' => $userid,
                    'email' => $email,
                ], 200);


            } catch (\Exception $e) {

                    return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
            }

        }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
        }
 
    }

    public function checkOtp(Request $request)
    {
        
        $userid = $request->input('userid');
        $otp = $request->input('otp');
    
        if($userid != null && $otp != null)
        {
            $client = Client::find($userid);

            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
            }

            try {
 
                if($otp !=  $client->otp)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid OTP Code.'
                    ], 400);
                }
    
                return response()->json([
                    'success' => true,
                    'message' => 'Valid User ID',
                    'userid' => $userid,
                    'otp' => $otp,
                ], 200);


            } catch (\Exception $e) {

                    return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
            }

        }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
        }
 
    }

    public function reset(Request $request)
    {
        $userid = $request->input('userid');
      	$otp = $request->input('otp');
        $password = $request->input('password');
    
        if($userid != null && $password != null  && $otp != null)
        {
            $client = Client::find($userid);

            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
            }

            try {
 
                if($otp !=  $client->otp)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid OTP Code.'
                    ], 400);
                }
            
            
                $client->update([
                    'password' => Hash::make($password),
                ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset has been successfull',
                ], 200);


            } catch (\Exception $e) {

                    return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
            }

        }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID'
                ], 400);
        }
 
    }

 
 
}
