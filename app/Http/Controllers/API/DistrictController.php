<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;

class DistrictController extends Controller
{
    public function provinces()
    {
        $provinces = Province::groupBy('province_code')
            ->orderBy('province','ASC')
            ->get();
        return response()->json($provinces);
    }
    public function amphoes($province_code)
    {
        $amphoes = Province::where('province_code', $province_code)
            ->groupBy('amphoe_code')
            ->orderBy('amphoe','ASC')
            ->get();
        return response()->json($amphoes);
    }
    public function districts($province_code, $amphoe_code)
    {
        $districts = Province::where('province_code', $province_code)
            ->where('amphoe_code', $amphoe_code)
            ->groupBy('district_code')
            ->orderBy('district','ASC')
            ->get();
        return response()->json($districts);
    }
    public function detail($province_code, $amphoe_code, $district_code)
    {
        $districts = Province::where('province_code', $province_code)
            ->where('amphoe_code', $amphoe_code)
            ->where('district_code', $district_code)
            ->get();
        return response()->json($districts);
    }
}
