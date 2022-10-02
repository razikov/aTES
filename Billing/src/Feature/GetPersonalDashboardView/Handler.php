<?php

namespace Razikov\AtesBilling\Feature\GetPersonalDashboardView;

use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\AuditRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @todo Только для конкретного пользователя
 */
#[AsMessageHandler]
class Handler
{
    private AccountRepository $accountRepository;
    private AuditRepository $auditRepository;

    public function __construct(
        AccountRepository $accountRepository,
        AuditRepository $auditRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->auditRepository = $auditRepository;
    }

    public function __invoke(Command $command)
    {
        $balance = $this->accountRepository->getCurrentAmountForUser($command->getUserId());
        $logs = $this->auditRepository->getAccountOperationLogForUser($command->getUserId());

        return [
            'balance' => $balance,
            'history' => $logs,
        ];
    }
}
