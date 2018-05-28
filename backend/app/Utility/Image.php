<?php

namespace App\Utility;

use Tinify;

class Image
{
    private const API_KEY = 'HKMS4B7gBoTfa4ASZlylTuDRs1SjX5XN';

    public static function compress($from, $to)
    {
        Tinify\setKey(self::API_KEY);
        Tinify\fromFile($from)->toFile($to);
    }
}
