<?php

namespace Razikov\AtesAuth\Feature\Dummy;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    public function __invoke(Command $command)
    {

    }
}
