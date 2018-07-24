<?php

namespace App\Exceptions\Auth;

use Exception;

class ExistEmailException extends Exception
{
    protected $message = 'Email đã được sử dụng';
    protected $code = 500;
}
