<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class Inventory extends Model
{
    use HasCompositePrimaryKey;

    protected $primaryKey = ['product_id', 'branch_id'];
    protected $fillable = ['product_id', 'branch_id', 'sale_price', 'quantity'];
    public $incrementing = false;
}
