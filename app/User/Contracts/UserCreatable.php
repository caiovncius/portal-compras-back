<?php


namespace App\User\Contracts;


interface UserCreatable
{
    /**
     * @param array $userData
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $userData);
}
