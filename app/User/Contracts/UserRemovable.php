<?php


namespace App\User\Contracts;


use App\User;

interface UserRemovable
{
    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user);
}
