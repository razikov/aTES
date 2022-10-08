<?php

namespace Razikov\AtesTaskTracker\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Razikov\AtesTaskTracker\Entity\Task;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Берет все открытые задачи
     * @return Task[]
     */
    public function getAllOpenTasks(): array
    {
        $taskClass = Task::class;

        $query = $this->getEntityManager()
            ->createQuery("
                select t
                from $taskClass t
                where t.status = :status
            ")
            ->setParameter('status', 'open');

        return $query->getResult();
    }

    public function getById($taskId, $responsibleId): ?Task
    {
        $taskClass = Task::class;

        $query = $this->getEntityManager()
            ->createQuery("
                select t
                from $taskClass t
                join t.responsible r
                where t.id = :taskId and r.id = :responsibleId
            ")
            ->setParameter('taskId', $taskId)
            ->setParameter('responsibleId', $responsibleId);

        return $query->getOneOrNullResult();
    }

    /**
     * @return Task[]
     */
    public function getAllForUser(string $responsibleId, int $page = 1, int $limit = 10): array
    {
        $taskClass = Task::class;
        $query = $this->getEntityManager()
            ->createQuery("
                select t
                from $taskClass t
                join t.responsible r
                where r.id = :responsibleId
            ")
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->setParameter('responsibleId', $responsibleId);

        return $query->getResult();
    }
}
