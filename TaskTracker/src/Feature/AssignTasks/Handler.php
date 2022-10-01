<?php

namespace Razikov\AtesTaskTracker\Feature\AssignTasks;

use Razikov\AtesTaskTracker\Model\User;
use Razikov\AtesTaskTracker\Model\Task;

class Handler
{
    private $taskRepository;
    private $userRepository;
    private $dispatcher;
    private $storageManager;

    public function __construct(
        $taskRepository,
        $userRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @todo будут проблемы с памятью и размерами выборок
     * @todo может вызываться хоть каждую секунду, точно не успеет обработать до следующего вызова
     * @param $command
     */
    public function handle($command)
    {
        // Берет все открытые задачи
        $openTasks = $this->taskRepository->getRandomAllOpenTasks();
        // Любой сотрудник кроме менеджера или админа
        $randomUsers = $this->userRepository->getRandomAvailableAllUsers();

        $events = [];
        foreach ($openTasks as $openTask) {
            /** @var User $randomUser */
            $randomUser = array_rand($randomUsers);
            /** @var Task $openTask */
            $openTask->assign($randomUser);
            $this->storageManager->persist($openTask);
            $events[] = new TaskAssignedEvent();
        }

        $this->storageManager->flush();

        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
