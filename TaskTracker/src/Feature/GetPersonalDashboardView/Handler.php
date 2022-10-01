<?php

namespace Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView;

use Razikov\AtesTaskTracker\Model\Task;

class Handler
{
    private $taskRepository;

    public function __construct(
        $taskRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    public function handle(Command $command)
    {
        /** @var Task[] $tasks */
        $tasks = $this->taskRepository->getAllForUser($command->getUserId());

        return [
            'tasks' => $tasks,
        ];
    }
}
