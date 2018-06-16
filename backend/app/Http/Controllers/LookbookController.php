<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lookbook;
use Illuminate\Support\Facades\DB;
use App\PackageWrapper\DateTime;

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

    public function getLookbooksOfMonth(int $gender, int $year, int $month)
    {
        $startDate = DateTime::create($year, $month)->firstOfMonth();
        $endDate = DateTime::create($year, $month)->lastOfMonth();

        $lookbooks = Lookbook::with([
                'products.size',
                'products.color'
            ])
            ->where(function ($query) {
                return $query->whereHas('products.masterProduct', function ($query) {
                    return $query->whereIsActive(1)->whereIsDisplay(1);
                })
                ->orWhereHas('products', function ($query) {
                    return $query->whereNull('master_product_id');
                });
            })
            ->whereGender($gender)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return response()->json($lookbooks);
    }
}
