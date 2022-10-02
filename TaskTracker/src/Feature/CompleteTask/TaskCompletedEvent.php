<?php

namespace Razikov\AtesTaskTracker\Feature\CompleteTask;

class TaskCompletedEvent
{
    public string $userId;
    public string $taskId;

    public function __construct(string $userId, string $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }
}