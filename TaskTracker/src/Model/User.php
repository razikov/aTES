<?php

namespace Razikov\AtesTaskTracker\Model;

class User
{
    private string $id;
    private string $role;

    public function __construct($id, $role)
    {
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
}
