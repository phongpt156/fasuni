<?php

namespace App\PackageWrapper;

use Dirape\Token\Token as DirapeToken;

class Token extends DirapeToken
{
    public function getToken($tableName, $tableColumn, $time = 60)
    {
        return $this->Unique($tableName, $tableColumn, $time);
    }
};
