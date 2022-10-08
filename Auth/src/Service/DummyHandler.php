<?php

namespace Razikov\AtesAuth\Service;

use Razikov\AtesAuth\Model\BaseEventCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DummyHandler
{
    public function __invoke(BaseEventCommand $command)
    {

    }
}
