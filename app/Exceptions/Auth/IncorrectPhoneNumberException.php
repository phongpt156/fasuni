<?php

namespace App\Exceptions\Auth;

use Exception;

class IncorrectPhoneNumberException extends Exception
{
    protected $message = 'Số điện thoại không tồn tại';
    protected $code = 401;
}
