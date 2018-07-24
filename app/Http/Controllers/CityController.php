<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DAL\CityDAL;
use App\Models\City;
use App\Models\District;

class CityController extends Controller
{
    public function index()
    {
        $cityDAL = new CityDAL();

        $cities = $cityDAL->getCities();

        return response()->json($cities, 200);
    }

    public function getDistricts($id)
    {
        $districts = District::whereCityId($id)->get();

        return response()->json($districts, 200);
    }
}