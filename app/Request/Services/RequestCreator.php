<?php

namespace App\Request\Services;

use App\Request;
use App\Request\Contracts\RequestCreatable;

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
            $data['offer_id'] = $data['offerId'];
            $data['pharmacy_id'] = $data['pharmacyId'];
            $data['requestable_id'] = $data['modelId'];
            $data['requestable_type'] = $type;
            $data['status'] = 0;
            $model = Request::create($data);

            $model->historics()->create([
                'user' => auth()->guard('api')->user()->name,
                'action' => 'Pedido criado',
                'status' => 'ENVIADO'
            ]);

            if (isset($data['products'])) {
                foreach ($data['products'] as $product) {
                    $model->products()->attach($product['productId'], ['qtd' => $data['quantity']]);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
