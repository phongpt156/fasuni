<?php

namespace App\Exceptions\Auth;

use Exception;

class IncorrectEmailException extends Exception
{
    protected $message = 'Email không tồn tại';
    protected $code = 401;
}
