<?php

namespace App\Publicity\Contracts;

interface PublicityCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
