<?php

namespace Razikov\AtesTaskTracker\Feature\AssignTasks;

use Razikov\AtesTaskTracker\Entity\User;
use Razikov\AtesTaskTracker\Repository\TaskRepository;
use Razikov\AtesTaskTracker\Repository\UserRepository;
use Razikov\AtesTaskTracker\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class Handler
{
    private TaskRepository $taskRepository;
    private UserRepository $userRepository;
    private StorageManager $storageManager;
    private MessageBusInterface $dispatcher;

    public function __construct(
        TaskRepository $taskRepository,
        UserRepository $userRepository,
        StorageManager $storageManager,
        MessageBusInterface $dispatcher
    ) {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->storageManager = $storageManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Command $command
     * @todo может вызываться хоть каждую секунду, точно не успеет обработать до следующего вызова
     * @todo будут проблемы с памятью и размерами выборок
     */
    public function __invoke(Command $command)
    {
        $openTasks = $this->taskRepository->getRandomAllOpenTasks();
        $randomUsers = $this->userRepository->getRandomAvailableAllUsers();

        $events = [];
        foreach ($openTasks as $openTask) {
            /** @var User $randomUser */
            $randomUser = array_rand($randomUsers); // @todo
            $openTask->assign($randomUser);
            $this->storageManager->persist($openTask);
            $events[] = new TaskAssignedEvent(
                $randomUser->getId(),
                $openTask->getId()
            );
        }

        $this->storageManager->flush();

        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
