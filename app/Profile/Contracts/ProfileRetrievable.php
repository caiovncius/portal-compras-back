<?php


namespace App\Profile\Contracts;


use App\Profile;

interface ProfileRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function profiles(array $params);
}
