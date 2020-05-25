<?php


namespace App\User\Contracts;


use App\User;

interface UserUpdatable
{
    /**
     * @param User $user
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(User $user, array $newData);
}
