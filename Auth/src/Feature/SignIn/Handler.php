<?php

namespace Razikov\AtesAuth\Feature\SignIn;

use Razikov\AtesAuth\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Срабатывает, когда назначается исполнитель. Читает событие taskAssigned
     */
    public function __invoke(Command $command)
    {

    }
}
