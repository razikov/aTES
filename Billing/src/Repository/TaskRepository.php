<?php

namespace Razikov\AtesBilling\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Razikov\AtesBilling\Entity\Account;
use Razikov\AtesBilling\Entity\Task;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getById(string $taskId): ?Task
    {
        $taskClass = Task::class;
        $query = $this->getEntityManager()
            ->createQuery("
                    select t
                    from $taskClass t
                    where t.id = :taskId
                ")
            ->setParameter('taskId', $taskId);

        return $query->getOneOrNullResult();
    }

    public function getMaxCostPerDay(int $day)
    {
        $taskClass = Task::class;
        $query = $this->getEntityManager()
            ->createQuery("
                select max(t.reward)
                from $taskClass t
                where t.id = :taskId
            ")
            ->setParameter('day', $day);

        $query = $qb->getQuery();

        return $query->execute();

        return $query->getSingleScalarResult();
    }
}
