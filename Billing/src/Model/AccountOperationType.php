<?php

namespace Razikov\AtesBilling\Model;

class AccountOperationType
{
    const DEPOSIT = 'deposit';
    const CHARGE = 'charge';
    const PAYDAY = 'payday';

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, $this->availableValue())) {
            throw new \DomainException("invalid value");
        }

        $this->value = $value;
    }

    public function availableValue(): array
    {
        return [
            self::DEPOSIT,
            self::CHARGE,
            self::PAYDAY,
        ];
    }

    public static function createDeposit(): AccountOperationType
    {
        return new self(self::DEPOSIT);
    }

    public static function createCharge(): AccountOperationType
    {
        return new self(self::CHARGE);
    }

    public static function createPayday(): AccountOperationType
    {
        return new self(self::PAYDAY);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
