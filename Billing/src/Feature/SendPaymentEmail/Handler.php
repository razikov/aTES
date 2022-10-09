<?php

namespace Razikov\AtesBilling\Feature\SendPaymentEmail;

use Ramsey\Uuid\Uuid;
use Razikov\AtesBilling\Entity\EmailLog;
use Razikov\AtesBilling\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    private StorageManager $storageManager;

    public function __construct(
        StorageManager $storageManager
    ) {
        $this->storageManager = $storageManager;
    }

    public function __invoke(Command $command)
    {
        $message = sprintf(
            "Пользователю %s выплачено %s за %s день",
            $command->getEmail(),
            $command->getAmount(),
            $command->getDay()
        );

        $emailLog = new EmailLog(
            Uuid::uuid7(),
            $message,
            new \DateTimeImmutable()
        );

        $this->storageManager->persist($emailLog);
        $this->storageManager->flush();
    }
}
