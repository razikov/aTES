<?php

namespace Razikov\AtesBilling\Feature\GetViewDashboard;

use Razikov\AtesBilling\Repository\AuditRepository;

/**
 * @todo Только для ролей админ и бухгалтер
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

        return [
            'revenue' => $balancePerDay, // за сегодня
            'history' => [],
        ];
    }
}
