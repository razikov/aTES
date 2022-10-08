<?php

namespace Razikov\AtesBilling\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Razikov\AtesBilling\Entity\AccountOperationLog;
use Razikov\AtesBilling\Model\AccountOperationType;

class AuditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountOperationLog::class);
    }

    public function getCompletedTaskAmountPerDay(int $day): int
    {
        $accountOperationLogClass = AccountOperationLog::class;
        $query = $this->getEntityManager()
            ->createQuery("
                    select sum(log.amount)
                    from $accountOperationLogClass log
                    where log.day = :day and log.type = :type
                ")
            ->setParameter('day', $day)
            ->setParameter('type', AccountOperationType::DEPOSIT);

        $result = $query->getSingleScalarResult();
        if (!$result) {
            return 0;
        }

        return $result;
    }

    public function getAssignedTaskAmountPerDay(int $day): int
    {
        $accountOperationLogClass = AccountOperationLog::class;
        $query = $this->getEntityManager()
            ->createQuery("
                    select sum(log.amount)
                    from $accountOperationLogClass log
                    where log.day = :day and log.type = :type
                ")
            ->setParameter('day', $day)
            ->setParameter('type', AccountOperationType::CHARGE);

        $result = $query->getSingleScalarResult();
        if (!$result) {
            return 0;
        }

        return $result;
    }

    /**
     * @param string $userId
     * @return AccountOperationLog[]
     */
    public function getAccountOperationLogForUser(string $userId): array
    {
        $accountOperationLogClass = AccountOperationLog::class;
        $query = $this->getEntityManager()
            ->createQuery("
                    select log
                    from $accountOperationLogClass log
                    where log.userId = :userId
                ")
            ->setParameter('userId', $userId);

        return $query->getResult();
    }

    public function getMaxCostTaskPerDay(int $day): ?int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT max(log.amount)
            FROM account_operation_log log
            INNER JOIN task t ON t.id = log.task_id
            WHERE log.day = :day and log.type = :type
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'day' => $day,
            'type' => AccountOperationType::DEPOSIT
        ]);

        return $resultSet->fetchOne();
    }
}
