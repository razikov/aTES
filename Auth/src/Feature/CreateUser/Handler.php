<?php

namespace Razikov\AtesAuth\Feature\CreateUser;

use Razikov\AtesAuth\Entity\User;
use Razikov\AtesAuth\Model\UserId;
use Razikov\AtesAuth\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class Handler
{
    private StorageManager $storageManager;
    private UserPasswordHasherInterface $passwordHasher;
    private MessageBusInterface $dispatcher;

    public function __construct(
        StorageManager $storageManager,
        UserPasswordHasherInterface $passwordHasher,
        MessageBusInterface $dispatcher
    ) {
        $this->storageManager = $storageManager;
        $this->passwordHasher = $passwordHasher;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Command $command)
    {
        $user = new User(
            $userId = UserId::generate(),
            $command->getRole(),
            $command->getEmail()
        );

        $hashedPassword = $this->passwordHasher->hashPassword($user, $command->getPassword());
        $user->setPassword($hashedPassword);

        $this->storageManager->persist($user);
        $this->storageManager->flush();

        $this->dispatcher->dispatch(new UserCreatedEvent(
            $userId->getValue(),
            $command->getEmail(),
            $command->getRole()->getValue()
        ));
    }
}
