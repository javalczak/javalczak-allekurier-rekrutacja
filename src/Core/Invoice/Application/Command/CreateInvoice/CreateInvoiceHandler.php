<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\User\Domain\Exception\UserInactiveException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateInvoiceHandler
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateInvoiceCommand $command): void
    {
        $userRepo = $this->userRepository->getByEmail($command->email);
        if (!$userRepo->isActive()) {
            throw new UserInactiveException();
        }

        $this->invoiceRepository->save(new Invoice(
            $userRepo,
            $command->amount
        ));

        $this->invoiceRepository->flush();
    }
}
