<?php

namespace Razikov\AtesTaskTracker\Feature\AssignTasks;

use Razikov\AtesTaskTracker\Model\BaseEventCommand;

class TaskAssignedEvent implements BaseEventCommand
{
    public string $userId;
    public string $taskId;

    public function __construct(string $userId, string $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }

    public function toMessage(): array
    {
        return [
            "event" => "TaskAssigned",
            "version" => 1,
            "payload" => [
                "userId" => $this->userId,
                "taskId" => $this->taskId,
            ],
        ];
    }

    public static function createFromMessage(array $message): ?TaskAssignedEvent
    {
        return null;
    }
}
