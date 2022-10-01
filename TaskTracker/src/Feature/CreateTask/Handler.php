<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

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

    public function handle(Command $command)
    {
        /** @var User $user */
        $user = $this->userRepository->getRandomUser();

        $task = new Task(
            $taskId = TaskId::generate(),
            $command->getDescription(),
            $user
        );

        $this->storageManager->persist($task);
        $this->storageManager->flush();

        $this->dispatcher->dispatch(new TaskCreatedEvent(
            $taskId->getValue(),
            $command->getDescription(),
            $user->getId()
        ));
        $this->dispatcher->dispatch(new TaskAssignedEvent(
            $taskId->getValue(),
            $user->getId()
        ));
    }
}
