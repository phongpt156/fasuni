<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookbook extends Model
{
    protected $fillable = ['name', 'original_image', 'large_image', 'medium_image', 'small_image', 'thumbnail', 'gender'];
}
