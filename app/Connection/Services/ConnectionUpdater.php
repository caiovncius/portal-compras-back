<?php

namespace App\Connection\Services;

use App\Distributor;
use App\Connection\Contracts\ConnectionUpdatable;

class ConnectionUpdater implements ConnectionUpdatable
{
    /**
     * @param $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update($model, array $data)
    {
        try {
            $data['ftp_active'] = $data['isFtpActive'];
            $data['transferency'] = $data['transferMode'];
            $data['path_send'] = $data['sendDirectory'];
            $data['path_return'] = $data['returnDirectory'];
            unset($data['programId']);
            unset($data['isFtpActive']);
            unset($data['transferMode']);
            unset($data['sendDirectory']);
            unset($data['returnDirectory']);
            
            $model->connection()->update($data);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
