<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $fillable = ['code', 'invoice_id', 'payment_id', 'amount', 'kiotviet_id'];
}
