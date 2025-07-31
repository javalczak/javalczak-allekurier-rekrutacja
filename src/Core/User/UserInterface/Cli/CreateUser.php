<?php

namespace App\Core\User\UserInterface\Cli;

use App\Core\User\Application\DTO\CreateUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Tworzenie nowego użytkownika ze statusem: nieaktywny'
)]
class CreateUser extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new CreateUserCommand($input->getArgument('email')));
        $output->writeln('Użytkownik został utworzony ze statusem nieaktywny.');

        return Command::SUCCESS;
    }
}