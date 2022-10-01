<?php

namespace Razikov\AtesAuth\Model;

class UserId
{
    private string $value;

    public function __construct(string $id)
    {
        $this->value = $id;
    }

    public static function generate(): UserId
    {
        return new self(uniqid());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
