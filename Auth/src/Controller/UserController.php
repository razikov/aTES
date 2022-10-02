<?php

namespace Razikov\AtesAuth\Controller;

use Razikov\AtesAuth\Feature\CreateUser\Command as CreateUserCommand;
use Razikov\AtesAuth\Feature\CreateUser\UserCreatedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/v1/user', methods: ['POST'], name: 'user_create')]
    public function create(
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $data = json_decode($request->getContent());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid data', 400);
        }

        // @todo validate
        $bus->dispatch(new CreateUserCommand(
            $data->email,
            $data->password,
            $data->role
        ));

        return $this->json([
            'success' => true,
        ]);
    }
}
