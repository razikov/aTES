<?php

namespace Razikov\AtesBilling\Feature\CreateAccount;

use Razikov\AtesBilling\Entity\Account;
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
        $account = new Account(
            $command->getUserId(),
            0
        );

        $this->storageManager->persist($account);
        $this->storageManager->flush();
    }
}
