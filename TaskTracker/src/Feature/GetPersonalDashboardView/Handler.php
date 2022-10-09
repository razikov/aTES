<?php

namespace Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView;

use Razikov\AtesTaskTracker\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    private TaskRepository $taskRepository;

    public function __construct(
        TaskRepository $taskRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(Command $command)
    {
        $page = $command->getPage();
        $limit = $command->getLimit();

        $tasks = $this->taskRepository->getAllForUser($command->getUserId(), $page, $limit);

        return [
            'tasks' => $tasks,
        ];
    }
}
