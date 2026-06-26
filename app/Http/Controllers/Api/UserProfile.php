<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; // IMPORTANT


class UserProfile extends Controller
{
    public $selectedClient = null;
    public $leftCount = 0;
    public $rightCount = 0;

    private function getLegCount($parentId, $site)
    {
        $result = DB::select("
            WITH RECURSIVE tree AS (
                SELECT id
                FROM clients
                WHERE ref_id = ? AND site = ?

                UNION ALL

                SELECT c.id
                FROM clients c
                INNER JOIN tree t ON c.ref_id = t.id
            )
            SELECT COUNT(*) AS total
            FROM tree
        ", [$parentId, $site]);

        return $result[0]->total ?? 0;
    }

    public function getProfile(Request $request)
    {
        $id = $request->id;
        $this->selectedClient = Client::findOrFail($id);
        $this->leftCount = $this->getLegCount($id, 0);
        $this->rightCount = $this->getLegCount($id, 1);


        return response()->json([
            'success' => true,
            'message' => 'success',
            'user' => [
                'phone' => $this->selectedClient->phone,
                'email' => $this->selectedClient->email,
                'address' => $this->selectedClient->address,

                'aLink' => 'https://globexacapital.com/?ref='.$this->selectedClient->left_side,
                'bLink' => 'https://globexacapital.com/?ref='.$this->selectedClient->left_side,

                'aCount' => $this->leftCount,
                'bCount' => $this->rightCount,
            ]
        ]);
    }

 

public function updateProfile(Request $request)
{
    $request->validate([
        'id' => 'required',
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|email',
        'address' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
    ]);

    $client = Client::findOrFail($request->id);

    $client->name = $request->name;
    $client->phone = $request->phone;
    $client->email = $request->email;
    $client->address = $request->address;

    if ($request->hasFile('photo')) {

        $file = $request->file('photo');

        // delete old image if exists
        if ($client->photo && \Storage::disk('public')->exists($client->photo)) {
            \Storage::disk('public')->delete($client->photo);
        }

        $filename = time() . '_' . uniqid() . '.jpg';

        // read image using Intervention
        $img = \Intervention\Image\Facades\Image::make($file->getRealPath());

        // resize to max width 500px (keep ratio)
        $img->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // compress + encode JPG (80% quality)
        $imageData = (string) $img->encode('jpg', 80);

        // save to storage/app/public/clients
        $path = 'clients/' . $filename;

        \Storage::disk('public')->put($path, $imageData);

        $client->photo = $path;
    }

    $client->save();

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully',
        'user' => $client
    ]);
}

  
}
