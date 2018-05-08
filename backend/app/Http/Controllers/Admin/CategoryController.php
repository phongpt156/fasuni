<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
    }
}
