<?php

namespace App\DistributorConnection\Services;

use App\Distributor;
use App\DistributorConnection;
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
            $data['distributor_id'] = $data['distributorId'];
            $data['ftp_active'] = $data['isFtpActive'];
            $data['transferency'] = $data['transferMode'];
            $data['path_send'] = $data['sendDirectory'];
            $data['path_return'] = $data['returnDirectory'];

            $distributor->connection()->updateOrCreate(['distributor_id' => $data['distributorId']], $data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
