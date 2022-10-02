<?php

namespace Razikov\AtesTaskTracker\Feature\AssignTasks;

class TaskAssignedEvent
{
    public string $userId;
    public string $taskId;

    public function __construct(string $userId, string $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }
}
