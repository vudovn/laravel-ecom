<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;

class ApiController extends Controller
{
    public function getWards(Request $request)
    {
        $province = Province::with('wards')->find($request->province_id);
        $wards = $province->wards;
        return response()->json([
            'status' => true,
            'data' => $wards,
        ], 200);
    }
}
