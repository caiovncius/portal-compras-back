<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RequestToFile
{
    public function createFile($model) {        
        $html = $this->header($model);
        $filename = $this->filename($model);
        $arr = ['qtd' => 0, 'total' => 0];

        $file = fopen(storage_path('app/public/requests/'.$filename), 'wb');

        foreach ($file->products as $product) {
            $arr['qtd'] += 1;
            $arr['total'] += $product->pivot->qtd;
            $html .= $this->item($product, $model);
        }
        $html = $this->footer($model, $arr);

        fwrite($file, $html);
        fclose($file);
        
        return storage_path('app/public/requests/'.$filename);
    }

    public function updloadFile($file, $path)
    {
        Storage::disk('onthefly')->put(
            $path.'/'.$file,
            new File(storage_path('app/public/requests/'.$file)),
            ['visibility' => 'public']
        );

        return true;
    }

    public function filename($model)
    {
        $file = $model->id; //order
        $file .= '.ped.'.date('dmY').'-';
        $file .= 0;

        return $file;
    }

    public function header($model)
    {
        $client  = $model->offer->partners->first();
        $header  = 1; //type
        $header .= str_pad(0, 6, 0, STR_PAD_LEFT); //code
        $header .= str_pad($model->id, 12, 0, STR_PAD_LEFT); //order
        $header .= date('dmY'); //date
        $header .= 1; //condition
        $header .= 'E'; //typeOrder
        $header .= 'D'; //typeReturn
        $header .= 0; //version
        $header .= 'N'; //integral
        $header .= str_pad(0, 3, 0, STR_PAD_LEFT); //complement
        $header .= str_pad(0, 5, 0, STR_PAD_LEFT); //orderDistributor
        $header .= str_pad(0, 5, 0, STR_PAD_LEFT); //versionPE
        $header .= 00000; //offer
        $header .= 000; //deadline
        $header .= 0; //consultr
        $header .= $client->cnpj; //cnpj
        $header .= PHP_EOL;

        return $header;
    }


    public function item($item, $model)
    {
        $html  = 2; //type
        $html .= str_pad(0, 14, 0, STR_PAD_LEFT); //code_ean
        $html .= str_pad(0, 5, 0, STR_PAD_LEFT); //qtd
        $html .= str_pad(0, 13, 0, STR_PAD_LEFT); //price
        $html .= PHP_EOL;

        return $html;
    }

    public function footer($model, $arr)
    {
        $html  = 3; //type
        $html .= str_pad(0, 12, 0, STR_PAD_LEFT); //order
        $html .= str_pad($arr['qtd'], 5, 0, STR_PAD_LEFT); //qtdItems
        $html .= str_pad($arr['total'], 10, 0, STR_PAD_LEFT); //qtdUnities
        $html .= str_pad(0, 3, 0, STR_PAD_LEFT); //complement
        $html .= PHP_EOL;

        return $html;
    }

}
