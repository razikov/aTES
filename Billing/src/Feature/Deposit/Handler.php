<?php

namespace Razikov\AtesBilling\Feature\Deposit;

use Razikov\AtesBilling\Entity\Chronos;
use Razikov\AtesBilling\Entity\AccountOperationLog;
use Razikov\AtesBilling\Model\AccountOperationType;
use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\ChronosRepository;
use Razikov\AtesBilling\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    private AccountRepository $accountRepository;
    private StorageManager $storageManager;
    private ChronosRepository $chronosRepository;

    public function __construct(
        AccountRepository $accountRepository,
        StorageManager $storageManager,
        ChronosRepository $chronosRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronosRepository = $chronosRepository;
    }

    /**
     * Срабатывает, когда выполняется задача. Читает событие taskCompleted
     */
    public function __invoke(Command $command)
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
