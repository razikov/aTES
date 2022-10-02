<?php

namespace Razikov\AtesTaskTracker\Feature\CreateUser;

use Razikov\AtesTaskTracker\Model\User;
use Razikov\AtesTaskTracker\Service\StorageManager;

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
    public function handle(Command $command)
    {
        $user = new User(
            $command->getId(),
            $command->getRole()
        );

        $this->storageManager->persist($user);
        $this->storageManager->flush();
    }
}
