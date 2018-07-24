<?php

namespace App\PackageWrapper;

use Carbon\Carbon;

class DateTime extends Carbon
{
    public static function now($timestamp = 'UTC')
    {
        return parent::now($timestamp);
    }
};
