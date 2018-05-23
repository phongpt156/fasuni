<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['code', 'total_price', 'discount_price', 'source', 'status_id', 'customer_id', 'employee_id', 'branch_id', 'kiotviet_id'];
}
