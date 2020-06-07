<?php

namespace App\User\Contracts;

interface UserRetrievable
{
    public function getUsers(array $querySearchParams = []);
}
