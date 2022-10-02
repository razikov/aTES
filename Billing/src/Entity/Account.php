<?php

namespace Razikov\AtesBilling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\AccountRepository;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    public string $userId;
    #[ORM\Column]
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
