<?php

namespace Razikov\AtesBilling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesBilling\Repository\TaskRepository;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true)]
    private string $id;
    #[ORM\Column(type: 'text')]
    private string $description;
    #[ORM\Column]
    private int $penalty;
    #[ORM\Column]
    private int $reward;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jiraId;

    public function __construct(string $id, string $description, ?string $title = null, ?string $jiraId = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->jiraId = $jiraId;
        $this->description = $description;
        $this->penalty = rand(10, 20) * -1;
        $this->reward = rand(20, 40);
    }

    public function getPenalty()
    {
        return $this->penalty;
    }

    public function getReward()
    {
        return $this->reward;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function getJiraId(): string
    {
        return $this->jiraId ?? '';
    }
}
