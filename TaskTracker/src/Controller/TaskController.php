<?php

namespace Razikov\AtesTaskTracker\Controller;

use Razikov\AtesTaskTracker\Entity\User;
use Razikov\AtesTaskTracker\Feature\CreateTask\Command as CreateTaskCommand;
use Razikov\AtesTaskTracker\Feature\AssignTasks\Command as AssignTasksCommand;
use Razikov\AtesTaskTracker\Feature\CompleteTask\Command as CompleteTaskCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TaskController extends AbstractController
{
    #[Route('/api/v1/task', methods: ['POST'], name: 'task_create')]
    public function create(
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $data = json_decode($request->getContent());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid data', 400);
        }

        // @todo validate
        $bus->dispatch(new CreateTaskCommand(
            $data->description,
            $data->title,
            $data->jiraId
        ));

        return $this->json([
            'success' => true,
        ]);
    }

    #[Route('/api/v1/task/complete', methods: ['PUT'], name: 'task_complete')]
    public function complete(
        #[CurrentUser] ?User $user,
        Request $request,
        MessageBusInterface $bus
    ) {
        $data = json_decode($request->getContent());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid data', 400);
        }

        if (!in_array($user->getRoles()[0], ['ROLE_ADMIN']) || $user->getId() != $data->userId) {
            throw new HttpException("403", "Operation forbidden");
        }

        // @todo validate
        $bus->dispatch(new CompleteTaskCommand(
            $data->taskId,
            $data->userId
        ));

        return $this->json([
            'success' => true,
        ]);
    }

    #[Route('/api/v1/task/shuffle', methods: ['PUT'], name: 'task_shuffle')]
    public function shuffle(
        MessageBusInterface $bus
    ) {
        $bus->dispatch(new AssignTasksCommand());

        return $this->json([
            'success' => true,
        ]);
    }
}
