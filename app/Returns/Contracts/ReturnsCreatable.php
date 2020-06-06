<?php

namespace App\Returns\Contracts;

interface ReturnsCreatable
{
    /**
     * @param array $data
     * @Returns bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
