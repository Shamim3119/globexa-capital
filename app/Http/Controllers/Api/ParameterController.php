<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        $query = Parameter::query();

        if ($request->filled('tag')) {
            $query->where('tag', $request->tag);
        }

        $parameters = $query
            ->where('inactive', 0)
            ->orderBy('id')
            ->get([
                'id',
                'name',
                'tag',
            ]);

        return response()->json([
            'success' => true,
            'data' => $parameters,
        ]);
    }
}