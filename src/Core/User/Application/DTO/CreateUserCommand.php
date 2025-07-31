<?php

namespace App\Core\User\Application\DTO;

class CreateUserCommand
{
    public function __construct(
        public readonly string $email
    ) {}
}