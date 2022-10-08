<?php

namespace Razikov\AtesTaskTracker\Feature\GetDashboardView;

class Command
{
    private int $page;
    private int $limit;

    public function __construct(int $page = 1, int $limit = 10)
    {
        $this->page = $page;
        $this->limit = $limit;
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
