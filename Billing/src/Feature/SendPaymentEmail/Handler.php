<?php

namespace Razikov\AtesBilling\Feature\SendPaymentEmail;

class Handler
{
    /**
     * Срабатывает, когда назначается выплата. Читает событие paymentPerDay
     */
    public function handle(Command $command)
    {
        // отправить письмо с выручкой
    }
}
