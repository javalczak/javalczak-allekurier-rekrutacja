<?php

namespace App\Core\User\Domain\Exception;

use DomainException;

class UserInactiveException extends DomainException
{
    protected $message = 'User must be active to create an invoice.';
}
