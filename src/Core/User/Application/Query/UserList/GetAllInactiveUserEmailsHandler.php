<?php

namespace App\Core\User\Application\Query\UserList;

use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllInactiveUserEmailsHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetAllInactiveUserEmailsQuery $query): array
    {
        return $this->userRepository->getAllInactiveUserEmails();
    }
}