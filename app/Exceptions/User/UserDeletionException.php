<?php

namespace App\Exceptions\User;

use Exception;

class UserDeletionException extends Exception
{
    protected $message = 'User deletion failed';
    protected $code = 403;
}