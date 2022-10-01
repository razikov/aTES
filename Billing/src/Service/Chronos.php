<?php

namespace Razikov\AtesBilling\Service;

class Chronos
{
    private int $day;

    public function getDay(): int
    {
        return $this->day;
    }

    public function nextDay()
    {
        $this->day += 1;
    }
}
