<?php

namespace Razikov\AtesBilling\Feature\Payday;

use Razikov\AtesBilling\Model\AccountOperationLog;
use Razikov\AtesBilling\Model\AccountOperationType;
use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Service\Chronos;
use Razikov\AtesBilling\Service\StorageManager;

class Handler
{
    private AccountRepository $accountRepository;
    private StorageManager $storageManager;
    private Chronos $chronos;
    private $dispatcher;

    public function __construct(
        AccountRepository $accountRepository,
        StorageManager $storageManager,
        Chronos $chronos,
        $dispatcher
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronos = $chronos;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Срабатывает, когда заканчивается день. Читает событие dayEnded
     */
    public function handle(Command $command)
    {
        $account = $this->accountRepository->getById($command->getUserId());
        $day = $this->chronos->getDay();

        $amount = $account->payday();

        if ($amount > 0) {
            $log = new AccountOperationLog(
                $command->getUserId(),
                AccountOperationType::createPayday(),
                $amount,
                "payment per day #{$day}",
                $day
            );

            $this->storageManager->persist($account);
            $this->storageManager->persist($log);
            $this->storageManager->flush();
            $this->chronos->nextDay();

            $this->dispatcher->dispatch(new PaymentPerDayEvent());
        }
    }
}
