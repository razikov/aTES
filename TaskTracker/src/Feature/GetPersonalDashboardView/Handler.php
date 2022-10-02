<?php

namespace Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView;

use Razikov\AtesTaskTracker\Repository\TaskRepository;

class Handler
{
    private TaskRepository $taskRepository;

    public function __construct(
        TaskRepository $taskRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    public function handle(Command $command)
    {
        $tasks = $this->taskRepository->getAllForUser($command->getUserId());

        return [
            'tasks' => $tasks,
        ];
    }
}
