<?php

namespace Razikov\AtesBilling\Feature\Payday;

use Razikov\AtesBilling\Entity\AccountOperationLog;
use Razikov\AtesBilling\Entity\Chronos;
use Razikov\AtesBilling\Model\AccountOperationType;
use Razikov\AtesBilling\Repository\AccountRepository;
use Razikov\AtesBilling\Repository\ChronosRepository;
use Razikov\AtesBilling\Service\StorageManager;
use Razikov\AtesBilling\Feature\SendPaymentEmail\Command as SendPaymentEmailCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class Handler
{
    private AccountRepository $accountRepository;
    private StorageManager $storageManager;
    private ChronosRepository $chronosRepository;
    private MessageBusInterface $dispatcher;

    public function __construct(
        AccountRepository $accountRepository,
        StorageManager $storageManager,
        ChronosRepository $chronosRepository,
        MessageBusInterface $dispatcher
    ) {
        $this->accountRepository = $accountRepository;
        $this->storageManager = $storageManager;
        $this->chronosRepository = $chronosRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Срабатывает, когда заканчивается день. Читает событие dayEnded
     * @todo должен обойти все аккаунты, после обхода увеличить день
     */
    public function __invoke(Command $command)
    {
        $account = $this->accountRepository->getById($command->getUserId());

        $amount = $account->payday();
        $day = $command->getDay();

        if ($amount > 0) {
            $log = new AccountOperationLog(
                $command->getUserId(),
                AccountOperationType::createPayday(),
                $amount,
                "payment per day #{$day}",
                $day
            );

            $this->storageManager->persist($account);
            $this->storageManager->persist($log);
            $this->storageManager->flush();

            $this->dispatcher->dispatch(new SendPaymentEmailCommand());
        }
    }
}
