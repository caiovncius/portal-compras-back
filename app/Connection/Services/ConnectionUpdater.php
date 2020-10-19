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

            $model->connection()->update([
                'ftp_active' => $data['isFtpActive'] ,
                'transferency' => $data['transferMode'],
                'path_send' => $data['sendDirectory'],
                'login' => $data['login'],
                'path_return' => $data['returnDirectory'],
                'remove_file' => isset($data['removeFile']) ? $data['removeFile'] : false,
                'mask' => isset($data['mask']) ? $data['mask'] : null,
                'port' => isset($data['port']) ? $data['port'] : null,
                'updated_id' => auth()->guard('api')->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
