<?php

namespace Razikov\AtesBilling\Feature\TaskCreatedV2;

use Razikov\AtesBilling\Model\BaseEventCommand;

class Command implements BaseEventCommand
{
    private string $userId;
    private string $taskId;
    private string $taskDescription;
    private string $title;
    private string $jiraId;

    public function __construct(string $userId, string $taskId, string $title, string $jiraId, string $taskDescription)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
        $this->title = $title;
        $this->jiraId = $jiraId;
        $this->taskDescription = $taskDescription;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getTaskDescription(): string
    {
        return $this->taskDescription;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getJiraId(): string
    {
        return $this->jiraId;
    }

    public function toMessage(): array
    {
        throw new \DomainException("Not supported");
    }

    public static function createFromMessage(array $message): ?BaseEventCommand
    {
        if (
            $message['event'] == 'TaskCreated'
            && in_array($message['version'], [2])
        ) {
            $payload = $message['payload'];
            return new self(
                $payload['responsibleId'],
                $payload['id'],
                $payload['title'],
                $payload['jiraId'],
                $payload['description'],
            );
        } else {
            return null;
        }
    }
}
