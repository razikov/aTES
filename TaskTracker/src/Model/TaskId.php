<?php

namespace Razikov\AtesTaskTracker\Model;

use Ramsey\Uuid\Uuid;

class TaskId
{
    private string $value;

    public function __construct(string $id)
    {
        $this->value = $id;
    }

    public static function generate(): TaskId
    {
        return new self(Uuid::uuid7());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
