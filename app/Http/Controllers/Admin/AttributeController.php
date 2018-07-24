<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();

        return response()->json($attributes, 200);
    }
}
