<?php

namespace Razikov\AtesBilling\Feature\Charge;

class Command
{
    private string $userId;
    private string $taskId;

    public function __construct(string $userId, string $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }
}
