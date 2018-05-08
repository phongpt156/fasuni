<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Category;
use App\Http\Services\KiotViet\KiotVietService;
use App\PackageWrapper\DateTime;

class KiotVietController extends Controller
{
    public function sync()
    {
        $kiotVietService = new KiotVietService;
        $categories = $kiotVietService->categoryService->getAll();

        $categoryController = new CategoryController;
        $categoryController->saveHierarchyCategories($categories);

        return $categories;
    }
}
