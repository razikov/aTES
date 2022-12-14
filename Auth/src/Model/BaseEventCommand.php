<?php

namespace Razikov\AtesAuth\Model;

interface BaseEventCommand
{
    public function toMessage(): array;
    public static function createFromMessage(array $message): ?BaseEventCommand;
}
