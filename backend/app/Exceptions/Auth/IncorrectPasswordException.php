<?php

namespace App\Exceptions\Auth;

use Exception;

class IncorrectPasswordException extends Exception
{
    protected $message = 'Your password is not correct';
    protected $code = 500;
}
