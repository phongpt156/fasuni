<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $fillable = ['code', 'amount', 'invoice_id', 'payment_id', 'kiotviet_id'];
}
