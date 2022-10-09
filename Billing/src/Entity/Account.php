<?php

namespace Razikov\AtesBilling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\AccountRepository;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true, name: "id")]
    public string $userId;
    #[ORM\Column(length: 255)]
    public string $email;
    #[ORM\Column]
    public int $amount;

    public function __construct(string $userId, string $email, int $amount = 0)
    {
        $this->userId = $userId;
        $this->email = $email;
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

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
