<?php

namespace Razikov\AtesTaskTracker\Model;

interface BaseEventCommand
{
    public function toMessage(): array;
    public static function createFromMessage(array $message): ?BaseEventCommand;
}
