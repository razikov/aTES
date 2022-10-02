<?php

namespace Razikov\AtesTaskTracker\Feature\CreateUser;

use Razikov\AtesTaskTracker\Entity\User;
use Razikov\AtesTaskTracker\Service\StorageManager;
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

    /**
     * Слушает событие userCreated из auth
     */
    public function __invoke(Command $command)
    {
        $user = new User(
            $command->getId(),
            $command->getRole()
        );

        $this->storageManager->persist($user);
        $this->storageManager->flush();
    }
}
