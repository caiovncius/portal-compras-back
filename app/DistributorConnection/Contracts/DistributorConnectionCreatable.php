<?php

namespace App\DistributorConnection\Contracts;

use App\Distributor;

interface DistributorConnectionCreatable
{
    /**
     * @param Distributor $distributor
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(Distributor $distributor, array $data);
}
