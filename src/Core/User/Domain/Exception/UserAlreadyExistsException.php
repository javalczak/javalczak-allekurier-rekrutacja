<?php

namespace App\Core\User\Domain\Exception;

class UserAlreadyExistsException extends UserException
{
    protected $message = 'User with this email already exists.';
}