<?php

namespace Razikov\AtesTaskTracker\Feature\CreateUser;

use Razikov\AtesTaskTracker\Model\Task;
use Razikov\AtesTaskTracker\Model\TaskId;
use Razikov\AtesTaskTracker\Model\User;

class Handler
{
    private $userRepository;
    private $storageManager;
    private $dispatcher;

    public function __construct(
        $userRepository,
        $storageManager,
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
