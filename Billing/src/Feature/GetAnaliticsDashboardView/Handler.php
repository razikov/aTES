<?php

namespace Razikov\AtesBilling\Feature\GetAnaliticsDashboardView;

use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\AuditRepository;
use Razikov\AtesBilling\Repository\ChronosRepository;
use Razikov\AtesBilling\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    private AuditRepository $auditRepository;
    private AccountRepository $accountRepository;
    private ChronosRepository $chronosRepository;
    private TaskRepository $taskRepository;

    public function __construct(
        AuditRepository $auditRepository,
        AccountRepository $accountRepository,
        ChronosRepository $chronosRepository,
        TaskRepository $taskRepository
    ) {
        $this->auditRepository = $auditRepository;
        $this->accountRepository = $accountRepository;
        $this->chronosRepository = $chronosRepository;
        $this->taskRepository = $taskRepository;
    }
    
    public function __invoke(Command $command): array
    {
        $chronos = $this->chronosRepository->getOrCreateOnlyOneAllowed();
        $day = $chronos->getDay();

        $completedTaskAmount = $this->auditRepository->getCompletedTaskAmountPerDay($day);
        $assignedTaskFee = $this->auditRepository->getAssignedTaskAmountPerDay($day);
        $balancePerDay = $completedTaskAmount + $assignedTaskFee;
        $countLosses = $this->accountRepository->getCountLossesPerDay();
        $maxCost = $this->auditRepository->getMaxCostTaskPerDay($day);

        return [
            'revenue' => $balancePerDay,
            'countLosses' => $countLosses,
            'maxCost' => $maxCost,
        ];
    }
}
