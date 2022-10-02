<?php

namespace Razikov\AtesTaskTracker\Controller;

use Razikov\AtesTaskTracker\Feature\GetDashboardView\Command as GetDashboardViewCommand;
use Razikov\AtesTaskTracker\Feature\GetPersonalDashboardView\Command as GetPersonalDashboardViewCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class DashboardController
{
    public function index(
        MessageBusInterface $bus
    ) {
        $result = $bus->dispatch(new GetDashboardViewCommand());
    }

    public function personal(
        MessageBusInterface $bus
    ) {
        $result = $bus->dispatch(new GetPersonalDashboardViewCommand($userId));
    }
}
