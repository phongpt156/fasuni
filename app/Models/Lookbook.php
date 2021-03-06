<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookbook extends Model
{
    protected $fillable = ['name', 'original_image', 'large_image', 'medium_image', 'small_image', 'thumbnail', 'gender'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_lookbooks');
    }

    public function productLookbooks()
    {
        return $this->hasMany(ProductLookbook::class);
    }
}
