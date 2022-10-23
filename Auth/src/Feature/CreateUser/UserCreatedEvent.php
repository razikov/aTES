<?php

namespace Razikov\AtesAuth\Feature\CreateUser;

use Razikov\AtesAuth\Model\BaseEventCommand;

class UserCreatedEvent implements BaseEventCommand
{
    private string $id;
    private string $email;
    private string $role;

    public function __construct(
        string $id,
        string $email,
        string $role
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function toMessage(): array
    {
        return [
            "event" => "UserCreated",
            "version" => 1,
            "payload" => [
                "id" => $this->id,
                "email" => $this->email,
                "role" => $this->role,
            ],
        ];
    }

    public static function createFromMessage(array $message): ?BaseEventCommand
    {
        return null;
    }
}
