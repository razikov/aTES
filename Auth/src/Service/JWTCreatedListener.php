<?php

namespace Razikov\AtesAuth\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Razikov\AtesAuth\Entity\User;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        /** @var User $user */
        $user = $event->getUser();
        $payload['userId'] = $user->getPublicId();

        $event->setData($payload);
    }
}
