<?php

namespace App\DistributorConnection\Services;

use App\Distributor;
use App\DistributorConnection;
use App\DistributorConnection\Contracts\DistributorConnectionUpdatable;

class DistributorConnectionUpdater implements DistributorConnectionUpdatable
{
    /**
     * @param Distributor $distributor
     * @param DistributorConnection $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Distributor $distributor, DistributorConnection $model, array $data)
    {
        try {
            $model->fill($data);
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
