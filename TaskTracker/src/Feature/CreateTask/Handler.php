<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

use Razikov\AtesTaskTracker\Feature\AssignTasks\TaskAssignedEvent;
use Razikov\AtesTaskTracker\Model\Task;
use Razikov\AtesTaskTracker\Model\TaskId;
use Razikov\AtesTaskTracker\Repository\UserRepository;
use Razikov\AtesTaskTracker\Service\StorageManager;
use Symfony\Component\Messenger\MessageBusInterface;

class Handler
{
    private UserRepository $userRepository;
    private StorageManager $storageManager;
    private MessageBusInterface $dispatcher;

    public function __construct(
        UserRepository $userRepository,
        StorageManager $storageManager,
        MessageBusInterface $dispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->storageManager = $storageManager;
        $this->dispatcher = $dispatcher;
    }

    public function handle(Command $command)
    {
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
