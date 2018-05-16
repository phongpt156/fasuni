<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
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
            ->orderBy('created_at', 'desc')
            ->paginate(12);

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

    public function show($slug)
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
            ->whereSlug($slug)
            ->whereNull('master_product_id')
            ->whereIsActive(true)
            ->first()
            ->append('size', 'color');

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
        return response()->json($product, 200);
    }
}
