<?php

namespace App\Request\Contracts;

interface RequestCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
