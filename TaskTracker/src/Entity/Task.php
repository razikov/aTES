<?php

namespace Razikov\AtesTaskTracker\Entity;

use Razikov\AtesTaskTracker\Model\TaskId;
use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesTaskTracker\Repository\TaskRepository;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", unique: true)]
    private string $id;
    #[ORM\Column(length: 255, nullable: true)]
    private string $title;
    #[ORM\Column(length: 255, nullable: true)]
    private string $jira_id;
    #[ORM\Column(type: 'text')]
    private string $description;
    #[ORM\Column(length: 255)]
    private string $status;
    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "responsible_id", referencedColumnName: "id")]
    private User $responsible;

    public function __construct(
        TaskId $id,
        string $title,
        string $jira_id,
        string $description,
        User $responsible
    ) {
        $this->id = $id->getValue();
        $this->title = $title;
        $this->jira_id = $jira_id;
        $this->status = 'open';
        $this->description = $description;
        $this->assign($responsible);
    }

    public function complete()
    {
        if ($this->status != 'open') {
            throw new \DomainException("Завершить можно только открытую задачу");
        }
        $this->status = 'complete';
    }

    public function assign(User $responsible)
    {
        if ($this->status != 'open') {
            throw new \DomainException("Сменить исполнителя можно только для открытой задачи");
        }
        $this->responsible = $responsible;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getResponsibleId(): string
    {
        return $this->responsible->getId();
    }
}
