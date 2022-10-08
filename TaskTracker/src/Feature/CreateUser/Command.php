<?php

namespace Razikov\AtesTaskTracker\Feature\CreateUser;

use Razikov\AtesTaskTracker\Model\BaseEventCommand;

class Command implements BaseEventCommand
{
    private string $id;
    private string $role;

    public function __construct(
        string $id,
        string $role
    ) {
        $this->id = $id;
        $this->role = $role;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function toMessage(): array
    {
        throw new \DomainException("Not supported");
    }

    public static function createFromMessage(array $message): ?Command
    {
        if (
            $message['event'] == 'UserCreated'
            && in_array($message['version'], [1])
        ) {
            $payload = $message['payload'];
            return new self(
                $payload['id'],
                $payload['role'],
            );
        } else {
            return null;
        }
    }
}
