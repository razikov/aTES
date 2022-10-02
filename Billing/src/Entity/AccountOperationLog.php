<?php

namespace Razikov\AtesBilling\Entity;

use Razikov\AtesBilling\Model\AccountOperationType;
use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\AuditRepository;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
class AccountOperationLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;
    #[ORM\Column]
    private string $userId;
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
        AccountOperationType $type,
        int $amount,
        string $description,
        int $day
    ) {
        $this->userId = $userId;
        $this->type = $type->getValue();
        $this->amount = $amount;
        $this->description = $description;
        $this->day = $day;
    }
}
