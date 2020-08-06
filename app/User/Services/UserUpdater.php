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
    public function update(User $user, array $data)
    {
        try {
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone_1 = $data['phone1'];
            $user->phone_2 = $data['phone2'];
            $user->status = $data['status'];
            $user->type = $data['type'];
            $user->profile_id = $data['profileId'];
            $user->updated_id = auth()->user()->id;
            $user->save();

            if (isset($data['pharmacies'])) {
                $user->pharmacies()->detach();
                foreach ($data['pharmacies'] as $data) {
                    $user->pharmacies()->attach($data['id']);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
