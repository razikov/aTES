<?php

namespace Razikov\AtesTaskTracker\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Razikov\AtesTaskTracker\Entity\User;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getRandomUser(): ?User
    {
        $userClass = User::class;

        $count = $this->getEntityManager()
            ->createQuery("
                select count(u)
                from $userClass u
                where u.role not in ('ROLE_ADMIN', 'ROLE_ACCOUNTANT')
            ")->getSingleScalarResult();

        if ($count > 0) {
            $randomIdx = rand(0, $count - 1);

            $query = $this->getEntityManager()
                ->createQuery("
                    select u
                    from $userClass u
                    where u.role not in ('ROLE_ADMIN', 'ROLE_ACCOUNTANT')
                ")
                ->setFirstResult($randomIdx)
                ->setMaxResults(1);

            return $query->getOneOrNullResult();
        }

        return null;
    }

    /**
     * @return User[]
     */
    public function getAllAvailableUsersForShuffle(): array
    {
        $userClass = User::class;

        $query = $this->getEntityManager()
            ->createQuery("
                select u
                from $userClass u
                where u.role not in ('ROLE_ADMIN', 'ROLE_ACCOUNTANT')
            ");

        return $query->getResult();
    }
}
