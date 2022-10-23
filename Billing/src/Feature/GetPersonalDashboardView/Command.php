<?php

namespace Razikov\AtesBilling\Feature\GetPersonalDashboardView;

class Command
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
