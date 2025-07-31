<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\User;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    /**
     * @return string[] — email list of inactive users
     */
    public function getAllInactiveUserEmails(): array;

    /**
     * Saves a user (adds or updates).
     */
    public function save(User $user): void;

    /**
     * Commits changes to the database.
     */
    public function flush(): void;
}
