<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;

class Product extends Model
{
    protected $fillable = ['name', 'sale_price', 'discount_price', 'weight', 'description', 'slug', 'is_active', 'code', 'gender', 'click_count', 'like_count', 'buy_count', 'category_id', 'master_product_id', 'kiotviet_id'];
    protected $appends = ['total_quantity'];
    private $userId;

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

    public function productLiker()
    {
        return $this->hasMany(ProductLiker::class);
    }

    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function getLikedAttribute()
    {
        return $this->productLiker()->whereUserId($this->userId)->exists();
    }

    public function getTotalQuantityAttribute()
    {
        return (int)$this->inventories()->sum('quantity');
    }

    public function getSizeAttribute()
    {
        return $this->attributeValues()->whereHas('attribute', function ($query) {
            $query->where('name', 'Size');
        })->first();
    }

    public function getColorAttribute()
    {
        return $this->attributeValues()->whereHas('attribute', function ($query) {
            $query->where('name', 'Màu sắc');
        })->first();
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }
}
