<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkRef(Request $request)
    {
 
        $url = $request->ref;

        $query = parse_url($url, PHP_URL_QUERY);

        parse_str($query, $params);

        $ref = $params['ref'] ?? null;

        if($ref != null){

            $side = substr($ref, -1);
            $id = base_convert(substr($ref, 0, -1), 36, 10);

            $client = Client::find($id);

            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid referral code'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Referral code is valid',
                'ref' => $id."|".$client->level."|".$side,
            ], 200);
        }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid referral code'
                ], 400);
        }
  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function varifiy(Request $request)
    {
        try {

        /*
            // ✅ manual validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            // ❌ if validation fails
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
*/

            $otp = random_int(100000, 999999);
 
            $email = $request->email; // store it first

            Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Verification Code');
            });
 


            return response()->json([
                'success' => true,
                'message' => 'Referral code is valid',
                'referral_id' => $request->referral_id,
                'referral_side' => $request->referral_side,
                'level' => $request->level,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'otp' => $otp,
            ], 200);


        } catch (\Exception $e) {

                    return response()->json([
                    'success' => false,
                    'message' => 'Invalid referral code'
                ], 400);
        }
 
    }

    public function store(Request $request)
    {
        try {
 

            $referral_side = 0;
            if(trim($request->referral_side) == 'R') {
                $referral_side = 1;
            }

            $client = Client::create([
                'ref_id' => $request->referral_id,
                'site' => $referral_side,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password), 
                'level' => $request->level + 1, 
            ]);


            $client->update([
               // 'left_side'  => Crypt::encryptString($client->id . '|L'),
               // 'right_side' => Crypt::encryptString($client->id . '|R'),
                'left_side' => base_convert($client->id, 10, 36) . 'L',
                'right_side' => base_convert($client->id, 10, 36) . 'R',
            ]);


            $msg  = ""; 
            $msg .= "<div class='mb-3'>";
            $msg .= "<div class='alert alert-success'>Registration successful</div>";
            
            $msg .= "<br><br>We send your User ID and Credential via your mail.<br><br></div>";

 

            return response()->json([
                'success' => true,
                'message' => $msg
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
