<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['original', 'thumbnail', 'medium', 'product_id'];
}
