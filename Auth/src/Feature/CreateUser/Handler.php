<?php

namespace Razikov\AtesAuth\Feature\CreateUser;

use Razikov\AtesAuth\Entity\User;
use Razikov\AtesAuth\Model\UserId;
use Razikov\AtesAuth\Service\StorageManager;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class Handler
{
    private StorageManager $storageManager;
    private MessageBusInterface $dispatcher;

    public function __construct(
        StorageManager $storageManager,
        MessageBusInterface $dispatcher
    ) {
        $this->storageManager = $storageManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Срабатывает, когда назначается исполнитель. Читает событие taskAssigned
     */
    public function __invoke(Command $command)
    {
        $user = new User(
            $userId = UserId::generate(),
            $command->getRole(),
            $command->getPassword(),
            $command->getEmail()
        );

        $this->storageManager->persist($user);
        $this->storageManager->flush();

        $this->dispatcher->dispatch(new UserCreatedEvent(
            $userId->getValue(),
            $command->getRole()->getValue()
        ));
    }
}
