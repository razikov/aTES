<?php

namespace Razikov\AtesTaskTracker\Model;

class Task
{
    private string $id;
    private string $description;
    private string $status;
    private User $responsible;

    public function __construct(
        TaskId $id,
        string $description,
        User $responsible
    ) {
        $this->id = $id->getValue();
        $this->status = 'opened';
        $this->description = $description;
        $this->assign($responsible);
    }

    public function complete()
    {
        $this->status = 'completed';
    }

    public function assign(User $responsible)
    {
        $this->responsible = $responsible;
    }
}
