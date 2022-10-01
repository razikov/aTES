<?php

namespace Razikov\AtesBilling\Feature\Deposit;

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

    public function __construct(
        AccountRepository $accountRepository,
        StorageManager $storageManager,
        Chronos $chronos
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronos = $chronos;
    }

    /**
     * Срабатывает, когда выполняется задача. Читает событие taskCompleted
     */
    public function handle($command)
    {
        $account = $this->accountRepository->getById($command->getUserId());
        $day = $this->chronos->getDay();

        $amount = rand(20, 40);

        $account->deposit($amount);

        $log = new AccountOperationLog(
            $command->getUserId(),
            AccountOperationType::createDeposit(),
            $amount,
            "Task #[{$command->getTaskId()}] completed",
            $day
        );

        $this->storageManager->persist($account);
        $this->storageManager->persist($log);
        $this->storageManager->flush();
    }
}
