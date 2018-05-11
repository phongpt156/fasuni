<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class OrderDetail extends Model
{
    use HasCompositePrimaryKey;

    protected $primaryKey = ['product_id', 'order_id'];
    protected $fillable = ['product_id', 'order_id', 'quantity', 'price', 'discount_price'];
    public $incrementing = false;    
}
