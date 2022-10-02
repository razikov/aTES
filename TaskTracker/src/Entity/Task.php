<?php

namespace Razikov\AtesTaskTracker\Entity;

use Razikov\AtesTaskTracker\Model\TaskId;
use Doctrine\ORM\Mapping as ORM;
use Razikov\AtesTaskTracker\Repository\TaskRepository;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $id;
    #[ORM\Column(type: 'text')]
    private string $description;
    #[ORM\Column(length: 255)]
    private string $status;
    #[ORM\OneToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "responsible_id", referencedColumnName: "id")]
    private User $responsible;

    public function __construct(
        TaskId $id,
        string $description,
        User $responsible
    ) {
        $this->id = $id->getValue();
        $this->status = 'opened';
        $this->description = $description;
        $this->assign($responsible);
    }

    public function complete()
    {
        $this->status = 'completed';
    }

    public function assign(User $responsible)
    {
        $this->responsible = $responsible;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
