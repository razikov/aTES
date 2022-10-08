<?php

namespace Razikov\AtesBilling\Model;

use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;

class User extends JWTUser implements JWTUserInterface
{
    private string $id;
    private string $role;

    public function __construct(string $id, string $role)
    {
        parent::__construct($id);
        $this->id = $id;
        $this->role = $role;
    }

    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $payload['userId'],
            $payload['roles'][0]
        );
    }

    public function getId(): string
    {
        return $this->id;
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
