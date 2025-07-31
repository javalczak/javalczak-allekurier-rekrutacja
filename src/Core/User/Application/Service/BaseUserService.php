<?php

namespace App\Core\User\Application\Service;

use App\Core\User\Domain\Exception\InvalidEmailException;

abstract class BaseUserService
{
    public function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException(sprintf('Email "%s" is not valid.', $email));
        }
    }
}


