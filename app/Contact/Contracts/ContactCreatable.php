<?php

namespace App\Contact\Contracts;

interface ContactCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
