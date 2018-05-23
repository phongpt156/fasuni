<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class ProductLiker extends Model
{
    use HasCompositePrimaryKey;

    protected $primaryKey = ['product_id', 'user_id'];
    protected $fillable = ['product_id', 'user_id'];
    public $incrementing = false;
}
