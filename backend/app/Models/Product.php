<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'discount_price', 'quantity', 'about', 'is_active', 'sku_id', 'gender', 'click_count', 'category_id', 'master_product_id'];

    public function productGroups()
    {
        return $this->hasMany(Product::class, 'master_product_id', 'id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_id', 'attribute_value_id');
    }
}
