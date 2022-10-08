<?php

namespace Razikov\AtesBilling\Feature\TaskCreated;

use Razikov\AtesBilling\Model\BaseEventCommand;

class Command implements BaseEventCommand
{
    private string $userId;
    private string $taskId;
    private string $taskDescription;

    public function __construct(string $userId, string $taskId, string $taskDescription)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
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

    public function toMessage(): array
    {
        throw new \DomainException("Not supported");
    }

    public static function createFromMessage(array $message): ?BaseEventCommand
    {
        if (
            $message['event'] == 'TaskCreated'
            && in_array($message['version'], [1])
        ) {
            $payload = $message['payload'];
            return new self(
                $payload['responsibleId'],
                $payload['id'],
                $payload['description'],
            );
        } else {
            return null;
        }
    }
}
