<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $appends = [
            'category',
            'images',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories',
            'color',
            'size'
        ];

        $product = new Product;

        $products = Product::with($appends)
            ->whereNull('master_product_id')
            ->whereIsActive(true)
            ->whereIsDisplay(true);

        if ($request->has('type')) {
            $type = $request->type;
        } else {
            $type = 'newest';
        }

        $products->when($type === 'newest', function ($query) {
            return $query->latest();
        });
        $products->when($type === 'best-seller', function ($query) {
            return $query->latest('buy_count');
        });
        $products->when($type === 'most-like', function ($query) {
            return $query->latest('like_count');
        });

        $products = $products->paginate(12);

        $products->appends($request->except('page'))->links();

        return response()->json($products, 200);
    }

    public function show($id)
    {
        $product = Product::with(
                'category',
                'images',
                'inventories',
                'color',
                'size',
                'subProducts.images',
                'subProducts.category',
                'subProducts.inventories',
                'subProducts.color',
                'subProducts.size'
            )
            ->whereId($id)
            ->whereNull('master_product_id')
            ->whereIsActive(true)
            ->whereIsDisplay(true)
            ->first();

        return response()->json($product, 200);
    }

    public function getByCategory($category, Request $request)
    {
        $appends = [
            'category',
            'images',
            'inventories',
            'color',
            'size',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories',
            'subProducts.color',
            'subProducts.size'
        ];

        $product = new Product;

        $products = Product::with($appends)
            ->whereNull('master_product_id')
            ->where(function ($query) use ($category) {
                $query->whereHas('category', function ($query) use ($category) {
                    $query->whereId($category);
                })
                ->orWhereHas('category.parent', function ($query) use ($category) {
                    $query->whereId($category);
                })
                ->orWhereHas('category.parent.parent', function ($query) use ($category) {
                    $query->whereId($category);
                });
            })
            ->whereIsActive(true)
            ->whereIsDisplay(true);

        $products->when($request->has('colors'), function ($query) use ($request) {
            $colors = explode(',', $request->colors);

            return $query->where(function ($query) use ($colors) {
                $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                    $query->whereIn('attribute_value_id', $colors);
                })
                ->orWhereHas('subProducts', function ($query) use ($colors) {
                    $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                        $query->whereIn('attribute_value_id', $colors);
                    });
                });
            });
        });

        $products->when($request->has('sizes'), function ($query) use ($request) {
            $sizes = explode(',', $request->sizes);

            return $query->where(function ($query) use ($sizes) {
                $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                    $query->whereIn('attribute_value_id', $sizes);
                })
                ->orWhereHas('subProducts', function ($query) use ($sizes) {
                    $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                        $query->whereIn('attribute_value_id', $sizes);
                    });
                });
            });
        });

        if ($request->has('type')) {
            $type = $request->type;
        } else {
            $type = 'newest';
        }

        $products->when($type === 'newest', function ($query) {
            return $query->latest();
        });
        $products->when($type === 'best-seller', function ($query) {
            return $query->latest('buy_count');
        });
        $products->when($type === 'most-like', function ($query) {
            return $query->latest('like_count');
        });

        $products = $products->paginate(12);
        $products->appends($request->except('page'))->links();

        return response()->json($products, 200);
    }

    public function searchByName($name, Request $request)
    {
        $name = urldecode($name);
        $appends = [
            'category',
            'images',
            'inventories',
            'color',
            'size',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories',
            'subProducts.color',
            'subProducts.size'
        ];

        $product = new Product;

        $products = Product::with($appends)
            ->whereNull('master_product_id')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->whereIsActive(true)
            ->whereIsDisplay(true);

        $products->when($request->has('colors'), function ($query) use ($request) {
            $colors = explode(',', $request->colors);

            return $query->where(function ($query) use ($colors) {
                $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                    $query->whereIn('attribute_value_id', $colors);
                })
                ->orWhereHas('subProducts', function ($query) use ($colors) {
                    $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                        $query->whereIn('attribute_value_id', $colors);
                    });
                });
            });
        });

        $products->when($request->has('sizes'), function ($query) use ($request) {
            $sizes = explode(',', $request->sizes);

            return $query->where(function ($query) use ($sizes) {
                $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                    $query->whereIn('attribute_value_id', $sizes);
                })
                ->orWhereHas('subProducts', function ($query) use ($sizes) {
                    $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                        $query->whereIn('attribute_value_id', $sizes);
                    });
                });
            });
        });

        if ($request->has('type')) {
            $type = $request->type;
        } else {
            $type = 'newest';
        }

        $products->when($type === 'newest', function ($query) {
            return $query->latest();
        });
        $products->when($type === 'best-seller', function ($query) {
            return $query->latest('buy_count');
        });
        $products->when($type === 'most-like', function ($query) {
            return $query->latest('like_count');
        });

        $products = $products->paginate(12);
        $products->appends($request->except('page'))->links();

        return response()->json($products, 200);
    }

    public function getRelevant($id, Request $request)
    {
        $products = [];

        if ($request->has('category')) {
            $category = $request->category;

            $products = Product::with('images', 'size', 'color', 'subProducts.images', 'subProducts.color')
            ->whereNull('master_product_id')
            ->where(function ($query) use ($category) {
                $query->whereHas('category', function ($query) use ($category) {
                    $query->whereId($category);
                })
                ->orWhereHas('category.parent', function ($query) use ($category) {
                    $query->whereId($category);
                })
                ->orWhereHas('category.parent.parent', function ($query) use ($category) {
                    $query->whereId($category);
                });
            })
            ->where('id', '!=', $id)
            ->whereIsActive(true)
            ->whereIsDisplay(true)
            ->paginate(16);

            $products->appends($request->except('page'))->links();
        }

        return response()->json($products, 200);
    }
}
