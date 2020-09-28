<?php

namespace App\Distributor\Contracts;

use App\Distributor;

interface DistributorUpdatable
{
    /**
     * @param Distributor $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Distributor $data, array $newData);

    /**
     * @param Distributor $distributor
     * @return bool
     */
    public function enable(Distributor $distributor);
}
