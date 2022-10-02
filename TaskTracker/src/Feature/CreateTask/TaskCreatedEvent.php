<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

class TaskCreatedEvent
{
    public string $id;
    public string $description;
    public string $responsibleId;

    public function __construct(
        string $taskId,
        string $taskDescription,
        string $userId
    ) {
        $this->id = $taskId;
        $this->description = $taskDescription;
        $this->responsibleId = $userId;
    }
}
