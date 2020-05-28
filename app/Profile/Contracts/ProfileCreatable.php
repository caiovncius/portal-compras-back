<?php


namespace App\Profile\Contracts;


interface ProfileCreatable
{
    /**
     * @param array $profileData
     * @return bool
     * @throws \Exception
     */
    public function store(array $profileData);
}
