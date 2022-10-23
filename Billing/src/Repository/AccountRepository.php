<?php

namespace Razikov\AtesBilling\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Razikov\AtesBilling\Entity\Account;

class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function getById(string $userId): ?Account
    {
        $accountClass = Account::class;
        $query = $this->getEntityManager()
            ->createQuery("
                select a
                from $accountClass a
                where a.userId = :userId
            ")
            ->setParameter('userId', $userId);

        return $query->getOneOrNullResult();
    }

    /**
     * @return Account[]
     */
    public function getAllProfitableAccount(): array
    {
        $accountClass = Account::class;
        $query = $this->getEntityManager()
            ->createQuery("
                    select a
                    from $accountClass a
                    where a.amount > 0
                ");

        return $query->getResult();
    }

    public function getCurrentAmountForUser(string $userId)
    {
        $accountClass = Account::class;
        $query = $this->getEntityManager()
            ->createQuery("
                    select a.amount
                    from $accountClass a
                    where a.userId = :userId
                ")
            ->setParameter('userId', $userId);

        return $query->getSingleScalarResult();
    }

    public function getCountLossesPerDay(): int
    {
        $accountClass = Account::class;
        $query = $this->getEntityManager()
            ->createQuery("
                select count(log)
                from $accountClass log
                where log.amount < 0
            ");

        return $query->getSingleScalarResult();
    }
}
