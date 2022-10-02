<?php

namespace Razikov\AtesTaskTracker\Repository;

use Razikov\AtesTaskTracker\Model\User;

class UserRepository
{
    /**
     * Любой сотрудник кроме менеджера или админа
     * @return User[]
     */
    public function getRandomAvailableAllUsers(): array
    {
    }

    public function getRandomUser(): User
    {
    }
}
