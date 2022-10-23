<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

use Razikov\AtesTaskTracker\Model\BaseEventCommand;

class TaskCreatedEventV2 implements BaseEventCommand
{
    public string $id;
    public string $title;
    public string $jiraId;
    public string $description;
    public string $responsibleId;

    public function __construct(
        string $taskId,
        string $title,
        string $jiraId,
        string $taskDescription,
        string $userId
    ) {
        $this->id = $taskId;
        $this->title = $title;
        $this->jiraId = $jiraId;
        $this->description = $taskDescription;
        $this->responsibleId = $userId;
    }

    public function toMessage(): array
    {
        return [
            "event" => "TaskCreated",
            "version" => 2,
            "payload" => [
                "id" => $this->id,
                "title" => $this->title,
                "jiraId" => $this->jiraId,
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
