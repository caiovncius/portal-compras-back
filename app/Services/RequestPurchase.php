<?php

namespace App\Services;

use App\Request as RequestModel;
use App\Returns;
use App\Services\FileReturn;
use App\Services\FtpService;
use App\Services\RequestToFile;

class RequestPurchase
{
    public function send(RequestModel $request)
    {
        $partner = $request->requestable->partner->partner;
        $partnerConnection = $partner->connection;
        
        if ($partnerConnection) {
            $connection = (new FtpService)->setConnection($partnerConnection);
            $file = (new RequestToFile)->createFile($request, $partner);
            $filename = (new RequestToFile)->filename($request);

            $upload = (new RequestToFile)->uploadFile($file, $filename, $partnerConnection->path_send);

            $request->send_date = date('Y-m-d');
            $request->partner_id = $partner->id;
            $request->partner_type = $partnerConnection->connectionable_type;
            $request->priority = 1;
            $request->status = $upload ? 'WAITING_RETURN' : 'ERROR_ON_SEND';
            $request->save();

            $request->historics()->create([
                'user' => 'Sistema',
                'action' => 'Pedido enviado para faturamento',
                'status' => 'Aguardando Retorno'
            ]);
        } else {
            $request->status = 'ERROR_ON_SEND';
            $request->save();

            $request->historics()->create([
                'user' => 'Sistema',
                'action' => 'Pedido com erro no envio',
                'status' => 'Erro no envio'
            ]);
        }
        
        return true;
    }

    public function check()
    {
        $requests = RequestModel::where('status', 'WAITING_RETURN')
                                ->where('requestable_type', 'App\Purchase')
                                ->get();
        foreach ($requests as $request) {
            $partnerConnection = $request->partner->connection;
            $connection = (new FtpService)->setConnection($partnerConnection);
            $file = (new RequestToFile)->filename($request);
            $filename = $partnerConnection->path_return.'/'.str_replace('ped', 'not', $file);
            if (! \Storage::disk('onthefly')->exists($filename)) {
                continue;
            }
            $fileReturn = (new FileReturn)->file($filename);
            foreach ($request->products as $key => $item) {
                $returnItem = $fileReturn['items'][$key];
                $statusProduct = $this->getStatusProduct($returnItem['refuse']);
                $returnModel = Returns::whereCode($returnItem['refuse'])->first();
                $item->pivot->qtd_return = $returnItem['qtdAnswer'] - $returnItem['qtdNotAnswer'];
                $item->pivot->status = $statusProduct;
                $item->pivot->partner_id = $partnerConnection->connectionable_id;
                $item->pivot->partner_type = $partnerConnection->connectionable_type;
                $item->pivot->return_id = $returnModel->id;
                $item->pivot->save();
            }
            $status = $this->getStatus($fileReturn['footer']);
            $request->status = $status;
            $request->save();
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
        } elseif ((int) $footer['qtdItems'] < (int) $footer['qtdItemsAnswer']) {
            $status = 'BILLED_PARTIAL';
        }

        return $status;
    }
}
