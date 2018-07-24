<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['username', 'name', 'address', 'phone_number', 'email', 'birthday', 'is_active', 'kiotviet_id'];
}
