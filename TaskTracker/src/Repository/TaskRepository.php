<?php

namespace Razikov\AtesTaskTracker\Repository;

use Razikov\AtesTaskTracker\Entity\Task;

class TaskRepository
{
    /**
     * Берет все открытые задачи
     * @return Task[]
     */
    public function getRandomAllOpenTasks(): array
    {
    }

    public function getById($taskId, $responsibleId): ?Task
    {
    }

    /**
     * @return Task[]
     */
    public function getAll(): array
    {
    }

    /**
     * @return Task[]
     */
    public function getAllForUser($getUserId): array
    {
    }
}
