<?php

namespace Razikov\AtesBilling\Controller;

use Razikov\AtesBilling\Model\User;
use Razikov\AtesBilling\Feature\GetDashboardView\Command as GetDashboardViewCommand;
use Razikov\AtesBilling\Feature\GetAnaliticsDashboardView\Command as GetAnaliticDashboardViewCommand;
use Razikov\AtesBilling\Feature\GetPersonalDashboardView\Command as GetPersonalDashboardViewCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DashboardController extends AbstractController
{
    #[Route('/api/v1/dashboard', methods: ['GET'], name: 'dashboard')]
    public function index(
        MessageBusInterface $bus
    ) {
        /** @var User $user */
        $user = $this->getUser();
        if (in_array($user->getRoles()[0], ['ROLE_ADMIN', 'ROLE_ACCOUNTANT'])) {
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

    #[Route('/api/v1/analitic', methods: ['GET'], name: 'analitic')]
    public function analitic(
        MessageBusInterface $bus
    ) {
        $envelope = $bus->dispatch(new GetAnaliticDashboardViewCommand());
        $handledStamp = $envelope->last(HandledStamp::class);
        $result = $handledStamp->getResult();

        return $this->json($result);
    }
}
