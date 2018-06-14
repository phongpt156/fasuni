<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;

class Product extends Model
{
    protected $fillable = ['name', 'sale_price', 'discount_price', 'weight', 'description', 'slug', 'is_active', 'is_display', 'code', 'gender', 'click_count', 'like_count', 'buy_count', 'category_id', 'master_product_id', 'kiotviet_id'];
    protected $appends = ['total_quantity', 'liked'];

    public function subProducts()
    {
        return $this->hasMany(Product::class, 'master_product_id', 'id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_id', 'attribute_value_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function productLikers()
    {
        return $this->hasMany(ProductLiker::class);
    }

    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function getLikedAttribute()
    {
        $authController = new AuthController(new Auth);
        $user = $authController->user();

        if ($user) {
            $like = $this->productLikers->first(function ($productLiker) use ($user) {
                return $productLiker->user_id === $user->id;
            });

            if ($like) {
                return true;
            }
    
            return false;
        }

        return false;
    }

    public function getTotalQuantityAttribute()
    {
        return (int)$this->inventories()->sum('quantity');
    }

    public function size()
    {
        return $this->attributeValues()->whereHas('attribute', function ($query) {
            $query->whereName('Size');
        });
    }

    public function color()
    {
        return $this->attributeValues()->whereHas('attribute', function ($query) {
            $query->whereName('Màu sắc');
        });
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }
}
