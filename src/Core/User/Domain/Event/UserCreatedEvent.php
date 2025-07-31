<?php

namespace App\Core\User\Domain\Event;

use App\Core\User\Domain\User;

class UserCreatedEvent
{
    public function __construct(private readonly User $user)
    {}

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }
}
