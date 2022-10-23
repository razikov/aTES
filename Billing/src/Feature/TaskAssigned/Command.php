<?php

namespace Razikov\AtesBilling\Feature\TaskAssigned;

use Razikov\AtesBilling\Model\BaseEventCommand;

class Command implements BaseEventCommand
{
    private string $userId;
    private string $taskId;

    public function __construct(string $userId, string $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function toMessage(): array
    {
        throw new \DomainException("Not supported");
    }

    public static function createFromMessage(array $message): ?BaseEventCommand
    {
        if (
            $message['event'] == 'TaskAssigned'
            && in_array($message['version'], [1])
        ) {
            $payload = $message['payload'];
            return new self(
                $payload['userId'],
                $payload['taskId']
            );
        } else {
            return null;
        }
    }
}
