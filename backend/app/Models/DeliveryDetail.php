<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
    public function district()
    {
        return $this->belongsTo(District::class, 'receiver_district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'receiver_ward_id');
    }
}
