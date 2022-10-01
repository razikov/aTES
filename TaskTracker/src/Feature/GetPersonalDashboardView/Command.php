<?php

namespace Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView;

class Command
{
    private $userId;

    public function __construct(
        $userId
    ) {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
