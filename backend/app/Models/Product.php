<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'base_price', 'discount_price', 'quantity', 'about', 'weight', 'is_active', 'code', 'gender', 'click_count', 'category_id', 'master_product_id', 'kiotviet_id', 'branch_id'];
    public $appends = ['quantity'];

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

    public function getQuantityAttribute()
    {
        return $this->inventories()->sum('quantity');
    }
}
