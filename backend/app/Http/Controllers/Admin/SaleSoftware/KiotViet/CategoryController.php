<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Services\KiotViet\KiotVietService;

class CategoryController extends Controller
{
    private $kiotVietService;

    public function __construct(KiotVietService $kiotVietService)
    {
        $this->kiotVietService = $kiotVietService;
    }

    public function saveHierarchyCategories(Array $categories = [])
    {
        foreach ($categories as $category) {
            $this->saveCategory($category);
        }
    }

    public function saveCategory(Object $category)
    {
        $parentId = $this->getParentCategoryId($category);

        try {
            $savedCategory = Category::updateOrCreate(
                ['kiotviet_id' => $category->categoryId],
                ['name' => $category->categoryName, 'parent_id' => $parentId, 'slug' => str_slug($category->categoryName)]
            );
        } catch (QueryException $e) {
            \Log::debug('Cannot save category: ' . $e->getMessage());
            throw $e;
        }

        if (isset($category->hasChild) && $category->hasChild) {
            $this->saveHierarchyCategories($category->children);
        }

        return $savedCategory;
    }

    public function getParentCategoryId(Object $category)
    {
        $id = null;

        if (isset($category->parentId)) {
            $parentCategory = Category::whereKiotvietId($category->parentId)->first();

            if (!$parentCategory) {
                $parentCategory = $this->kiotVietService->categoryService->getOne($category->parentId);
                $parentCategory = $this->saveCategory($parentCategory);
            }

            $id = $parentCategory->id;
        }

        return $id;
    }
}
