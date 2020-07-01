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
            $model->distributor_id = $distributor->id;
            $model->ftp_active = $data['isFtpActive'];
            $model->transferency = $data['transferMode'];
            $model->host = $data['host'];
            $model->path_send = $data['sendDirectory'];
            $model->login = $data['login'];
            $model->password = $data['password'];
            $model->path_return = $data['returnDirectory'];
            $model->save();
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
