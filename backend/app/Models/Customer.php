<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['code', 'name', 'first_name', 'last_name', 'birthday', 'phone_number', 'address', 'email', 'gender', 'living_city_id', 'district_id', 'user_id', 'kiotviet_id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
