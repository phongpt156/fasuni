<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'code', 'phone_number', 'email', 'address', 'kiotviet_id'];
}
