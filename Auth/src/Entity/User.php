<?php

namespace Razikov\AtesAuth\Entity;

use Razikov\AtesAuth\Model\UserId;
use Razikov\AtesAuth\Model\UserRole;
use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesAuth\Repository\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "customer")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true)]
    public string $id;
    #[ORM\Column(type: 'json')]
    public $roles;
    #[ORM\Column(length: 255)]
    public string $password;
    #[ORM\Column(length: 45, unique: true)]
    public string $email;

    public function __construct(
        UserId $id,
        UserRole $role,
        string $email
    ) {
        $this->id = $id->getValue();
        $this->roles = [$role->getValue()];
        $this->email = $email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $hashedPassword)
    {
        $this->password = $hashedPassword;
    }

    public function getPublicId(): string
    {
        return $this->id;
    }
}
