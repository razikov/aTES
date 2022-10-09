<?php

namespace Razikov\AtesBilling\Controller;

use Razikov\AtesBilling\Feature\Payday\Command as PaydayCommand;
use Razikov\AtesBilling\Feature\TaskCompleted\Command;
use Razikov\AtesBilling\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends AbstractController
{
    #[Route('/dev/day-ended', methods: ['PUT'], name: 'dev_day_ended')]
    public function dayEnded(
        MessageBusInterface $bus
    ): Response {
        $bus->dispatch(new PaydayCommand());

        return $this->json([
            'success' => true,
        ]);
    }
}
