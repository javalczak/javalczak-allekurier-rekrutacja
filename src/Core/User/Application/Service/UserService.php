<?php

namespace App\Core\User\Application\Service;

use App\Core\User\Domain\Repository\UserRepositoryInterface;

class UserService extends BaseUserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function checkUserNotExists(string $email): void
    {
        $user = $this->userRepository->getByEmail($email);

        if ($user === null) {
            throw new \DomainException('Użytkownik o podanym emailu już istnieje');
        }
    }
}