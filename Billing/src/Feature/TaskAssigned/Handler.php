<?php

namespace Razikov\AtesBilling\Feature\TaskAssigned;

use Razikov\AtesBilling\Entity\Chronos;
use Razikov\AtesBilling\Entity\AccountOperationLog;
use Razikov\AtesBilling\Model\AccountOperationType;
use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\ChronosRepository;
use Razikov\AtesBilling\Repository\TaskRepository;
use Razikov\AtesBilling\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    private AccountRepository $accountRepository;
    private StorageManager $storageManager;
    private ChronosRepository $chronosRepository;
    private TaskRepository $taskRepository;

    public function __construct(
        AccountRepository $accountRepository,
        StorageManager $storageManager,
        ChronosRepository $chronosRepository,
        TaskRepository $taskRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronosRepository = $chronosRepository;
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(Command $command)
    {
        $account = $this->accountRepository->getById($command->getUserId());
        if (!$account) {
            throw new \DomainException("Account not found");
        }

        $task = $this->taskRepository->getById($command->getTaskId());
        if (!$task) {
            throw new \DomainException("Task not found");
        }

        $chronos = $this->chronosRepository->getOrCreateOnlyOneAllowed();
        $day = $chronos->getDay();

        $amount = $task->getPenalty();
        $account->charge($amount);

        $log = new AccountOperationLog(
            $command->getUserId(),
            $task->getId(),
            AccountOperationType::createCharge(),
            $amount,
            "Task #[{$command->getTaskId()}, {$task->getTitle()}, {$task->getJiraId()}] assigned",
            $day
        );

        $this->storageManager->persist($account);
        $this->storageManager->persist($log);
        $this->storageManager->flush();
    }
}
