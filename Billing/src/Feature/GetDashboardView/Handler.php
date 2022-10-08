<?php

namespace Razikov\AtesBilling\Feature\GetDashboardView;

use Razikov\AtesBilling\Repository\AuditRepository;
use Razikov\AtesBilling\Repository\ChronosRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @todo Только для ролей админ и бухгалтер
 */
#[AsMessageHandler]
class Handler
{
    private AuditRepository $auditRepository;
    private ChronosRepository $chronosRepository;

    public function __construct(
        AuditRepository $auditRepository,
        ChronosRepository $chronosRepository
    ) {
        $this->auditRepository = $auditRepository;
        $this->chronosRepository = $chronosRepository;
    }

    public function __invoke(Command $command): array
    {
        $chronos = $this->chronosRepository->getOrCreateOnlyOneAllowed();
        $day = $chronos->getDay();

        $completedTaskAmount = $this->auditRepository->getCompletedTaskAmountPerDay($day);
        $assignedTaskFee = $this->auditRepository->getAssignedTaskAmountPerDay($day);
        $balancePerDay = $completedTaskAmount + $assignedTaskFee;

        return [
            'revenue' => $balancePerDay,
            'stats' => [],
        ];
    }
}
