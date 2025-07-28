<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\Query\UserList\GetAllInactiveUserEmailsQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:list-inactive-emails',
    description: 'Wyświetla adresy e-mail wszystkich nieaktywnych użytkowników'
)]
class ListAllInactiveUserEmailsCommand extends Command
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $emails = $this->queryBus->dispatch(new GetAllinactiveUserEmailsQuery());

        foreach ($emails as $email) {
            $output->writeln($email);
        }

        return Command::SUCCESS;
    }
}