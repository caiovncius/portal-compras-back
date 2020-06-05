<?php

namespace App\Distributor\Contracts;

interface DistributorCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
