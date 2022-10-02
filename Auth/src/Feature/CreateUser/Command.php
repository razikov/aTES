<?php

namespace Razikov\AtesAuth\Feature\CreateUser;

use Razikov\AtesAuth\Model\UserRole;

class Command
{
    private string $email;
    private string $password;
    private string $role;

    public function __construct(
        $email,
        $password,
        $role
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): UserRole
    {
        return new UserRole($this->role);
    }
}
