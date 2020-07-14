<?php

namespace App\Services;

class FtpService
{
    public function setConnection($params)
    {
        config(['filesystems.disks.onthefly' => [
            'driver' => 'ftp',
            'host' => $params->host,
            'username' => $params->login,
            'password' => $params->password
        ]]);

        return true;
    }
}
