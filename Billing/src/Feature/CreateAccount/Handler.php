<?php

namespace Razikov\AtesBilling\Feature\CreateAccount;

use Razikov\AtesBilling\Repository\UserRepository;
use Razikov\AtesBilling\Service\StorageManager;

class Handler
{
    private UserRepository $userRepository;
    private StorageManager $storageManager;
    private $dispatcher;

    public function __construct(
        UserRepository $userRepository,
        StorageManager $storageManager,
        $dispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->storageManager = $storageManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Слушает событие userCreated
     */
    public function handle(Command $command)
    {

    }
}
