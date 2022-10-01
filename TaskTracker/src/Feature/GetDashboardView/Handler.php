<?php

namespace Razikov\AtesTaskTracker\Feature\GetDashboardView;

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
        $tasks = $this->taskRepository->getAll();

        return [
            'tasks' => $tasks,
        ];
    }
}
