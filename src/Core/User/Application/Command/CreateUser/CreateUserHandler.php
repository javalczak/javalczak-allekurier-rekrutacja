<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\User\Application\Service\UserService;
use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\Exception\UserNotFoundException;
use DomainException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Core\User\Application\DTO\CreateUserCommand;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly UserService $userService
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        try {
            $this->userService->validateEmail($command->email);
            $this->userRepository->getByEmail($command->email);
            throw new DomainException('Użytkownik o podanym emailu już istnieje');
        } catch (UserNotFoundException $e) {
            $user = new User($command->email, false);
            $this->userRepository->save($user);
            $this->userRepository->flush();
        }

        $this->eventDispatcher->dispatch(new UserCreatedEvent($user));
    }
}