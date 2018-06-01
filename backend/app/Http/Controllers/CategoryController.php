<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children.children')->whereNull('parent_id')->get();

        return response()->json($categories, 200);
    }

    public function getHierachyCategory($slug)
    {
        $category = Category::with('parent', 'parent.parent')->whereSlug($slug)->first();

        return response()->json($category, 200);
    }
}
