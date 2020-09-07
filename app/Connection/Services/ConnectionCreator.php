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
            $data['ftp_active'] = $data['isFtpActive'];
            $data['transferency'] = $data['transferMode'];
            $data['path_send'] = $data['sendDirectory'];
            $data['path_return'] = $data['returnDirectory'];
            $data['updated_id'] = auth()->guard('api')->user()->id;

            $model->connection()->save($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
