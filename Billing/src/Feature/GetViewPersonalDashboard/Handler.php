<?php

namespace Razikov\AtesBilling\Feature\GetViewPersonalDashboard;

use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\AuditRepository;

/**
 * @todo Только для конкретного пользователя
 */
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

    public function handle($command)
    {
        $balance = $this->accountRepository->getCurrentAmountForUser($command->getUserId());
        $logs = $this->auditRepository->getAccountOperationLogForUser($command->getUserId());

        return [
            'balance' => $balance,
            'history' => $logs,
        ];
    }
}
