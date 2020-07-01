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
            $connection = new DistributorConnection();
            $connection->distributor_id = $distributor->id;
            $connection->ftp_active = $data['isFtpActive'];
            $connection->transferency = $data['transferMode'];
            $connection->host = $data['host'];
            $connection->path_send = $data['sendDirectory'];
            $connection->login = $data['login'];
            $connection->password = $data['password'];
            $connection->path_return = $data['returnDirectory'];
            $connection->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
