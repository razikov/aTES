<?php

namespace Razikov\AtesBilling\Feature\Charge;

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
        $accountRepository,
        $storageManager,
        $chronos
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronos = $chronos;
    }

    /**
     * Срабатывает, когда назначается исполнитель. Читает событие taskAssigned
     */
    public function handle(Command $command)
    {
        $account = $this->accountRepository->getById($command->getUserId());
        $day = $this->chronos->getDay();

        $amount = rand(10, 20) * -1;

        $account->charge($amount);

        $log = new AccountOperationLog(
            $command->getUserId(),
            AccountOperationType::createCharge(),
            $amount,
            "Task #[{$command->getTaskId()}] assigned",
            $day
        );

        $this->storageManager->persist($account);
        $this->storageManager->persist($log);
        $this->storageManager->flush();
    }
}
