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
    public function update(Profile $profile, array $profileData)
    {
        try {
            $profile->fill($profileData);
            $profile->updated_id = auth()->guard('api')->user()->id;
            $profile->save();

            if (isset($profileData['functions'])) {
                $profile->functionalities()->detach();

                foreach ($profileData['functions'] as $function) {
                    $permission = Functionality::where('key',$function['key'])->first();
                    $profile->functionalities()->attach($permission->id, ['access_type' => $function['permission']]);
                }
            }

            return true;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
