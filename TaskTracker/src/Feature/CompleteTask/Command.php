<?php

namespace Razikov\AtesTaskTracker\Feature\CompleteTask;

class Command
{
    private $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function getTaskId()
    {
        return $this->taskId;
    }
}
