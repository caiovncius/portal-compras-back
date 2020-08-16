<?php


namespace App\Profile\Services;


use App\Functionality;
use App\Profile;
use App\Profile\Contracts\ProfileUpdatable;

class ProfileUpdator implements ProfileUpdatable
{
    /**
     * @param Profile $profile
     * @param array $profileData
     * @return bool
     * @throws \Exception
     */
    public function update(Profile $profile, array $data)
    {
        try {
            $profile->fill($data);
            $profile->updated_id = auth()->guard('api')->user()->id;
            $profile->updated_at = date('Y-m-d H:i:s');
            $profile->save();

            if (isset($data['permissions'])) {
                $profile->functionalities()->detach();

                foreach ($data['permissions'] as $function) {
                    $permission = Functionality::where('key', $function['functionality'])->first();
                    $profile->functionalities()->attach($permission->id, ['access_type' => $function['permission']]);
                }
            }

            return true;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
