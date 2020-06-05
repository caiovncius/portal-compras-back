<?php

namespace App\Distributor\Contracts;

use App\Distributor;

interface DistributorRemovable
{
    /**
     * @param Distributor $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Distributor $data);
}
