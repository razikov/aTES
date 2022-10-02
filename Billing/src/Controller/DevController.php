<?php

namespace Razikov\AtesBilling\Controller;

use Razikov\AtesBilling\Feature\Payday\Command as PaydayCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class DevController extends AbstractController
{
    public function dayEnded(
        MessageBusInterface $bus
    ): Response {
        $bus->dispatch(new PaydayCommand());

        return $this->json([
            'success' => true,
        ]);
    }
}
