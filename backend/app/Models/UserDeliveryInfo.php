<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeliveryInfo extends Model
{
    protected $fillable = ['receiver_name', 'receiver_phone', 'receiver_address', 'receiver_district_id', 'receiver_ward_id', 'user_id'];
}
