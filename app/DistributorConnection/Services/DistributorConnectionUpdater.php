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
            $data['distributor_id'] = $data['distributorId'];
            $data['ftp_active'] = $data['isFtpActive'];
            $data['transferency'] = $data['transferMode'];
            $data['path_send'] = $data['sendDirectory'];
            $data['path_return'] = $data['returnDirectory'];

            $distributor->connection()->updateOrCreate(['distributor_id' => $data['distributorId']], $data);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
