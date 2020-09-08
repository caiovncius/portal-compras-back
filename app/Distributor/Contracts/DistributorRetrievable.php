<?php

namespace App\Distributor\Contracts;

use App\Distributor;

interface DistributorRetrievable
{
    public function getDistributors(array $params = []);

    /**
     * @param Distributor $distributor
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * @throws \Exception
     */
    public function getReturnsByDistributor(\App\Distributor $distributor);
}
