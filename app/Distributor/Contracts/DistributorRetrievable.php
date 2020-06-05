<?php

namespace App\Distributor\Contracts;

interface DistributorRetrievable
{
    public function getDistributors(array $params = []);
}
