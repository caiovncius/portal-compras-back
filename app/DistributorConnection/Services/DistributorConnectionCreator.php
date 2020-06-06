<?php

namespace App\DistributorConnection\Services;

use App\Distributor;
use App\DistributorConnection\Contracts\DistributorConnectionCreatable;

class DistributorConnectionCreator implements DistributorConnectionCreatable
{
    /**
     * @param Distributor $distributor
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(Distributor $distributor, array $data)
    {
        try {
            $distributor = $distributor->connection()->create($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
