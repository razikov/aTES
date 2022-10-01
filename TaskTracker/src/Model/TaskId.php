<?php

namespace Razikov\AtesTaskTracker\Model;

class TaskId
{
    private string $value;

    public function __construct(string $id)
    {
        $this->value = $id;
    }

    public static function generate(): TaskId
    {
        return new self(uniqid());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
