<?php

namespace App\Purchase\Contracts;

interface PurchaseCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
