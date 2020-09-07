<?php

namespace App\Connection\Services;

use App\Distributor;
use App\Connection;
use App\Connection\Contracts\ConnectionCreatable;

class ConnectionCreator implements ConnectionCreatable
{
    /**
     * @param $model
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store($model, array $data)
    {
        try {
            $connection = new Connection();
            $connection->ftp_active = $data['isFtpActive'];
            $connection->transferency = $data['transferMode'];
            $connection->path_send = $data['sendDirectory'];
            $connection->path_return = $data['returnDirectory'];
            $connection->updated_id = auth()->guard('api')->user()->id;

            $model->connection()->save($connection);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
