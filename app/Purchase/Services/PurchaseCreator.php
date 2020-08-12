<?php

namespace App\Purchase\Services;

use App\Purchase;
use App\Purchase\Contracts\PurchaseCreatable;

class PurchaseCreator implements PurchaseCreatable
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
            $model = Purchase::create($data);

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
