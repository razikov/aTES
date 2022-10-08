<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

use Razikov\AtesTaskTracker\Model\BaseEventCommand;

class TaskCreatedEvent implements BaseEventCommand
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

    public function toMessage(): array
    {
        return [
            "event" => "TaskCreated",
            "version" => 1,
            "payload" => [
                "id" => $this->id,
                "description" => $this->description,
                "responsibleId" => $this->responsibleId,
            ],
        ];
    }

    public static function createFromMessage(array $message): ?TaskCreatedEvent
    {
        return null;
    }
}
