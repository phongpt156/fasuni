<?php

namespace App\Exceptions\Auth;

use Exception;

class IncorrectEmailException extends Exception
{
    protected $message = 'Your email is not correct';
    protected $code = 401;
}
