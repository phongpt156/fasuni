<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Services\KiotViet\KiotVietService;

class KiotVietController extends Controller
{
    public function sync()
    {
        $kiotVietService = new KiotVietService;
        $categories = $kiotVietService->categoryService->getAll();
        $products = $kiotVietService->productService->getAll();

        $categoryController = new CategoryController;
        try {
            $categoryController->saveHierarchyCategories($categories);
        } catch (QueryException $e) {
            die('Cannot save category: ' . $e->getMessage());
        }

        // $productController = new ProductController;
        // try {
        //     $productController->saveProducts($products);
        // } catch (QueryException $e) {
        //     die('Cannot save product: ' . $e->getMessage());
        // }
    }
}
