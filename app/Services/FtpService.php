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

    public function readFilePrice($path)
    {
        $file = \Storage::disk('onthefly')->get($path);
        $file = explode(PHP_EOL, $file);
        $lines = [];
        foreach(array_filter($file) as $line) {
            $data = explode(';', $line);
            $arr['cnpj'] = $data[0];
            $arr['code_ean'] = $data[1];
            $arr['price'] = $data[2];
            $arr['discount'] = $data[3];
            $arr['days'] = $data[4];
            $arr['value_min'] = $data[5];
            $arr['value'] = $data[6];
            $lines[] = $arr;
        }
        
        return $lines;
    }

    public function readFileRoute($path)
    {
        $file = \Storage::disk('onthefly')->get($path);
        $file = explode(PHP_EOL, $file);
        $lines = [];
        foreach(array_filter($file) as $line) {
            $data = explode(';', $line);
            $arr['cnpj'] = $data[0];
            $arr['time'] = $data[1];
            $lines[] = $arr;
        }

        return $data;
    }

}
