<?php

namespace Razikov\AtesBilling\Feature\Payday;

use Razikov\AtesBilling\Entity\AccountOperationLog;
use Razikov\AtesBilling\Model\AccountOperationType;
use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\ChronosRepository;
use Razikov\AtesBilling\Service\StorageManager;
use Razikov\AtesBilling\Feature\SendPaymentEmail\Command as SendPaymentEmailCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class Handler
{
    private AccountRepository $accountRepository;
    private StorageManager $storageManager;
    private ChronosRepository $chronosRepository;
    private MessageBusInterface $dispatcher;

    public function __construct(
        AccountRepository $accountRepository,
        StorageManager $storageManager,
        ChronosRepository $chronosRepository,
        MessageBusInterface $dispatcher
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronosRepository = $chronosRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Command $command)
    {
        $accounts = $this->accountRepository->getAllProfitableAccount();

        $chronos = $this->chronosRepository->getOrCreateOnlyOneAllowed();
        $day = $chronos->getDay();

        $events = [];
        foreach ($accounts as $account) {
            $amount = $account->payday();
            if ($amount > 0) {
                $log = new AccountOperationLog(
                    $account->getUserId(),
                    null,
                    AccountOperationType::createPayday(),
                    $amount,
                    "payment per day #{$day}",
                    $day
                );

                $this->storageManager->persist($account);
                $this->storageManager->persist($log);

                $events[] = new SendPaymentEmailCommand(
                    $account->getEmail(),
                    $amount,
                    $day
                );
            }
        }

        $chronos->nextDay();

        $this->storageManager->persist($chronos);
        $this->storageManager->flush();

        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
