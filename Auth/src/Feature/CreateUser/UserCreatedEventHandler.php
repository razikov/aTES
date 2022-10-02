<?php

namespace Razikov\AtesAuth\Feature\CreateUser;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserCreatedEventHandler
{
    public function __invoke(UserCreatedEvent $event)
    {

    }
}
