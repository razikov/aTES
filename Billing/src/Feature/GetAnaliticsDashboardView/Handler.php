<?php

namespace Razikov\AtesBilling\Feature\GetAnaliticsDashboardView;

use Razikov\AtesBilling\Repository\AuditRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @todo Только для роли админ
 */
#[AsMessageHandler]
class Handler
{
    private AuditRepository $auditRepository;

    public function __construct(
        AuditRepository $auditRepository
    ) {
        $this->auditRepository = $auditRepository;
    }
    
    public function __invoke(Command $command): array
    {
        $completedTaskAmount = $this->auditRepository->getCompletedTaskAmountPerDay();
        $assignedTaskFee = $this->auditRepository->getAssignedTaskAmountPerDay();
        $balancePerDay = $completedTaskAmount - $assignedTaskFee;
        $countLosses = $this->auditRepository->getCountLossesPerDay();
        $maxCost = $this->auditRepository->getMaxCostPerDay();

        return [
            'revenue' => $balancePerDay, // за сегодня
            'countLosses' => $countLosses, // количество попуг в минусе
            'maxCost' => $maxCost,
        ];
    }
}
