<?php

namespace Razikov\AtesAuth\Feature\SignIn;

use Razikov\AtesAuth\Repository\UserRepository;

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
    public function handle(Command $command)
    {

    }
}
