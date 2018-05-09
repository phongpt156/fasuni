<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use Illuminate\Database\QueryException;
use App\Models\Category;

class CategoryController
{
    public static function saveHierarchyCategories(Array $categories = [])
    {
        foreach ($categories as $category) {
            try {
                $parentId = null;

                if (isset($category->parentId)) {
                    $parentCategory = Category::whereKiotvietId($category->parentId)->first();

                    if ($parentCategory) {
                        $parentId = $parentCategory->id;
                    }
                }
                Category::updateOrCreate(
                    ['kiotviet_id' => $category->categoryId],
                    ['name' => $category->categoryName, 'parent_id' => $parentId]
                );

                if ($category->hasChild) {
                    self::saveHierarchyCategories($category->children);
                }
            } catch (QueryException $e) {
                \Log::debug('Cannot save category: ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
