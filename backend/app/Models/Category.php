<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['kiotviet_id', 'name', 'slug', 'parent_id'];
}
