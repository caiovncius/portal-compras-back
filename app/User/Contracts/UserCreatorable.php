<?php


namespace App\User\Contracts;


interface UserCreatorable
{
    /**
     * @param array $userData
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $userData);
}
