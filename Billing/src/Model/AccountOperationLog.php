<?php

namespace Razikov\AtesBilling\Model;

class AccountOperationLog
{
    private $id;
    private string $userId;
    private $type;
    private int $amount;
    private string $description;
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
