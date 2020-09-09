<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RequestToFile
{
    public function createFile($model, $partner) {
        $html = $this->header($model, $partner);
        $arr = ['qtd' => 0, 'total' => 0];

        foreach ($model->products as $product) {
            $arr['qtd'] += 1;
            $arr['total'] += $product->pivot->qtd;
            $html .= $this->item($product, $model);
        }
        $html .= $this->footer($model, $arr);

        return $html;
    }

    public function uploadFile($file, $filename, $path)
    {
        Storage::disk('onthefly')->put(
            $path.'/'.$filename, $file,
            ['visibility' => 'public']
        );

        return true;
    }

    public function filename($model)
    {
        $date = $model->send_date ? date('dmY', strtotime($model->send_date)) : date('dmY');
        $file = $model->id; //order
        $file .= '.ped.'.$date.'-';
        $file .= 0;

        return $file;
    }

    public function header($model, $partner)
    {
        $client  = $partner->id;
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
        $header .= str_pad($model->requestable->code, 5, 0, STR_PAD_LEFT); //offer
        $header .= 000; //deadline
        $header .= 0; //consultr
        $header .= $partner->cnpj; //cnpj
        $header .= PHP_EOL;

        return $header;
    }


    public function item($item, $model)
    {

        $html  = 2; //type
        $html .= str_pad($item->product->code_ean, 14, 0, STR_PAD_LEFT); //code_ean
        $html .= str_pad($item->pivot->qtd, 5, 0, STR_PAD_LEFT); //qtd
        $html .= str_pad(str_replace('.', '', $item->pivot->value), 13, 0, STR_PAD_LEFT); //price
        $html .= PHP_EOL;

        return $html;
    }

    public function footer($model, $arr)
    {
        $html  = 3; //type
        $html .= str_pad($model->id, 12, 0, STR_PAD_LEFT); //order
        $html .= str_pad($arr['qtd'], 5, 0, STR_PAD_LEFT); //qtdItems
        $html .= str_pad($arr['total'], 10, 0, STR_PAD_LEFT); //qtdUnities
        $html .= str_pad(0, 3, 0, STR_PAD_LEFT); //complement
        $html .= PHP_EOL;

        return $html;
    }

}
