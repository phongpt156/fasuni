<?php

namespace App\DAL;
use App\Models\City;

class CityDAL
{
    public function getCities()
    {
        return City::all();
    }
}
