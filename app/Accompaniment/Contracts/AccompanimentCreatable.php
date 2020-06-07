<?php

namespace App\Accompaniment\Contracts;

interface AccompanimentCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
