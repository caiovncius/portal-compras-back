<?php


namespace App\Profile\Contracts;


use App\Profile;

interface ProfileUpdatable
{
    /**
     * @param Profile $profile
     * @param array $profileData
     * @return bool
     * @throws \Exception
     */
    public function update(Profile $profile, array $profileData);
}
