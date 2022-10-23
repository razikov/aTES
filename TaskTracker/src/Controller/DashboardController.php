<?php

namespace Razikov\AtesTaskTracker\Controller;

use Razikov\AtesTaskTracker\Entity\User;
use Razikov\AtesTaskTracker\Feature\GetDashboardView\Command as GetDashboardViewCommand;
use Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView\Command as GetPersonalDashboardViewCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DashboardController extends AbstractController
{
    #[Route('/api/v1/task/dashboard', methods: ['GET'], name: 'task_dashboard')]
    public function index(
        #[CurrentUser] ?User $user,
        MessageBusInterface $bus
    ) {
        if (in_array($user->getRoles()[0], ['ROLE_ADMIN'])) {
            $envelope = $bus->dispatch(new GetDashboardViewCommand());
            $handledStamp = $envelope->last(HandledStamp::class);
            $result = $handledStamp->getResult();
        } else {
            $envelope = $bus->dispatch(new GetPersonalDashboardViewCommand($user->getId()));
            $handledStamp = $envelope->last(HandledStamp::class);
            $result = $handledStamp->getResult();
        }

        return $this->json($result);
    }
}
