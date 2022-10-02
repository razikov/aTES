<?php

namespace Razikov\AtesTaskTracker\Controller;

use Razikov\AtesTaskTracker\Feature\CreateTask\Command as CreateTaskCommand;
use Razikov\AtesTaskTracker\Feature\AssignTasks\Command as AssignTasksCommand;
use Razikov\AtesTaskTracker\Feature\CompleteTask\Command as CompleteTaskCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class TaskController
{
    public function create(
        MessageBusInterface $bus
    ) {
        $bus->dispatch(new CreateTaskCommand(
            $description
        ));
    }

    public function assigns(
        MessageBusInterface $bus
    ) {
        $bus->dispatch(new AssignTasksCommand());
    }

    public function complete(
        MessageBusInterface $bus
    ) {
        $bus->dispatch(new CompleteTaskCommand(
            $taskId
        ));
    }
}
