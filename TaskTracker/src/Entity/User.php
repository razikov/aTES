<?php

namespace Razikov\AtesTaskTracker\Entity;

use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesTaskTracker\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "customer")]
class User
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $id;
    #[ORM\Column(length: 255)]
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
