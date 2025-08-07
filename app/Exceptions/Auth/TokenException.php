<?php

namespace App\Exceptions\Auth;

use Exception;

class TokenException extends Exception
{
    protected $message = 'Token related error occurred';
    protected $code = 401;
}
