<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public function images()
    {
        return $this->hasMany(CollectionImage::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_collections');
    }
}
