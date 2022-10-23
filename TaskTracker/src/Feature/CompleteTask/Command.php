<?php

namespace Razikov\AtesTaskTracker\Feature\CompleteTask;

class Command
{
    private string $taskId;
    private string $responsibleId;

    public function __construct(string $taskId, string $userId)
    {
        $this->taskId = $taskId;
        $this->responsibleId = $userId;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getUserId(): string
    {
        return $this->responsibleId;
    }
}
