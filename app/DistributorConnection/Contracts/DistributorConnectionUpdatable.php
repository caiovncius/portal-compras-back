<?php

namespace App\DistributorConnection\Contracts;

use App\Distributor;
use App\DistributorConnection;

interface DistributorConnectionUpdatable
{
    /**
     * @param Distributor $distributor
     * @param DistributorConnection $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Distributor $distributor, DistributorConnection $data, array $newData);
}
