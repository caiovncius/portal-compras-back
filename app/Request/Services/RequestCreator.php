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
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $data['offer_id'] = $data['offerId'];
            $data['pharmacy_id'] = $data['pharmacyId'];
            $data['status'] = 0;
            $model = Request::create($data);

            if (isset($data['products'])) {
                foreach ($data['products'] as $data) {
                    $model->products()->attach($data['id'], ['qtd' => $data['qtd']]);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
