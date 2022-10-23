<?php

namespace Razikov\AtesBilling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\ChronosRepository;

#[ORM\Entity(repositoryClass: ChronosRepository::class)]
class Chronos
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $id;
    #[ORM\Column]
    private int $day;

    public function __construct()
    {
        $this->id = 'OnlyOneAllowed';
        $this->day = 1;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function nextDay()
    {
        $this->day += 1;
    }
}
