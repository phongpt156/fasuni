<?php

namespace App\Utility;

use Intervention\Image\ImageManager as Image;
use Illuminate\Support\Facades\File;

class FileUtility
{
    public static function getFormatFileName($file)
    {
        return str_replace('#', '.', $file->getClientOriginalName());
    }
}
