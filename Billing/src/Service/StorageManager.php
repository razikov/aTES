<?php

namespace Razikov\AtesBilling\Service;

use Doctrine\ORM\EntityManagerInterface;

class StorageManager
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist($model): void
    {
        $this->em->persist($model);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
