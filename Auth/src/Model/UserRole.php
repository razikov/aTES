<?php

namespace Razikov\AtesAuth\Model;

class UserRole
{
    const ADMIN = 'ROLE_ADMIN';
    const MANAGER = 'ROLE_MANAGER';
    const ACCOUNTANT = 'ROLE_ACCOUNTANT'; // бухгалтер
    const DEVELOPER = 'ROLE_DEVELOPER';

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, $this->getAvailableRoles())) {
            throw new \DomainException("invalid role");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAvailableRoles(): array
    {
        return [
            self::ADMIN,
            self::MANAGER,
            self::ACCOUNTANT,
            self::DEVELOPER,
        ];
    }
}
