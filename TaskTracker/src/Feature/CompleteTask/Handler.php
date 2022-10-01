<?php

namespace Razikov\AtesTaskTracker\Feature\CompleteTask;

class Handler
{
    private $taskRepository;
    private $storageManager;
    private $dispatcher;

    public function __construct(
        $taskRepository,
        $userRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    public function handle(Command $command)
    {
        $task = $this->taskRepository->getById($command->getTaskId());

        $task->complete();

        $this->storageManager->persist($task);
        $this->storageManager->flush();

        $this->dispatcher->dispatch(new TaskCompletedEvent(
            $task->getId(),
            $task->getResponsibeId(),
        ));
    }
}
