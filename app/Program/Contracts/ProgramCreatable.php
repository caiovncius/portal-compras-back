<?php

namespace App\Program\Contracts;

interface ProgramCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
