<?php

namespace App\Request\Services;

use App\Jobs\AutomaticOffers;
use App\Jobs\ManualOffers;
use App\Offer;
use App\Purchase;
use App\Request;
use App\Request\Contracts\RequestCreatable;
use App\Services\RequestOffer;

class RequestCreator implements RequestCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $type = $data['modelType'] == 'OFFER' ? 'App\Offer' : 'App\Purchase';

            if ($data['modelType'] == 'OFFER') {
                $model = Offer::find($data['modelId']);
            } else {
                $model = Purchase::find($data['modelId']);
            }

            if (is_null($model)) {
                throw new \Exception(sprintf('Tipo %s não encontrado', $data['modelId']));
            }

            $data['updated_id'] = auth()->guard('api')->user()->id;
            $data['pharmacy_id'] = $data['pharmacyId'];
            $data['requestable_id'] = $data['modelId'];
            $data['requestable_type'] = $type;
            $data['status'] = 'NOT_SEND';
            $request = Request::create($data);

            $request->historics()->create([
                'user' => auth()->guard('api')->user()->name,
                'action' => 'Pedido criado',
                'status' => 'ENVIADO'
            ]);

            if (isset($data['products'])) {
                foreach ($data['products'] as $product) {
                    $request->products()->attach($product['productId'], [
                        'qtd' => $product['quantity'],
                        'status' => 'CREATED',
                        'value' => $product['value']
                    ]);
                }
            }

            if ($model->send_type === 'AUTOMATIC') {
                AutomaticOffers::dispatch($request);
            }

            if ($model->send_type === 'MANUAL' && $data['modelType'] == 'OFFER') {
                ManualOffers::dispatch($model);
            }

            return $request;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
