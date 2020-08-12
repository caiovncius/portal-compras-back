<?php

namespace App\Services;

class FileReturn
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
            'type'      => substr($line, 0, 1),
            'code'      => substr($line, 1, 6),
            'order'     => substr($line, 7, 12),
            'date'      => substr($line, 19, 8),
            'condition' => substr($line, 27, 1),
            'time'      => substr($line, 28, 8),
            'number'    => substr($line, 36, 12),
            'status'    => substr($line, 48, 2),
            'reserved'  => substr($line, 50, 18),
            'consult'   => substr($line, 68, 1),
            'cnpj'      => substr($line, 69, 14)
        ];
    }

    public function item($line)
    {
        return [
            'type'          => substr($line, 0, 1),
            'code'          => substr($line, 1, 14),
            'qtdAnswer'     => substr($line, 15, 5),
            'qtdNotAnswer'  => substr($line, 20, 5),
            'refuse'        => substr($line, 25, 2),
        ];
    }

    public function footer($line)
    {
        return [
            'type'              => substr($line, 0, 1),
            'order'             => substr($line, 1, 12),
            'qtdItems'          => substr($line, 13, 5),
            'qtdItemsAnswer'    => substr($line, 18, 5),
            'qtdItemsNotAnswer' => substr($line, 23, 5),
            'complement'        => substr($line, 28, 14),
        ];
    }

}
