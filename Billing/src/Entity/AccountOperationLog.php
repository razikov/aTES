<?php

namespace Razikov\AtesBilling\Entity;

use Ramsey\Uuid\Uuid;
use Razikov\AtesBilling\Model\AccountOperationType;
use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\AuditRepository;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
class AccountOperationLog
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true)]
    private $id;
    #[ORM\Column(type: "guid")]
    private string $userId;
    #[ORM\Column(type: "guid", nullable: true)]
    private ?string $taskId;
    #[ORM\Column(length: 16)]
    private string $type;
    #[ORM\Column]
    private int $amount;
    #[ORM\Column(type: 'text')]
    private string $description;
    #[ORM\Column]
    private int $day;

    public function __construct(
        string $userId,
        ?string $taskId,
        AccountOperationType $type,
        int $amount,
        string $description,
        int $day
    ) {
        $this->id = Uuid::uuid7();
        $this->userId = $userId;
        $this->taskId = $taskId;
        $this->type = $type->getValue();
        $this->amount = $amount;
        $this->description = $description;
        $this->day = $day;
    }
}
