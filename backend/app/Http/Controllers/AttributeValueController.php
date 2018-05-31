<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;

class AttributeValueController extends Controller
{
    public function getColors()
    {
        $colors = AttributeValue::whereHas('attribute', function ($query) {
            $query->whereName('Màu sắc');
        })->get();

        return response()->json($colors, 200);
    }

    public function getSizes()
    {
        $sizes = AttributeValue::whereHas('attribute', function ($query) {
            $query->whereName('Size');
        })->get();

        return response()->json($sizes, 200);
    }
}
