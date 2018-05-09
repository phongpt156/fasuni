<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'first_name', 'last_name', 'phone_number', 'address', 'email', 'gender', 'code', 'living_city_id', 'user_id', 'kiotviet_id'];
}
