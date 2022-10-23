<?php

namespace Razikov\AtesBilling\Feature\SendPaymentEmail;

class Command
{
    private string $email;
    private int $amount;
    private int $day;

    public function __construct(string $email, int $amount, int $day)
    {
        $this->email = $email;
        $this->amount = $amount;
        $this->day = $day;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDay(): int
    {
        return $this->day;
    }
}
