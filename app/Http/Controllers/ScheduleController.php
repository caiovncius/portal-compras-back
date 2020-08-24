<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\Request;
use App\Services\FileReturn;
use App\Services\RequestToFile;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function send(Request $request)
    {
        $distributor = $request->offer->partners()->first();
        //foreach($request->offer->partners as $distributor) {
            $model = Distributor::find($distributor->id)->connection;
            $connection = (new FtpService)->setConnection($model);
            $file = (new RequestToFile)->createFile($request);
            $upload = (new RequestToFile)->uploadFile($file, $model->path_send);
        //}

        /*
        * salva o distribuidor e a prioridade, pra ter como referência
        * e pegar o próximo caso o atual não atenda o pedido
        */
        $request->partner_id = $distributor->id;
        $request->priority = $distributor->pivot->priority;
        $request->save();
        return true;
    }

    public function check()
    {
        $requests = Request::where('status', 0)->get();
        foreach($request as $request) {
            $model = $request->partner->connection;
            $connection = (new FtpService)->setConnection($model);
            $file = (new RequestToFile)->filename($request);
            $filename = str_replace('ped', 'not', $file);
            $get = (new FileReturn)->file($model->path_return.'/'.$filename);

            //concluir pra ver se o pedido foi atendido
            //se não, envia para um próximo distribuidor
        }
    }
}
