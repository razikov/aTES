<?php

namespace Razikov\AtesBilling\Feature\GetAnalitickViewDashboard;

use Razikov\AtesBilling\Repository\AuditRepository;

/**
 * @todo Только для роли админ
 */
class Handler
{
    private AuditRepository $auditRepository;

    public function __construct(
        AuditRepository $auditRepository
    ) {
        $this->auditRepository = $auditRepository;
    }
    
    public function handle(Command $command): array
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
