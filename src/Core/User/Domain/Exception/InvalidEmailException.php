<?php

namespace App\Core\User\Domain\Exception;

use DomainException;

class InvalidEmailException extends DomainException
{
    protected $message = 'Podany adres e-mail jest nieprawidłowy.';
}