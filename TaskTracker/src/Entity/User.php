<?php

namespace Razikov\AtesTaskTracker\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Razikov\AtesTaskTracker\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "customer")]
class User implements JWTUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true)]
    private string $id;
    #[ORM\Column(length: 255)]
    private string $role;

    public function __construct(string $id, string $role)
    {
        $this->id = $id;
        $this->role = $role;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $payload['userId'],
            $payload['roles'][0]
        );
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }
}
