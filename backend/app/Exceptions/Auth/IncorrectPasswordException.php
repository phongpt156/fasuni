<?php

namespace App\Exceptions\Auth;

use Exception;

class IncorrectPasswordException extends Exception
{
    protected $message = 'Mật khẩu không đúng';
    protected $code = 500;
}
