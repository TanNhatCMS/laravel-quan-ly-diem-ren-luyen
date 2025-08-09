<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';
    protected $code = 404;
}
