<?php

namespace Razikov\AtesBilling\Feature\Charge;

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

    public function __invoke(Command $command)
    {
        $account = $this->accountRepository->getById($command->getUserId());
        if (!$account) {
            throw new \DomainException("Account not found for {$command->getUserId()}");
        }
        $chronos = $this->chronosRepository->getOrCreateOnlyOneAllowed();
        $day = $chronos->getDay();

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
