<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

class TaskCreatedEvent
{
    public string $taskId;
    public string $taskDescription;
    public string $userId;

    public function __construct(
        string $taskId,
        string $taskDescription,
        string $userId
    ) {
        $this->taskId = $taskId;
        $this->taskDescription = $taskDescription;
        $this->userId = $userId;
    }
}
