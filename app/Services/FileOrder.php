<?php

namespace App\Services;

class FileOrder
{
    public function file($path) {
        $file = \Storage::disk('onthefly')->get($path);
        
        $file = explode(PHP_EOL, $file);
        $arr = [];
        foreach(array_filter($file) as $line) {
            if (substr($line, 0, 1) == 1) {
                $arr['header'] = $this->header($line);
            } else if (substr($line, 0, 1) == 3) {
                $arr['footer'] = $this->footer($line);
            } else {
                $arr['items'][] = $this->item($line);
            }
        }
        
        return $arr;
    }

    public function header($line)
    {
        return [
            'type'              => substr($line, 0, 1),
            'code'              => substr($line, 1, 6),
            'order'             => substr($line, 7, 12),
            'date'              => substr($line, 19, 8),
            'condition'         => substr($line, 27, 1),
            'typeOrder'         => substr($line, 28, 1),
            'typeReturn'        => substr($line, 29, 1),
            'version'           => substr($line, 30, 1),
            'integral'          => substr($line, 31, 1),
            'complement'        => substr($line, 32, 3),
            'orderDistributor'  => substr($line, 35, 5),
            'versionPE'         => substr($line, 40, 5),
            'offer'             => substr($line, 45, 5),
            'deadline'         => substr($line, 50, 3),
            'consult'           => substr($line, 53, 1),
            'cnpj'              => substr($line, 54, 14),
        ];
    }

    public function item($line)
    {
        return [
            'type'  => substr($line, 0, 1),
            'code'  => substr($line, 1, 14),
            'qtd'   => substr($line, 15, 5),
            'price' => substr($line, 20, 13),
        ];
    }

    public function footer($line)
    {
        return [
            'type'       => substr($line, 0, 1),
            'order'      => substr($line, 1, 12),
            'qtdItems'   => substr($line, 13, 5),
            'qtdUnities' => substr($line, 18, 10),
            'complement' => substr($line, 28, 3),
        ];
    }

}
