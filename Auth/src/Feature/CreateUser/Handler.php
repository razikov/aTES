<?php

namespace Razikov\AtesAuth\Feature\CreateUser;

use Razikov\AtesAuth\Model\User;
use Razikov\AtesAuth\Repository\UserRepository;
use Razikov\AtesAuth\Service\StorageManager;
use Razikov\AtesBilling\Model\Account;
use Razikov\AtesBilling\Model\AccountOperationLog;
use Razikov\AtesBilling\Model\AccountOperationType;

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
     * Срабатывает, когда назначается исполнитель. Читает событие taskAssigned
     */
    public function handle(Command $command)
    {
        $user = new User();

        $this->storageManager->persist($user);
        $this->storageManager->flush();

        $this->dispatcher->dispatch(new UserCreatedEvent());
    }
}
