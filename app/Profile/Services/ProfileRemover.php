<?php


namespace App\Profile\Services;


use App\Profile;
use App\Profile\Contracts\ProfileRemovable;

class ProfileRemover implements ProfileRemovable
{

    /**
     * @param Profile $profile
     * @return bool
     * @throws \Exception
     */
    public function delete(Profile $profile)
    {
        try {
            $profile->functionalities()->detach();
            $profile->delete();
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
