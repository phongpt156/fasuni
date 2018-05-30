<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lookbook;
use Illuminate\Support\Facades\DB;

class LookbookController extends Controller
{
    public function index()
    {
    }

    public function getMaleMonthListSnapshot()
    {
        $monthly = DB::table('lookbooks')->select(DB::raw('DISTINCT YEAR(created_at) year, MONTH(created_at) month'))->where('gender', 1)->paginate(5);

        return response()->json($monthly, 200);
    }

    public function getFemaleMonthListSnapshot()
    {
        $monthly = DB::table('lookbooks')->select(DB::raw('DISTINCT YEAR(created_at) year, MONTH(created_at) month'))->where('gender', 2)->paginate(5);

        return response()->json($monthly, 200);
    }
}
