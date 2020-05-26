<?php


namespace App\User\Services;


use App\User;
use App\User\Contracts\UserUpdatable;

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

            $user->name = $newData['name'];
            $user->email = $newData['email'];
            $user->phone_1 = $newData['phone1'];
            $user->phone_2 = $newData['phone2'];
            $user->status = $newData['status'];
            $user->type = $newData['type'];
            $user->profile_id = $newData['profileId'];
            $user->save();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
