<?php

namespace Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView;

class Command
{
    private string $userId;
    private int $page;
    private int $limit;

    public function __construct(
        string $userId,
        int $page = 1,
        int $limit = 10
    ) {
        $this->userId = $userId;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
