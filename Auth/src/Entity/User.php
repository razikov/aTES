<?php

namespace Razikov\AtesAuth\Entity;

use Razikov\AtesAuth\Model\UserId;
use Razikov\AtesAuth\Model\UserRole;
use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesAuth\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "customer")]
class User
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    public string $id;
    #[ORM\Column(length: 255)]
    public string $role;
    #[ORM\Column(length: 255)]
    public string $password;
    #[ORM\Column(length: 255)]
    // @todo unique
    public string $email;

    public function __construct(
        UserId $id,
        UserRole $role,
        string $password,
        string $email
    ) {
        $this->id = $id->getValue();
        $this->role = $role->getValue();
        $this->email = $email;
        $this->password = $password;
    }
}
