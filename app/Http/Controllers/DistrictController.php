<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ward;

class DistrictController extends Controller
{
    public function getWards($id)
    {
        $wards = Ward::whereDistrictId($id)->get();

        return response()->json($wards, 200);
    }
}