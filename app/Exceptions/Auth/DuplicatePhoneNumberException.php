<?php

namespace App\Exceptions\Auth;

use Exception;

class DuplicatePhoneNumberException extends Exception
{
    protected $message = 'Số điện thoại đã được đăng ký';
    protected $code = 500;
}
