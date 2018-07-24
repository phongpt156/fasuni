<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class InvoiceDetail extends Model
{
    use HasCompositePrimaryKey;

    protected $primaryKey = ['product_id', 'invoice_id'];
    protected $fillable = ['product_id', 'invoice_id', 'quantity', 'price', 'discount_price'];
    public $incrementing = false;
}
