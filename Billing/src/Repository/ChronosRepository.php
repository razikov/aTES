<?php

namespace Razikov\AtesBilling\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Razikov\AtesBilling\Entity\Chronos;

class ChronosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chronos::class);
    }

    public function getOrCreateOnlyOneAllowed(): Chronos
    {
        $chronosClass = Chronos::class;
        $chronos = $this->getEntityManager()
            ->createQuery("
                select c
                from $chronosClass c
                where c.id = :id
            ")
            ->setParameter('id', "OnlyOneAllowed")
            ->getOneOrNullResult();

        if (!$chronos) {
            $chronos = new Chronos();
            $this->getEntityManager()->persist($chronos);
            $this->getEntityManager()->flush();
        }

        return $chronos;
    }
}
