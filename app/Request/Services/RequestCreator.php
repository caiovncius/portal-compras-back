<?php

namespace App\Request\Services;

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

            $data['updated_id'] = auth()->guard('api')->user()->id;
            $data['pharmacy_id'] = $data['pharmacyId'];
            $data['requestable_id'] = $data['modelId'];
            $data['requestable_type'] = $type;
            $data['status'] = 'NOT_SEND';
            $model = Request::create($data);

            $model->historics()->create([
                'user' => auth()->guard('api')->user()->name,
                'action' => 'Pedido criado',
                'status' => 'ENVIADO'
            ]);

            if (isset($data['products'])) {
                foreach ($data['products'] as $product) {
                    $model->products()->attach($product['productId'], [
                        'qtd' => $product['quantity'],
                        'status' => 'CREATED',
                        'value' => $product['value']
                    ]);
                }
            }

            if ($data['modelType'] == 'OFFER') {
                (new RequestOffer())->send($model);
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
