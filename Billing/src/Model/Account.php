<?php

namespace Razikov\AtesBilling\Model;

class Account
{
    public string $userId;
    public int $amount;

    public function __construct(string $userId, int $amount = 0)
    {
        $this->userId = $userId;
        $this->amount = $amount;
    }

    public function charge(int $amount)
    {
        $this->amount += $amount;
    }

    public function deposit(int $amount)
    {
        $this->amount += $amount;
    }

    public function payday(): int
    {
        if ($this->amount > 0) {
            $amount = $this->amount;
            $this->amount = 0;
            return $amount;
        }

        return $this->amount;
    }
}
