<?php

namespace Razikov\AtesBilling\Feature\CreateAccount;

use Razikov\AtesBilling\Model\BaseEventCommand;

class Command implements BaseEventCommand
{
    private string $userId;
    private string $email;

    public function __construct(string $userId, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
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
                $payload['email']
            );
        } else {
            return null;
        }
    }
}
