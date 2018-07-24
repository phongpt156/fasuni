<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['amount', 'code', 'order_id', 'payment_id', 'kiotviet_id'];
}
