<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DAL\CityDAL;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cityDAL = new CityDAL();

        $cities = $cityDAL->getCities();

        return response()->json($cities, 200);
    }
}