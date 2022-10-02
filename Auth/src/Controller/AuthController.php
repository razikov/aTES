<?php

namespace Razikov\AtesAuth\Controller;

use Razikov\AtesAuth\Feature\SignIn\Command as SignInCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/v1/auth/signIn', methods: ['POST'], name: 'auth_sign_in')]
    public function signIn(
        MessageBusInterface $bus
    ): Response {
        $bus->dispatch(new SignInCommand(

        ));

        return $this->json([
            'token' => $token,
        ]);
    }
}
