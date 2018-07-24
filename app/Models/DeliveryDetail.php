<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
    protected $fillable = ['receiver_name', 'receiver_phone', 'receiver_address', 'note', 'receiver_district_id', 'receiver_ward_id', 'order_id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'receiver_district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'receiver_ward_id');
    }
}
