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
            $user->updated_id = auth()->guard('api')->user()->id;
            $user->updated_at = date('Y-m-d H:i:s');

            if (isset($data['username'])) {
                $user->username = $data['username'];
            }

            if (isset($data['manager'])) {
                $user->manager_id = $data['manager'];
            }

            $user->save();

            if (isset($data['pharmacies'])) {
                $user->pharmacies()->detach();
                $collectPharmacies = collect($data['pharmacies']);
                $uniquePharmacies = $collectPharmacies->unique('id');
                foreach ($uniquePharmacies->toArray() as $data) {
                    $user->pharmacies()->attach($data['id']);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
