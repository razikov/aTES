<?php

namespace Razikov\AtesBilling\Feature\SendPaymentEmail;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class Handler
{
    /**
     * Срабатывает, когда назначается выплата. Читает событие paymentPerDay
     */
    public function __invoke(Command $command)
    {
        // отправить письмо с выручкой
    }
}
