<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Get client verification information.
     */
 
    public function update(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',

            'first_name' => 'required|string|max:45',
            'last_nanme' => 'required|string|max:45',
            'date_of_birth' => 'required|date',

            'verification_address' => 'required|string|max:255',
            'post_code' => 'required|string|max:45',
            'city' => 'required|string|max:45',

            'doc_type' => 'required|integer|in:1,2,3',
            'doc_images' => 'required|array|min:1',
            'doc_images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if (in_array($request->doc_type, [1, 3])
            && count($request->file('doc_images')) < 2) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Front and back images are required for this document type.',
            ], 422);
        }

        $client = Client::findOrFail(
            $request->client_id
        );


        $documentPath = $request
            ->file('doc_img')
            ->store(
                'verification-documents',
                'public'
            );


        $client->update([

            'first_name' => $request->first_name,

            // Database currently has this typo
            'last_nanme' => $request->last_nanme,

            'date_of_birth' => $request->date_of_birth,

            'verification_address' =>
                $request->verification_address,

            'post_code' => $request->post_code,

            'city' => $request->city,

            'doc_type' => $request->doc_type,

            'doc_img' => $documentPath,

            'verification_status' => 1,

        ]);


        return response()->json([
            'success' => true,
            'message' =>
                'Verification submitted successfully.',
        ]);

    }
 

    public function show($clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Decode multiple document images
        |--------------------------------------------------------------------------
        */

        $docImages = [];


        if ($client->doc_img) {

            $decodedImages = json_decode(
                $client->doc_img,
                true
            );


            /*
            * New format: JSON array
            */

            if (is_array($decodedImages)) {

                $docImages = $decodedImages;

            } else {

                /*
                * Backward compatibility:
                * old records may contain one image path only
                */

                $docImages = [
                    $client->doc_img
                ];

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Create public URLs
        |--------------------------------------------------------------------------
        */

        $docImageUrls = array_map(

            function ($imagePath) {

                return url(
                    Storage::url($imagePath)
                );

            },

            $docImages

        );


        return response()->json([

            'success' => true,

            'data' => [

                'id' =>
                    $client->id,

                'first_name' =>
                    $client->first_name,

                'last_nanme' =>
                    $client->last_nanme,

                'date_of_birth' =>
                    $client->date_of_birth,

                'verification_address' =>
                    $client->verification_address,

                'post_code' =>
                    $client->post_code,

                'city' =>
                    $client->city,

                'verification_status' =>
                    (int) $client->verification_status,

                'verification_description' =>
                    $client->verification_description,

                'doc_type' =>
                    $client->doc_type,


                /*
                * Raw image paths
                */

                'doc_images' =>
                    $docImages,


                /*
                * Public image URLs
                */

                'doc_image_urls' =>
                    $docImageUrls,

            ],

        ]);
    }


    /**
     * STEP 1
     * Update personal information.
     */
    public function updateStep1(Request $request, $clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found.',
            ], 404);
        }

        if ((int) $client->verification_status !== 0) {
            return response()->json([
                'success' => false,
                'message' => 'Verification has already been submitted. Editing is not allowed.',
            ], 403);
        }


        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:45',
            ],

            'last_name' => [
                'required',
                'string',
                'max:45',
            ],

            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }


        $client->update([
            'first_name' => $request->first_name,

            // Database column currently has this spelling
            'last_nanme' => $request->last_name,

            'date_of_birth' => $request->date_of_birth,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Step 1 completed successfully.',
            'data' => $client->fresh(),
        ]);
    }


    /**
     * STEP 2
     * Update address information.
     */
    public function updateStep2(Request $request, $clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found.',
            ], 404);
        }

        if ((int) $client->verification_status !== 0) {
            return response()->json([
                'success' => false,
                'message' => 'Verification has already been submitted. Editing is not allowed.',
            ], 403);
        }


        $validator = Validator::make($request->all(), [
            'verification_address' => [
                'required',
                'string',
                'max:255',
            ],

            'post_code' => [
                'required',
                'numeric',
            ],

            'city' => [
                'required',
                'string',
                'max:45',
            ],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }


        $client->update([
            'verification_address' => $request->verification_address,
            'post_code' => $request->post_code,
            'city' => $request->city,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Step 2 completed successfully.',
            'data' => $client->fresh(),
        ]);
    }


    /**
     * STEP 3
     * Update document type and upload document image.
     *
     * doc_type:
     * 1 = NID
     * 2 = Passport
     * 3 = Driving License
     */
    public function updateStep3(Request $request, $clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found.',
            ], 404);
        }


        if ((int) $client->verification_status !== 0) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Verification has already been submitted. Editing is not allowed.',
            ], 403);

        }


        $validator = Validator::make($request->all(), [

            'doc_type' => [
                'required',
                'integer',
                'in:1,2,3',
            ],

            'doc_images' => [
                'required',
                'array',
                'min:1',
            ],

            'doc_images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

        ]);


        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);

        }


        $images = $request->file('doc_images');


        /*
        * NID and Driving License require
        * exactly Front + Back.
        */

        if (
            in_array((int) $request->doc_type, [1, 3]) &&
            count($images) !== 2
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Front and back images are required for this document type.',
            ], 422);

        }


        /*
        * Passport requires exactly one image.
        */

        if (
            (int) $request->doc_type === 2 &&
            count($images) !== 1
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Passport requires exactly one image.',
            ], 422);

        }


        /*
        * Delete old document images.
        *
        * This assumes doc_img stores JSON.
        */

        $oldImages = $client->doc_img
            ? json_decode($client->doc_img, true)
            : [];


        if (is_array($oldImages)) {

            foreach ($oldImages as $oldImage) {

                if (
                    Storage::disk('public')->exists($oldImage)
                ) {

                    Storage::disk('public')->delete(
                        $oldImage
                    );

                }

            }

        }


        /*
        * Upload all new images.
        */

        $documentPaths = [];


        foreach ($images as $image) {

            $documentPaths[] = $image->store(
                'verification-documents/' . $client->id,
                'public'
            );

        }


        /*
        * Save images as JSON.
        */

        $client->update([

            'doc_type' =>
                $request->doc_type,

            'doc_img' =>
                json_encode($documentPaths),

            'verification_status' =>
                2,

            'verification_description' =>
                null,

        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Verification submitted successfully.',

            'data' => [

                'id' =>
                    $client->id,

                'doc_type' =>
                    $client->doc_type,

                'doc_images' =>
                    $documentPaths,

            ],

        ]);
    }
}