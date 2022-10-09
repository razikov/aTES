<?php

namespace Razikov\AtesBilling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\EmailLogRepository;

#[ORM\Entity(repositoryClass: EmailLogRepository::class)]
class EmailLog
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true)]
    private string $id;
    #[ORM\Column(type: 'text')]
    private string $message;
    #[ORM\Column(name: "sended_at", type: "datetime")]
    private \DateTimeImmutable $sendedAt;

    public function __construct(string $id, string $message, \DateTimeImmutable $sendedAt)
    {
        $this->id = $id;
        $this->message = $message;
        $this->sendedAt = $sendedAt;
    }
}
