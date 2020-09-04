<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\Request as RequestModel;
use App\Returns;
use App\Services\FileReturn;
use App\Services\FtpService;
use App\Services\RequestToFile;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function send(RequestModel $request)
    {

        $distributor = $request->requestable
                               ->partners()
                               ->orderBy('priority', 'ASC')
                               ->first();
        //foreach($request->requestable->partners as $distributor) {
            $model = Distributor::find($distributor->id)->connection;
            $connection = (new FtpService)->setConnection($model);
            $file = (new RequestToFile)->createFile($request, $distributor);
            $filename = (new RequestToFile)->filename($model);

            $upload = (new RequestToFile)->uploadFile($file, $filename, $model->path_send);
        //}

        /*
        * salva o distribuidor e a prioridade, pra ter como referência
        * e pegar o próximo, caso o atual não atenda o pedido
        */
        $request->partner_id = $distributor->id;
        $request->priority = $distributor->pivot->priority;
        $request->status = 'WAITING_RETURN';
        $request->save();
            
        $request->historics()->create([
            'user' => 'Sistema',
            'action' => 'Pedido enviado para faturamento',
            'status' => 'Aguardando Retorno'
        ]);
        
        return true;
    }

    public function check()
    {
        $requests = RequestModel::where('status', 'WAITING_RETURN')->get();
        foreach($requests as $request) {
            $model = $request->partner->connection;
            $connection = (new FtpService)->setConnection($model);
            $file = (new RequestToFile)->filename($request);
            $filename = $model->path_return.'/'.str_replace('ped', 'not', $file);
            if(! \Storage::disk('onthefly')->exists($filename)) {
                continue;
            }
            $get = (new FileReturn)->file($filename);
            foreach($request->products as $key => $item) {
                $returnItem = $get['items'][$key];
                $returnModel = Returns::whereCode($returnItem['refuse'])->first();
                $item->pivot->qtd_return = $returnItem['qtdAnswer'] - $returnItem['qtdNotAnswer'];
                $item->pivot->status = 'ATTENDED';
                $item->pivot->distributor_id = $model->id;
                $item->pivot->return_id = $returnModel->id;
                $item->pivot->save();
            }

            $request->status = 'BILLED';
            $request->save();

            //concluir pra ver se o pedido foi atendido
            //se não, envia para um próximo distribuidor
        }
    }
}
