<?php

namespace Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView;

class Command
{
    private string $userId;

    public function __construct(
        $userId
    ) {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
