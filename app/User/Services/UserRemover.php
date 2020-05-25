<?php


namespace App\User\Services;


use App\User;
use App\User\Contracts\UserRemovable;

class UserRemover implements UserRemovable
{
    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user)
    {
        try {
            $user->delete();
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
