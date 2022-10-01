<?php

namespace Razikov\AtesBilling\Model;

class AccountOperationType
{
    const DEPOSIT = 'deposit';
    const CHARGE = 'charge';
    const PAYDAY = 'payday';

    private $value;

    public function __construct($value)
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

    public static function createDeposit()
    {
        return new self(self::DEPOSIT);
    }

    public static function createCharge()
    {
        return new self(self::CHARGE);
    }

    public static function createPayday()
    {
        return new self(self::PAYDAY);
    }

    public function getValue()
    {
        return $this->value;
    }
}
