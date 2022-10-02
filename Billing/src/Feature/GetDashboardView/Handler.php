<?php

namespace Razikov\AtesBilling\Feature\GetDashboardView;

use Razikov\AtesBilling\Repository\AuditRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @todo Только для ролей админ и бухгалтер
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

        return [
            'revenue' => $balancePerDay, // за сегодня
            'history' => [],
        ];
    }
}
