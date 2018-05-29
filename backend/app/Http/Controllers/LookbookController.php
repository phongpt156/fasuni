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

    public function getMonthlyArchive()
    {
        $monthly = DB::table('lookbooks')->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month'))->get();
    }
}
