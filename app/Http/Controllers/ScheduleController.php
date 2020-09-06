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
    public function send(RequestModel $request, $firstSend = true)
    {
        $distributor = $request->requestable
                               ->partners()
                               ->orderBy('priority', 'ASC');
        dd($distributor);
        if (! $firstSend) {
            $distributor = $distributor->skip($request->priority);
        }

        $distributor = $distributor->first();


        $model = Distributor::find($distributor->id)->connection;
        $connection = (new FtpService)->setConnection($model);
        $file = (new RequestToFile)->createFile($request, $distributor);
        $filename = (new RequestToFile)->filename($model);

        $upload = (new RequestToFile)->uploadFile($file, $filename, $model->path_send);

        if ($firstSend) {
            $request->send_date = date('Y-m-d');
        }
        $request->partner_id = $distributor->id;
        $request->priority = $request->priority ? $request->priority++ : 1;
        $request->status = $upload ? 'WAITING_RETURN' : 'ERROR_ON_SEND';
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
            $fileReturn = (new FileReturn)->file($filename);
            foreach($request->products as $key => $item) {
                $returnItem = $fileReturn['items'][$key];
                $statusProduct = $this->getStatusProduct($returnItem['refuse']);
                $returnModel = Returns::whereCode($returnItem['refuse'])->first();
                $item->pivot->qtd_return = $returnItem['qtdAnswer'] - $returnItem['qtdNotAnswer'];
                $item->pivot->status = $statusProduct;
                $item->pivot->distributor_id = $model->id;
                $item->pivot->return_id = $returnModel->id;
                $item->pivot->save();
            }
            $status = $this->getStatus($fileReturn['footer']);
            $request->status = $status;
            $request->save();

            if ($status !== 'BILLED') {
                $this->send($request, false);
            }
        }
    }

    public function getStatusProduct($refuse)
    {
        switch ($refuse) {
            case '13': //produto atendido
                return 'ATTENDED';
                break;
            case '14': //produto atendido partialmente
                return 'ATTENDED_PARTIAL';
                break;
            case '06': //falta no estoque
            default:
                return 'NOT_ATTENDED';
                break;
        }
    }

    public function getStatus($footer)
    {
        $status = 'BILLED';
        if ((int) $footer['qtdItemsAnswer'] == 0) {
            $status = 'NOT_BILLED';
        } else if ((int) $footer['qtdItems'] - (int) $footer['qtdItemsAnswer']) {
            $status = 'BILLED_PARTIAL';
        }

        return $status;
    }

}
