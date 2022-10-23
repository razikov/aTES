<?php

namespace Razikov\AtesTaskTracker\Feature\GetDashboardView;

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

        $tasks = $this->taskRepository->findBy([], null, $limit, (($page - 1) * $limit));

        return [
            'tasks' => $tasks,
        ];
    }
}
