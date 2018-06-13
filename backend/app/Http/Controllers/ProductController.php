<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        $appends = [
            'category',
            'images',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories'
        ];

        $product = new Product;

        $products = Product::with($appends)
            ->whereNull('master_product_id')
            ->whereIsActive(true)
            ->whereIsDisplay(true);

        switch ($request->type) {
            case 'newest': {
                $products = $products->latest();
                break;
            }
            case 'best-seller': {
                $products = $products->latest('buy_count');
            }
            case 'most-like': {
                $products = $products->latest('like_count');
            }
        }

        $products = $products->paginate(12);
        $products->appends($request->except('page'))->links();

        $products->each(function ($product) use ($user) {
            $product->append('size', 'color');
            if ($user) {
                $product->setUserId($user->id);
                $product->append('liked');
            }
            $product->subProducts->each(function ($subProduct) use ($user) {
                $subProduct->append('size', 'color');
                if ($user) {
                    $subProduct->setUserId($user->id);
                    $subProduct->append('liked');
                }
            });
        });

        return response()->json($products, 200);
    }

    public function show($id)
    {
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        $product = Product::with(
                'category',
                'images',
                'inventories',
                'subProducts.images',
                'subProducts.category',
                'subProducts.inventories'
            )
            ->whereId($id)
            ->whereNull('master_product_id')
            ->whereIsActive(true)
            ->whereIsDisplay(true)
            ->first();

        if (!is_null($product)) {
            $product = $product->append('size', 'color');

            if ($user) {
                $product->setUserId($user->id);
                $product->append('liked');
            }
    
            $product->subProducts->each(function ($subProduct) use ($user) {
                $subProduct->append('size', 'color');
                if ($user) {
                    $subProduct->setUserId($user->id);
                    $subProduct->append('liked');
                }
            });
        }

        return response()->json($product, 200);
    }

    public function getByCategory($category, Request $request)
    {
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        $appends = [
            'category',
            'images',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories'
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

        if ($request->has('colors')) {
            $colors = explode(',', $request->colors);

            $products = $products->where(function ($query) use ($colors) {
                $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                    $query->whereIn('attribute_value_id', $colors);
                })
                ->orWhereHas('subProducts', function ($query) use ($colors) {
                    $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                        $query->whereIn('attribute_value_id', $colors);
                    });
                });
            });
        }

        if ($request->has('sizes')) {
            $sizes = explode(',', $request->sizes);

            $products = $products->where(function ($query) use ($sizes) {
                $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                    $query->whereIn('attribute_value_id', $sizes);
                })
                ->orWhereHas('subProducts', function ($query) use ($sizes) {
                    $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                        $query->whereIn('attribute_value_id', $sizes);
                    });
                });
            });
        }

        if ($request->has('type')) {
            $type = $request->type;
        } else {
            $type = 'newest';
        }

        switch ($type) {
            case 'newest': {
                $products = $products->latest();
                break;
            }
            case 'best-seller': {
                $products = $products->latest('buy_count');
                break;
            }
            case 'most-like': {
                $products = $products->latest('like_count');
                break;
            }
            default: {
                $products = $products->latest();
                break;
            }
        }

        $products = $products->paginate(12);
        $products->appends($request->except('page'))->links();

        $products->each(function ($product) use ($user) {
            $product->append('size', 'color');
            if ($user) {
                $product->setUserId($user->id);
                $product->append('liked');
            }
            $product->subProducts->each(function ($subProduct) use ($user) {
                $subProduct->append('size', 'color');
                if ($user) {
                    $subProduct->setUserId($user->id);
                    $subProduct->append('liked');
                }
            });
        });

        return response()->json($products, 200);
    }

    public function searchByName($name, Request $request)
    {
        $name = urldecode($name);
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        $appends = [
            'category',
            'images',
            'inventories',
            'subProducts.images',
            'subProducts.category',
            'subProducts.inventories'
        ];

        $product = new Product;

        $products = Product::with($appends)
            ->whereNull('master_product_id')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->whereIsActive(true)
            ->whereIsDisplay(true);

        if ($request->has('colors')) {
            $colors = explode(',', $request->colors);

            $products = $products->where(function ($query) use ($colors) {
                $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                    $query->whereIn('attribute_value_id', $colors);
                })
                ->orWhereHas('subProducts', function ($query) use ($colors) {
                    $query->whereHas('productAttributeValues', function ($query) use ($colors) {
                        $query->whereIn('attribute_value_id', $colors);
                    });
                });
            });
        }

        if ($request->has('sizes')) {
            $sizes = explode(',', $request->sizes);

            $products = $products->where(function ($query) use ($sizes) {
                $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                    $query->whereIn('attribute_value_id', $sizes);
                })
                ->orWhereHas('subProducts', function ($query) use ($sizes) {
                    $query->whereHas('productAttributeValues', function ($query) use ($sizes) {
                        $query->whereIn('attribute_value_id', $sizes);
                    });
                });
            });
        }

        if ($request->has('type')) {
            $type = $request->type;
        } else {
            $type = 'newest';
        }

        switch ($type) {
            case 'newest': {
                $products = $products->latest();
                break;
            }
            case 'best-seller': {
                $products = $products->latest('buy_count');
                break;
            }
            case 'most-like': {
                $products = $products->latest('like_count');
                break;
            }
            default: {
                $products = $products->latest();
                break;
            }
        }

        $products = $products->paginate(12);
        $products->appends($request->except('page'))->links();

        $products->each(function ($product) use ($user) {
            $product->append('size', 'color');
            if ($user) {
                $product->setUserId($user->id);
                $product->append('liked');
            }
            $product->subProducts->each(function ($subProduct) use ($user) {
                $subProduct->append('size', 'color');
                if ($user) {
                    $subProduct->setUserId($user->id);
                    $subProduct->append('liked');
                }
            });
        });

        return response()->json($products, 200);
    }

    public function getRelevant($id, Request $request)
    {
        $products = [];

        if ($request->has('category')) {
            $category = $request->category;

            $products = Product::with('images')
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

            $products->each(function ($product) {
                $product->append('size', 'color');
            });
        }

        return response()->json($products, 200);
    }
}
