<?php

namespace Razikov\AtesAuth\Model;

use Ramsey\Uuid\Uuid;

class UserId
{
    private string $value;

    public function __construct(string $id)
    {
        $this->value = $id;
    }

    public static function generate(): UserId
    {
        return new self(Uuid::uuid7());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
