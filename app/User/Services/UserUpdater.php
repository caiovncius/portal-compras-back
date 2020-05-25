<?php


namespace App\User\Services;


use App\User;
use App\User\Contratcs\UserUpdatable;

class UserUpdater implements UserUpdatable
{
    /**
     * @param User $user
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, array $newData)
    {
        try {
            $user->fill($newData);
            $user->save();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
