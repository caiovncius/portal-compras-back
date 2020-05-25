<?php


namespace App\User\Contratcs;


interface UserCreatorable
{
    /**
     * @param array $userData
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $userData);
}
