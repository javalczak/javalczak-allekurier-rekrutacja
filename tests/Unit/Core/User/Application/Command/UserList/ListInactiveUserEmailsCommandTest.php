<?php

namespace App\Tests\Unit\Core\User\Application\Command\UserList;

use App\Common\Mailer\MailerInterface;
use App\Core\User\Application\EventListener\UserCreatedListener;
use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\User;
use App\Core\User\UserInterface\Cli\ListAllInactiveUserEmailsCommand;
use App\Core\User\Application\Query\UserList\GetAllInactiveUserEmailsQuery;
use App\Common\Bus\QueryBusInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ListInactiveUserEmailsCommandTest extends TestCase
{
    private QueryBusInterface|MockObject $queryBus;

    private ListAllInactiveUserEmailsCommand $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = $this->createMock(QueryBusInterface::class);

        $this->command = new ListAllInactiveUserEmailsCommand($this->queryBus);
    }

    public function test_execute_outputs_all_inactive_emails(): void
    {
        $emails = [
            'inactive1@example.com',
            'inactive2@example.com',
        ];

        $this->queryBus->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(GetAllInactiveUserEmailsQuery::class))
            ->willReturn($emails);

        $commandTester = new CommandTester($this->command);
        $exitCode = $commandTester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $commandTester->getDisplay();

        foreach ($emails as $email) {
            self::assertStringContainsString($email, $output);
        }
    }

    public function test_execute_no_inactive_users(): void
    {
        $this->queryBus->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(GetAllInactiveUserEmailsQuery::class))
            ->willReturn([]);

        $commandTester = new CommandTester($this->command);
        $exitCode = $commandTester->execute([]);

        self::assertSame(0, $exitCode);
        $output = $commandTester->getDisplay();

        self::assertSame('', trim($output));
    }

    public function test_userCreatedListener_sendsEmail(): void
    {
        $email = 'test@example.com';
        $user = new User($email, false);

        $mailer = $this->createMock(MailerInterface::class);

        $mailer->expects(self::once())
            ->method('send')
            ->with(
                $email,
                'Rejestracja konta',
                'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h'
            );

        $listener = new UserCreatedListener($mailer);
        $event = new UserCreatedEvent($user);

        $listener->send($event);
    }
}
