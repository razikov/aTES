<?php

namespace Razikov\AtesTaskTracker\Feature\CompleteTask;

use Razikov\AtesTaskTracker\Repository\TaskRepository;
use Razikov\AtesTaskTracker\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class Handler
{
    private TaskRepository $taskRepository;
    private StorageManager $storageManager;
    private MessageBusInterface $dispatcher;

    public function __construct(
        TaskRepository $taskRepository,
        StorageManager $storageManager,
        MessageBusInterface $dispatcher
    ) {
        $this->taskRepository = $taskRepository;
        $this->storageManager = $storageManager;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Command $command)
    {
        $task = $this->taskRepository->getById($command->getTaskId(), $command->getUserId());

        $task->complete();

        $this->storageManager->persist($task);
        $this->storageManager->flush();

        $this->dispatcher->dispatch(new TaskCompletedEvent(
            $command->getTaskId(),
            $command->getUserId(),
        ));
    }
}
