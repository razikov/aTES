<?php

namespace Razikov\AtesAuth\Controller;

use Razikov\AtesAuth\Feature\CreateUser\Command as CreateUserCommand;
use Razikov\AtesAuth\Repository\UserRepository;
use Razikov\AtesAuth\Service\StorageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends AbstractController
{
    #[Route('/dev/create-first-admin', methods: ['POST'], name: 'dev_user_create')]
    public function create(
        MessageBusInterface $bus,
        UserRepository $userRepository,
        StorageManager $storageManager
    ): Response {
        $admin = $userRepository->findOneBy(['email' => 'admin@localhost.dev']);
        if (!$admin) {
            $bus->dispatch(new CreateUserCommand(
                'admin@localhost.dev',
                'admin',
                'ROLE_ADMIN'
            ));
        }

        return $this->json([
            'success' => true,
        ]);
    }
}
