<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet;

use App\Models\Category;

class CategoryController
{
    public function saveHierarchyCategories($categories)
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
                    ['name' => $category->categoryName, 'kiotviet_id' => $category->categoryId, 'parent_id' => $parentId]
                );

                if ($category->hasChild) {
                    $this->saveHierarchyCategories($category->children);
                }
            } catch (QueryException $e) {
                \Log::debug('Cannot save category: ' . $e->getMessage());
                die('Cannot save category: ' . $e->getMessage());
            }
        }
    }
}
