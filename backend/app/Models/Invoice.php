<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['code', 'total_price', 'discount_price', 'customer_id', 'employee_id', 'branch_id', 'kiotviet_id'];
}
