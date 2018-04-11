<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function productGroups()
    {
        return $this->hasMany(Product::class, 'master_product_id', 'id');
    }

    public function featureValues()
    {
        return $this->belongsToMany(FeatureValue::class, 'product_feature_values', 'product_id', 'feature_value_id');
    }
}
