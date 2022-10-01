<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

class Command
{
    private ?string $userId;
    private string $description;

    public function __construct(
        $description,
        $userId = null
    ) {
        $this->userId = $userId;
        $this->description = $description;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
