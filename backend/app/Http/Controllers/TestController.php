<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class TestController extends Controller
{
    public function index()
    {
        return Product::whereHas('productGroups', function ($query) {
            $query->whereRaw('id != master_product_id');
        })
        ->with(['productGroups' => function ($query) {
            $query->whereRaw('id != master_product_id');
        }, 'featureValues', 'productGroups.featureValues'])
        ->get();
    }
}
