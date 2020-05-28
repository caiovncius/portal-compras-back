<?php


namespace App\Profile\Contracts;


use App\Profile;

interface ProfileRemovable
{

    /**
     * @param Profile $profile
     * @return bool
     * @throws \Exception
     */
    public function delete(Profile $profile);
}
